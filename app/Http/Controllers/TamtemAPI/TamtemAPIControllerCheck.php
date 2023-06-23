<?php

namespace App\Http\Controllers\TamtemAPI;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Traits\ApiControllerTrait;

use  App\Http\Requests\TamtemAPI\AgentIdFromInnRequest;
use  App\Models\Organization;



class TamtemAPIControllerCheck extends Controller
{
    use ApiControllerTrait;


    /**
     * Взять id агента, кто регал реферальную ссылку последним, на компанию с указанным ИНН
     *
     * @param  mixed $request
     *
     * @return void
     */
    public function agentIdFromInn(AgentIdFromInnRequest $request)
    {
				//return response($request->all());
				Log::info('inn:'.$request->inn);
//        $organization = Organization::where('inn', '=', $request->inn)->first();
$organization = Organization::where('inn', '=', $request->inn)->
				where('status', '=', Organization::ORGANIZATION_STATUS_UNACTIVATED)->
				orderBy('created_at', 'DESC')->first();
				if($organization){
						return $this->successResponse(['agent_id' => $organization->user->unique_id]);
        }
        return $this->errorResponse();  

    }

}

