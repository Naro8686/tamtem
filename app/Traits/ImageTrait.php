<?php
namespace App\Traits;

trait ImageTrait
{

    function imageSave($image, $path)
    {
        try{
            $path = $image->store($path);
            return config('filesystems.disks.local.prefix') . $path;
        }
        catch(\Exception $e){
            //return $this->errorResponse($e->getMessage());
            return null;
		}

    }

    function imageDelete($path)
    {
        try{
            return unlink(public_path($path));            
        }
        catch(\Exception $e){
            //return $this->errorResponse($e->getMessage());
            return null;
		}
    }
}