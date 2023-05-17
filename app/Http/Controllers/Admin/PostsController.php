<?php

namespace App\Http\Controllers\Admin;

use App\Traits\ApiControllerTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Posts\PostStoreRequest;
use App\Http\Requests\Admin\Posts\PostUpdateRequest;
use App\Services\Post\PostService;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use Exception;
class PostsController extends Controller
{
	use ApiControllerTrait;

   /**
    * @var PostService
    */
    private $postService;

    public function __construct()
    {
        $this->postService = new PostService();
	}
	
    /**
    * @param Request $request
    */
    public function index(Request $request)
    { 
        return $this->postService->index($request);
    }

    /**
     * @param int $id
     * @return PostResource|array
     * @throws Exception
     */
    public function get(int $id)
    {
        $post = $this->postService->get($id);

        if($post instanceof Post){
            return $this->successResponse(new PostResource($post));
        }
        else{
            return $this->errorResponse($post);
        }
    }
    

    /**
    * @param PostStoreRequest $request
    * @return PostResource|array
    * @throws Exception
    */
    public function store(PostStoreRequest $request)
    {
        $post = $this->postService->create($request->validated());

        if($post instanceof Post){
            return $this->successResponse(new PostResource($post));
        }
        else{
            return $this->errorResponse($post);
        }
    }

    /**
    * @param int $id
    * @param PostUpdateRequest $request
    * @return PostResource|array
    * @throws Exception
    */
    public function update(int $id, PostUpdateRequest $request)
    {
        $post = $this->postService->update($id, $request->validated());
      
        if($post instanceof Post){
            return (new PostResource($post));
        }
        else{
            return $this->errorResponse($post);
        }
    }

    /**
    * @param int $id
    * @throws Exception
    */
    public function delete(int $id)
    {
        $post =  $this->postService->delete($id);

        if($post instanceof Post){
            return $this->successResponse(['id' => $post->id]);
        }
        else{
            return $this->errorResponse($post);
        }
    }

}
