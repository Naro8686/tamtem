<?php

namespace App\Http\Controllers\Client;


use App\Http\Resources\Organization\OrganizationResource;
use App\Http\Controllers\Controller;
use App\Services\Organization\OrganizationService;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Http\Requests\Client\Api\v1\Organization\OrganizationStoreRequest;
use App\Http\Requests\Client\Api\v1\Organization\OrganizationUpdateRequest;
use Auth;
use App\Traits\ApiControllerTrait;

class OrganizationController extends Controller
{

    use ApiControllerTrait;

    /**
    * @var OrganizationService
    */
    private $organizationService;

    /**
    * @var User
    */
    private $authUser;

        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
        $this->authUser = Auth::guard('api')->user();
    }

    public function index(Request $request)
    {
      //  return  $this->organizationService->index($request);
        // если юзер просит свои данные или админ
        if($this->authUser->isAdmin()){
            $organization =  $this->organizationService->index($request);
        }
        else{
            $request->merge(['user_id' => $this->authUser->id]); 
            $request->merge(['status' => Organization::ORGANIZATION_STATUS_ACTIVATED]); 
           // dd($request->all());
            //dd($this->authUser->organizations()->get());
            // $organization =  $this->authUser->organizations()->paginate(15);
            $organization =  $this->organizationService->index($request);
        }

        return $this->successResponse($organization);
      //  return $organization;
    }
   
   /**
    * @param int $id
    * @return OrganizationResource
    * @throws Exception
    */
    public function get(int $id)
    {

        // если юзер просит свои данные или админ
        $isMyOrg = $this->authUser->isMiOrganization($id);
        
        if($isMyOrg or $this->authUser->isAdmin()){

            $organization = $this->organizationService->get($id);

            if($organization instanceof Organization){
                return $this->successResponse(new OrganizationResource($organization));
            }
            else{
                return $this->errorResponse($organization);
            }
        }
        else{
            return $this->errorResponse();
        }
    }

    /**
    * @param OrganizationStoreRequest $request
    * @return OrganizationResource
    * @throws Exception
    */
    public function create(OrganizationStoreRequest $request)
    { 
        $data = $request->all();

        $organization = $this->organizationService->create($data);

        if($organization instanceof Organization){
            return $this->successResponse(new OrganizationResource($organization));
        }
        else{
            return $this->errorResponse($organization);
        }
    }


    /**
    * @param int $id
    * @param OrganizationUpdateRequest $request
    * @return OrganizationResource
    * @throws Exception
    */
    public function update(int $id, OrganizationUpdateRequest $request)
    {// dd(\json_encode( array("Товары для дома", "Товары для детей")));
        // если юзер сам или админ
        if($this->authUser->isMiOrganization($id) or $this->authUser->isAdmin()){

            $data = $request->all();

            $organization = $this->organizationService->update($id, $data);
    
            if($organization instanceof Organization){
                return $this->successResponse(new OrganizationResource($organization));
            }
            else{
                return $this->errorResponse($organization);
            }
        }
        else{
            return $this->errorResponse();
        }
    
    }

    /**
    * @param int $id
    * @return JsonResponse
    * @throws Exception
    */
    public function delete(int $id)
    {
        
        $organization =  $this->organizationService->delete($id);

        if($organization instanceof Organization){
            return $this->successResponse(['id' => $organization->id]);
        }
        else{
            return $this->errorResponse($organization);
        }
    }

    /**
    * @param int $id
    * @return JsonResponse
    * @throws Exception
    */
    public function restore(int $id)
    {
        $organization =  $this->organizationService->restore($id);

        if($organization instanceof Organization){
            return $this->successResponse(['id' => $organization->id]);
        }
        else{
            return $this->errorResponse($organization);
        }
    }
}
