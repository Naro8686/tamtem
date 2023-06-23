<?php

namespace App\Http\Controllers\TamtemAPI;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiControllerTrait;

use  App\Models\TamtemDeal;
use  App\Models\TamtemOrganization;

use Validator;

class TamtemOrganizationController extends Controller
{
    use ApiControllerTrait;

    /**
     *  Прикрепленные организации к сделке и агенту
     *
     * @param  mixed $request
     * @param  mixed $id
     *
     * @return response
     */
    public function getFromDealId(Request $request, $id)
    { 

        if (! $deal = TamtemDeal::where('id', '=', (int) $id)->first()) {
            return $this->errorResponse('Нет сделки с id=' . $id);
        }
  
        $agentId = $request->user()->id;
        $per_page = $request->input('per_page', 15);
        $organizations = TamtemOrganization::where('okved', '=',  $deal->tamtem_organization_okved)->where('agent_id', '=', $agentId)->paginate($per_page);
       
        if ($organizations) {
            return $this->successResponse($organizations);
        }
  
        return $this->errorResponse();  
    }

    /**
     *  Прикрепить организации к агенту по оквед
     *
     * @param  mixed $request
     * @param  mixed $id
     *
     * @return response
     */
    public function attach(Request $request)
    { 
        $maxAttached = 15; // максимальное кол-во  сделок, которые можно прикрепить
 
        $validatedDataOrg = Validator::make( $request->all(), [
            'okved' => 'required|exists:tamtem_deals,tamtem_organization_okved',
        ]);

        if ($validatedDataOrg->fails()) {
            return $this->errorResponse($validatedDataOrg->messages());
        }

        $agentId = $request->user()->id;

        // посмотрим, нет ли уже прикрепленных за агентом организаций
        $countAttachedOrganizations = TamtemOrganization::where('okved', '=',  $request->okved)->where('agent_id', '=', $agentId)->count();

        $needAttached =  $maxAttached -  $countAttachedOrganizations;
        // прикрепим недостающие до $maxAttached
        if($needAttached > 0 ){
            $needAttachedOrganizations = TamtemOrganization::where('okved', '=',  $request->okved)->whereNull('agent_id')->take($needAttached);
            $needAttachedOrganizations->update([
                'agent_id' => $agentId,
                'agent_attached_at' => now()
            ]);
        }
        else{
            return $this->errorResponse('Нельзя добавить организаций больше, чем ' . $maxAttached);
        }

        return $this->successResponse();

    }

}
