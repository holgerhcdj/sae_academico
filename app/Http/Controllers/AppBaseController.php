<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use Illuminate\Support\Facades\Auth;
use Session;
/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    public function msj(){
        $usu = Auth::user();
        $msj=DB::select("
            select count(*) as msj
            from requerimientos where (last_ids like '%;".$usu->id.";%' or last_ids like '".$usu->id.";%')
            and estado=0");
        Session::put('msj',$msj[0]->msj);
    }
    
    public function permisos($mod_id){
        $user=Auth::user()->AsignaPermisos;
        $permisos=[];
        foreach ($user as $u){
            if($u->mod_id== $mod_id){
                $permisos=['mod'=>$u->mod_id,
                    'new'=>$u->new,
                    'edit'=>$u->edit,
                    'del'=>$u->del,
                    'show'=>$u->show ];
            }
        }
        return $permisos;
    }
  



    
    
}
