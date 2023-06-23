<?php

namespace App\Http\Controllers\YandexPayout;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiControllerTrait;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Classes\YandexMoney\Settings;
use App\Services\FinanceOperation\FinanceOperationService;

use Illuminate\Support\Facades\Auth;


class YandexPayoutController extends Controller
{
    use ApiControllerTrait;

    public $authUser;
    public $settings;
    public $provider;
    public $depositionTo; // куда выводить деньги

    /**
    * @var FinanceOperationService
    */
    private $financeOperationService;


    public function __construct()
    {
        $this->settings = new \App\Classes\YandexMoney\Settings();
        $this->provider = new \App\Classes\YandexMoney\PKCS7RequestProvider($this->settings);
        $this->authUser = Auth::guard('api')->user();
        $this->financeOperationService = new FinanceOperationService();
    }

    
    /**
     * initialPayoutToCard - инициируем вывод денег на карту
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function initialPayoutToCard(Request $request)
    {

        $v = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100|max:50000|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        if ($v->fails())
        {
            return $this->errorResponse($v->errors());
        }

        $amount = (double) $request->amount;

        if ($this->authUser and $this->authUser->ballance >=  $amount){
            $this->settings->setUrlToCardData($amount, $this->authUser->unique_id); // пропишем в ссылку, сколько денег хотим списать
 //dd($this->settings->urlToCardData);

           // return  redirect()->away($this->settings->urlToCardData);
           return $this->successResponse(['url' => $this->settings->urlToCardData]);
        }

        return $this->errorResponse();

    }

    /**
     * initialPayoutToMobilePhone - инициируем вывод денег на мобильный телефон
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function initialPayoutToMobilePhone(Request $request)
    {

        $v = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1|max:15000|regex:/^\d+(\.\d{1,2})?$/',
            'phone' =>  'required|regex:/(^7(\d+)$)/u|min:11|max:11',
        ]);

        if ($v->fails())
        {
            return $this->errorResponse($v->errors());
        }
//dd($request->all());
        $amount = (double) $request->amount;
        $phoneNumber = $request->phone;

        if ($this->authUser and $this->authUser->ballance >=  $amount){
            
            $this->depositionTo = Settings::DEPOSITION_TYPE_MOBILE; // куда выводим деньги

            $api = new \App\Classes\YandexMoney\PayoutAPI( $this->provider,  $this->settings->synonimUrl);
                   
            $clientOrderId = \App\Classes\YandexMoney\Helpers\UUID::v4();

            // Обработка перевода
            $depositionParams  = new \App\Classes\YandexMoney\DepositionRequestParams($this->settings->ageniId, $clientOrderId, 'makeDeposition');
            $depositionParams->dstAccount = $phoneNumber;
            $depositionParams->amount     = $amount;
            $depositionParams->currency   = "643";
            $depositionParams->contract   = '';
       
            // Дополнительные параметры 
            $paymentParams               = new \App\Classes\YandexMoney\MobilePaymentParams();
            $paymentParams->phoneNumber  = $phoneNumber;

            $depositionParams->setPaymentParams($paymentParams);
//dd($depositionParams);
            $response = $api->makeDeposition($depositionParams);
// dd($response);
            if(! isset($response['status'])){
               // return $this->errorResponse($response);
                return redirect('/?yandexpayout=false&msg=' . urlencode($response));
            }

            $calculateResult  = $this->calculateStatusAndBallanceAndGetResult($response, $amount, $phoneNumber);
            $status = ($response['status'] ===\App\Classes\YandexMoney\PayoutAPI::REQ_STATUS_SUCCESS) ? 1 : 0;
            // запись в историю финансовых операций
            $this->financeOperationService->storeLocalPayment(
                $this->authUser->id,
                $clientOrderId,
                -$amount,
                $this->depositionTo,
                $phoneNumber,
                $status,
                ($status === 1) ? 'Успешная операция вывода средств на мобильный телефон' : 'Попытка вывода средств на мобильный телефон',
                \json_encode($depositionParams),
                \json_encode($response),
                \json_encode($calculateResult)
            );
            return redirect ($calculateResult);
        }

        return $this->errorResponse();

    }

    /**
     * successBankCardData -  удачная проверка паспортных данных, получили синоним карты и номер аккаунт а пользователя
     *
     * @param  mixed $request
     * @param  mixed $unique_id
     * @param  mixed $amount
     *
     * @return void
     */
    public function successBankCardData(Request $request, $unique_id, $amount)
    {
       // dd($request->all());
        $amount = (double) $amount;
        $uniqueId = (int) $unique_id;
        $this->authUser = USER::where('unique_id', '=', $uniqueId)->first();

        $cardSynonim = $request->input('skr_destinationCardSynonim', null);
        $cardMask = $request->input('skr_destinationCardPanmask', null);
        $accountNumber = $request->input('accountNumber', null);

        if($this->authUser and true === $request->has('identificationStatus') and $request->identificationStatus === "success" and $this->authUser->ballance >=  $amount and  $cardSynonim and $accountNumber){

            $this->depositionTo = Settings::DEPOSITION_TYPE_BANK_CARD; // куда выводим деньги

            $api = new \App\Classes\YandexMoney\PayoutAPI( $this->provider,  $this->settings->synonimUrl);
            
            $clientOrderId = \App\Classes\YandexMoney\Helpers\UUID::v4();

            // Обработка перевода
            $depositionParams  = new \App\Classes\YandexMoney\DepositionRequestParams($this->settings->ageniId, $clientOrderId, 'makeDeposition');
            $depositionParams->dstAccount = $this->settings->dstAccount;
            $depositionParams->amount     = $amount;
            $depositionParams->currency   = "643";
            $depositionParams->contract   = '';

            // Дополнительные параметры 
            $paymentParams              = new \App\Classes\YandexMoney\BankCardPaymentParams();
            $paymentParams->cardSynonim = $cardSynonim;
            $paymentParams->accountNumber = $accountNumber;

            $depositionParams->setPaymentParams($paymentParams);
//dd($depositionParams);
            $response = $api->makeDeposition($depositionParams);
//dd($response);
            if(! isset($response['status'])){
               // return $this->errorResponse($response);
                return redirect('/?yandexpayout=false&msg=' . urlencode($response));
            }

            $calculateResult  = $this->calculateStatusAndBallanceAndGetResult($response, $amount, $cardMask);
            // запись в историю финансовых операций
            $status = ($response['status'] ===\App\Classes\YandexMoney\PayoutAPI::REQ_STATUS_SUCCESS) ? 1 : 0;
            $this->financeOperationService->storeLocalPayment(
                $this->authUser->id,
                $clientOrderId,
                -$amount,
                $this->depositionTo,
                $cardMask,
                ($status === 0) ? 1 : $status, // если возвращен с яндекса статус  = 0 - это успех. Пишем в нашу БД успех, но у нас это = 1
                ($status === 0) ? 'Успешная операция вывода средств на банковскую карту' : 'Попытка вывода средств на банковскую карту',
                \json_encode($depositionParams),
                \json_encode($response),
                \json_encode($calculateResult)
            );

            return redirect ($calculateResult);

        }
        else{
            return $this->errorResponse('Неизвестная ошибка');  
        }

    }

    
    /**
     * calculateStatusAndBallanceAndGetResult  - обработает ,что вернулось с яндекса, снимает деньги с баланса, если надо и вернут ссылку для редиректа
     *
     * @param  mixed $response - то, чтовернулось после запроса оплаты на яндекс
     * @param  mixed $amount - сумма
     * @param  mixed $payuotTo - куда переводили, номер телефона, маска карты и т.п.
     *
     * @return string url
     */
    public function calculateStatusAndBallanceAndGetResult($response, $amount, $payuotTo)
    {

       switch (intval($response['status'])) {

            case \App\Classes\YandexMoney\PayoutAPI::REQ_STATUS_SUCCESS:

                    $this->authUser->ballance -= $amount;
                    $this->authUser->save();

                    $msg = '';
                    if($this->depositionTo === Settings::DEPOSITION_TYPE_MOBILE){
                        $msg = 'На Ваш телефон: ' .  $payuotTo . ' перечислено ' . $amount . ' руб.';
                    }
                    elseif($this->depositionTo === Settings::DEPOSITION_TYPE_BANK_CARD){
                        $msg = 'На Вашу карту: ' .  $payuotTo . ' перечислено ' . $amount . ' руб.';
                    }
                   
                    return '/?yandexpayout=true&msg=' . urlencode($msg);

                break;
            case \App\Classes\YandexMoney\PayoutAPI::REQ_STATUS_IN_PROGRESS:

                    $msg = 'Затруднения. Требуется повторить запрос для уточнения результата.';

                    return '/?yandexpayout=false&msg=' . urlencode($msg);

                break;
            case \App\Classes\YandexMoney\PayoutAPI::REQ_STATUS_REJECTED:

                    $isNegativeBallance = (isset($response['balance']) and (double)$response['balance'] < 0) ? true: false;
                    $msg = \App\Classes\YandexMoney\PayoutAPI::translateError($response['error']) . (($isNegativeBallance) ? ' Отрицательный балланс провайдера.' : '');

                    return '/?yandexpayout=false&msg=' . urlencode($msg);

                break;
        }
    }


    /**
     * error  -  ошибка при проверка данных на стороне яндекса
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function error(Request $request)
    {
       //dd($request->all());

        if(true === $request->has('identificationStatus') and $request->identificationStatus === "fail"){

            return redirect('/?yandexpayout=false&msg=' . urlencode('Ошибка проверки паспортных данных'));
           // return $this->errorResponse('Ошибка проверки паспортных данных' );  
           // return $this->errorResponse($request->all());//'Ошибка проверки паспортных данных' );  
        }

        return $this->errorResponse('Неизвестная ошибка');  

    }

}
