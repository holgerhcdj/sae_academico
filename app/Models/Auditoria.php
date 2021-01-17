<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Estudiantes;
use Session;
use DB;
/**
 * Class Auditoria
 * @package App\Models
 * @version October 7, 2018, 11:38 am PET
 *
 * @property \Illuminate\Database\Eloquent\Collection asgPermisos
 * @property \Illuminate\Database\Eloquent\Collection erpDetRetencion
 * @property \Illuminate\Database\Eloquent\Collection erpNotaCredito
 * @property \Illuminate\Database\Eloquent\Collection erpNotaDebito
 * @property \Illuminate\Database\Eloquent\Collection materias
 * @property \Illuminate\Database\Eloquent\Collection ordenesPension
 * @property \Illuminate\Database\Eloquent\Collection requerimientos
 * @property \Illuminate\Database\Eloquent\Collection regNotasExtras
 * @property \Illuminate\Database\Eloquent\Collection votaciones
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property \Illuminate\Database\Eloquent\Collection erpAsgOptionList
 * @property \Illuminate\Database\Eloquent\Collection movimientosRequerimiento
 * @property \Illuminate\Database\Eloquent\Collection valorPensiones
 * @property \Illuminate\Database\Eloquent\Collection erpFactura
 * @property \Illuminate\Database\Eloquent\Collection erpIMovInvPt
 * @property \Illuminate\Database\Eloquent\Collection parEmpleados
 * @property smallInteger usu_id
 * @property date adt_date
 * @property string adt_hour
 * @property string adt_modulo
 * @property string adt_accion
 * @property string adt_ip
 * @property string adt_documento
 * @property string adt_campo
 * @property string adt_vi
 * @property string adt_vf
 * @property string usu_login
 */
class Auditoria extends Model
{

    public $table = 'erp_auditoria';
    public $timestamps = false;
    protected $primaryKey = 'adt_id';

    public $fillable = [
        'usu_id',
        'adt_date',
        'adt_hour',
        'adt_modulo',
        'adt_accion',
        'adt_ip',
        'adt_documento',
        'adt_campo',
        'adt_vi',
        'adt_vf',
        'usu_login'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'usu_id' => 'integer',
        'adt_date' => 'date',
        'adt_hour' => 'string',
        'adt_modulo' => 'string',
        'adt_accion' => 'string',
        'adt_ip' => 'string',
        'adt_documento' => 'string',
        'adt_campo' => 'string',
        'adt_vi' => 'string',
        'adt_vf' => 'string',
        'usu_login' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];


      public function save_adt($data){
        $usu = Auth::user();//El usuario autentificado
        $date=date('Y-m-d');
        $hora=date('H:i:s');
        $this->usu_id=$usu->id;
        $this->adt_date=$date;
        $this->adt_hour=$hora;
        $this->adt_modulo=$data["mod"];
        $this->adt_accion=$data["acc"];
        $this->adt_ip=$_SERVER['REMOTE_ADDR'];
        $this->adt_documento=$data["doc"];
        $this->adt_campo=$data["dat"];
        $this->usu_login=$usu->username;
        $this->save();        

     }


    public function estudiantes(){//Combo estudiantes
        $anl=Session::get('anl_id');
        return $estudiantes = Estudiantes::
        join('matriculas', 'matriculas.est_id', '=', 'estudiantes.id')
        ->where('matriculas.anl_id', '=', $anl)
        ->where('matriculas.mat_estado', '=', 1)
        ->select('estudiantes.est_apellidos','estudiantes.est_nombres','matriculas.id')
        ->orderBy('estudiantes.est_apellidos')
        ->get()->pluck('full_name', 'id');
    }


    public function buscador_estudiantes($d){
/////////************NO MOVER LA FUNCION PORQUE SE DAÑA EN OTRO LADO***************//////////

        $anl=$d[0];
        $jor=$d[1];
        $esp=$d[2];
        $cur=$d[3];
        $par=$d[4];
        $estado=$d[5];

        if($esp=='10'){
            $esp=0;
        }
        
        if($esp=='0'){ 
            $sql_esp=" AND m.esp_id<>7 AND m.esp_id<>8";
        }else{
            $sql_esp=" AND m.esp_id=$esp";
        }

        if($cur=='0'){ 
            $sql_cur=" ";
        }else{
            $sql_cur=" AND m.cur_id=$cur";
        }

        if($par=='0'){ 
            $sql_par=" ";
        }else{
            if($esp=='0' || $esp=='7' || $esp=='8'){
                $sql_par=" AND m.mat_paralelo='$par' ";
            }else{
                $sql_par=" AND m.mat_paralelot='$par' ";
            }
        }

        if($estado=='0'){ 
            $sql_estado=" ";
        }else{
            $sql_estado=" AND m.mat_estado=$estado ";
        }
$sql="SELECT *,m.id as mat_id FROM matriculas m 
                    JOIN estudiantes e ON m.est_id=e.id 
                    JOIN jornadas j ON m.jor_id=j.id 
                    JOIN especialidades ep ON m.esp_id=ep.id
                    JOIN cursos c ON m.cur_id=c.id
                    WHERE m.anl_id=$anl
                    AND   m.jor_id=$jor
                    $sql_esp
                    $sql_cur
                    $sql_par
                    $sql_estado
                    ORDER BY e.est_apellidos
         ";

      $lista= DB::select($sql);

      return $lista;


    }



    
}
