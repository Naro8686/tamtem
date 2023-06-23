<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Organization;
use App\Models\StatisticRequestsLog;
use App\Models\PointPerEvent;
use App\Models\Privileges;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendToAgentNewOrganizationBinding;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function runGetStatisticFromTamtem()
	{

		try{

            //показать, где статусы организации Активирована или не активирована
            $user = User::Active()->with('organizations')->whereHas('organizations', function($q){
                $q->whereIn('organizations.status', array( Organization::ORGANIZATION_STATUS_ACTIVATED,
                                                        Organization::ORGANIZATION_STATUS_UNACTIVATED));
            });
            // id агентов , по которым хотим получить данные
            $userIds = $user->pluck('unique_id')->implode(',');
//Log::info('inn:'.$userIds);
//dd( $userIds);
            // дата последнего запроса
            $last_prev_request_date = StatisticRequestsLog::lastRequestData();
//dd($last_prev_request_date );
            // запрос статистики
            $URI = config('constants.tamtem.statistic-api');
 
            $params = array (
                'agents' => $userIds,
                'prev_request_date' =>  $last_prev_request_date,
            );

            ////////////////////////////////////////////////////////

            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, $URI);
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            // указываем, что у нас POST запрос
            curl_setopt($ch, CURLOPT_POST, 1);
            // добавляем переменные
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            
            $response = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);

            ///////////////////////////////////////////////////
            
            $dataToStatisticRequestsLog =[
                'url' => $URI,
                'post_data' => json_encode($params),
                'return_data' => $response,
                'status' => $info['http_code'],
                'request_date' => now(), //date_create("2018-01-17 00:00:00"), // now(),
                'text' => 'Agents statistic get from post request',
                'result' => false,
            ];
      
            // если какая-то ошибка в механизме запросов
            if ($response === FALSE) {
                $dataToStatisticRequestsLog['result']  = false;
                $dataToStatisticRequestsLog['return_data']  = curl_error($ch);
                StatisticRequestsLog::Create($dataToStatisticRequestsLog);
                return;
            }

            if (strpos($response, 'ccess denied') !== false) {
                $dataToStatisticRequestsLog['result']  = false;
                $dataToStatisticRequestsLog['return_data']  = $response;
                StatisticRequestsLog::Create($dataToStatisticRequestsLog);
                return;
            }

            $response = \json_decode($response, true); //dd($response);

            if(json_last_error() != JSON_ERROR_NONE){
                StatisticRequestsLog::Create($dataToStatisticRequestsLog);
                return;
            }

            $dataToStatisticRequestsLog['result'] = $result = $response['result'];

              // запишем в лог результаты запроса
            StatisticRequestsLog::Create($dataToStatisticRequestsLog);
        
            if($result === true){

                $data = $response['data'];
//dd($data);
                // кол-во баллов за событие
                $pountPerEvent = PointPerEvent::select('event_name', 'point')->get()->keyBy('event_name')->toArray();
                    $point_per_set_winner = (isset($pountPerEvent['set_winner']['point'] )) ? $pountPerEvent['set_winner']['point'] : 100;
                    $point_per_response = (isset($pountPerEvent['response']['point'] )) ? $pountPerEvent['response']['point'] : 50;
										//Log::info('inn:'.$data);
								                // перебор агентов по их unique_id
                foreach ($data as $unique_id => $organizations) {

                    $curUser = null; 
                    if($curUser = User::where('unique_id', '=', $unique_id)->first()){

                        $userProcent = $curUser->privilege()->first()->procent;
                        $dataToUserLK['ballance'] = $curUser->ballance;
                        $dataToUserLK['points'] = 0;
//dd($dataToUserLK['ballance']);
                        foreach ($organizations as $inn => $organization) {
									

                            if($curOrganization = $curUser->organizations()->where('inn', '=', $inn)->first()){

                                // сколько денег начислять юзеру = разница в баллансе организации между пришедшей и которая была , умножить на процент /100
                                $userBallanceCurOrganization = ((int) $organization['response_ballance'] - (int) $curOrganization->response_ballance) * $userProcent / 100;
                                if($userBallanceCurOrganization > 0){
                                    $dataToUserLK['ballance'] += $userBallanceCurOrganization;
                                }
                                $dataToUpdate = [
                                    'name' => $organization['name'],
                                    'category_name' => $organization['category_name'],
                                    'points_set_winner' => $organization['points_set_winner'] * $point_per_set_winner,
                                    'points_response' => $organization['points_response'] * $point_per_response,
                                    'response_ballance' => $organization['response_ballance'],
                                ];

                                // добавим баллы в общее количество баллов юзера
                                //$dataToUserLK['points'] += ($dataToUpdate['points_set_winner'] + $dataToUpdate['points_response']);

                                // если еще не активирована организация у агента
                                if($curOrganization->status !== Organization::ORGANIZATION_STATUS_ACTIVATED){
                                    $dataToUpdate['status'] = Organization::ORGANIZATION_STATUS_ACTIVATED;
                                    $dataToUpdate['activated_at'] = now();

                                    $subject ='Успешно добавилась компания в Ваш портфель компаний на сайте agent.tamtem.ru';
                                    $msg = "Компания: " . $organization['name'] . ", ИНН: " . $curOrganization->inn . " успешно зарегистрировалась на сайте tamtem.ru и закрепилась в Вашем профиле.";
                                    $curUser->notify(new \App\Notifications\ToAgantIsNewOrganizationBinding($subject, $msg));
                                }

                                $curOrganization->update($dataToUpdate);
                            }
                            else{
                                continue;
                            }
                        }

                        // обновим балланс юзера в его кабинете, количество баллов и его привилегии
                        $dataToUserLK['privilege_id'] = Privileges::where('point', '<=', $dataToUserLK['points'])->orderBy('point', 'DESC')->first()->id;

                        // посчитаем баллы
                        $organizationToSum = $curUser->organizationsActive;
                        $dataToUserLK['points'] = $organizationToSum->sum('points_set_winner') + $organizationToSum->sum('points_response') + $curUser->points_from_agents;

                        $curUser->update($dataToUserLK);

                    }
                    else{
                        continue;
                    }
                  //  dd($organizations);
                }
            }
            else{
                return null;
            }
						 
		}
		catch(\Throwable $e){
			return response($e->getMessage());
		}
	}
}
