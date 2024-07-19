<?php

namespace App\Http\Controllers\Client\Api\v1;

use App\Models\MetaTag;
use App\Traits\ApiControllerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MetaTagController extends Controller
{
    use ApiControllerTrait;

    public function __invoke(Request $request)
    {
        return $request->has('slug')
            ? $this->get($request->get('slug'))
            : $this->all();
    }

    private function get($slug = null)
    {
        if (is_null($slug)) {
            return $this->errorResponse('Slug not defender');
        }
        $slug = ltrim($slug, '/');
        $metaData = MetaTag::where(['page_slug' => $slug])->first([
            'page_slug', 'title', 'description', 'keywords'
        ]);
        if (is_null($metaData)) {
            return $this->errorResponse('Meta Data Not Found');
        }
        return $this->successResponse($metaData->toArray());
    }

    private function all()
    {
        $metaData = MetaTag::get([
            'page_slug', 'title', 'description', 'keywords'
        ]);
        return $this->successResponse($metaData->toArray());
    }
}
