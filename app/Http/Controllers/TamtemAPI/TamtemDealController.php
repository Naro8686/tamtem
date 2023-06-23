<?php

namespace App\Http\Controllers\TamtemAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiControllerTrait;

use  App\Models\TamtemDeal;



class TamtemDealController extends Controller
{
    use ApiControllerTrait;

    /**
     *  Получить список сделок 
     *
     * @param  mixed $request
     *
     * @return response
     */
    public function index(Request $request)
    { 
        
       // //return response($request->all());
        // $organization = Organization::where('inn', '=', $request->inn)->
        //                               where('status', '=', Organization::ORGANIZATION_STATUS_UNACTIVATED)->
        //                               orderBy('created_at', 'DESC')->first();

        // if($organization){
        //     return $this->successResponse(['agent_id' => $organization->user->unique_id ]);
        // }

        $agentId = $request->user()->id;

      //  $dealsWithOrganizations = TamtemDeal::take(6)->get();
    //   $deal
    //     foreach(TamtemDeal::take(6)->get() as  $deal){

    //     }
        // $dealsWithOrganizations = TamtemDeal::with(['organizations' => function($query) use ($agentId){
        //     $query->where('agent_id', '=', $agentId)->count()->get();
        // }])->get();
        $deals = TamtemDeal::withCount(['organizations' => function($query) use ($agentId){
            $query->where('agent_id', '=', $agentId);
        }])->get();

        if ($deals) {
            return $this->successResponse($deals);
        }
  
        return $this->errorResponse();  

    }

     /**
     *  Получить сделку по ее id с прикрепленными организациями
     *
     * @param  mixed $request
     * @param  mixed $id
     *
     * @return response
     */
    public function get(Request $request, $id)
    { 

        $user = $request->user();

        // залогиненый юзер
        if ($user){

            $agentId = $user->id;

            $deal = TamtemDeal::withCount(['organizations' => function($query) use ($agentId){
                $query->where('agent_id', '=', $agentId);
            }])->where('id', '=', (int) $id)->first();
            
        }
        else{
            $deal = TamtemDeal::where('id', '=', (int) $id)->first();
        }
       
        if (!$deal) {
            return $this->errorResponse('Нет сделки с id=' . $id);
        }
    
        return $this->successResponse($deal);
  
    }

}
