<?php

namespace App\Traits;


trait ApiControllerTrait
{

    public function successResponse($data = null)
    {
        if (isset($data))
            return ['result' => true, 'data' => $data];

        return ['result' => true];
    }

    public function errorResponse($error = null)
    {
        if (isset($error))
            return ['result' => false, 'error' => $error];

        return ['result' => false];
    }

    public function paginateResponse($paginate)
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

    public function accessDenied($message = 'access denied')
    {
        return response(['result' => false, 'message' => $message], 401);
    }

    public function pathRedirectTo($path = '/', $result = true , $command = null, $info = null)
    {
        $redirectTo = $path;

        if($result === true){
            $redirectTo .= '?result=true' ;
            $redirectTo .= ($info) ? '&info=' . $info : '';
        }
        else{
            $redirectTo .= '?result=false' ;
            $redirectTo .= ($info) ? '&error=' . $info : '';
        }

        $redirectTo .= ($command) ? '&command=' . $command : '';
        
        return  $redirectTo;
    }

   
    
}