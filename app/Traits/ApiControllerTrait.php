<?php
/**
 * Created by black40x@yandex.ru
 * Date: 07.10.2018
 */

namespace App\Traits;


trait ApiControllerTrait
{

    public function successResponse($data = null): array
    {
        if (isset($data))
            return ['result' => true, 'data' => $data];

        return ['result' => true];
    }

    public function errorResponse($error = null): array
    {
        if (isset($error))
            return ['result' => false, 'error' => $error];

        return ['result' => false];
    }

    public function paginateResponse($paginate): array
    {
        if(!$paginate)
            return $this->errorResponse();

        return [
            'result' => true,
            'data' => [
                'count' => $paginate->count(),
                'hasMore' => $paginate->hasMorePages(),
                'items' => $paginate->items(),
            ],
        ];
    }
    
}