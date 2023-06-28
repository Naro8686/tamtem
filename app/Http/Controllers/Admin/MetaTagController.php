<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MetaTag\StoreRequest;
use App\Http\Requests\Admin\MetaTag\UpdateRequest;
use App\Http\Resources\MetaTag\MetaTagResource;
use App\Models\MetaTag;
use App\Services\MetaTag\MetaTagService;
use App\Traits\ApiControllerTrait;
use Exception;
use Illuminate\Http\Request;

class MetaTagController extends Controller
{
    use ApiControllerTrait;

    /**
     * @var MetaTagService
     */
    private $metaTagService;

    public function __construct()
    {
        $this->metaTagService = new MetaTagService();
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        return $this->metaTagService->index($request);
    }

    /**
     * @param int $id
     * @return MetaTagResource|array
     * @throws Exception
     */
    public function get(int $id)
    {
        $metaTag = $this->metaTagService->get($id);

        if($metaTag instanceof MetaTag){
            return $this->successResponse(new MetaTagResource($metaTag));
        }
        else{
            return $this->errorResponse($metaTag);
        }
    }


    /**
     * @param StoreRequest $request
     * @return MetaTagResource|array
     * @throws Exception
     */
    public function store(StoreRequest $request)
    {
        $metaTag = $this->metaTagService->create($request->validated());

        if($metaTag instanceof MetaTag){
            return $this->successResponse(new MetaTagResource($metaTag));
        }
        else{
            return $this->errorResponse($metaTag);
        }
    }

    /**
     * @param int $id
     * @param UpdateRequest $request
     * @return MetaTagResource|array
     * @throws Exception
     */
    public function update(int $id, UpdateRequest $request)
    {
        $metaTag = $this->metaTagService->update($id, $request->validated());

        if($metaTag instanceof MetaTag){
            return (new MetaTagResource($metaTag));
        }
        else{
            return $this->errorResponse($metaTag);
        }
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id)
    {
        $metaTag =  $this->metaTagService->delete($id);

        if($metaTag instanceof MetaTag){
            return $this->successResponse(['id' => $metaTag->id]);
        }
        else{
            return $this->errorResponse($metaTag);
        }
    }
}
