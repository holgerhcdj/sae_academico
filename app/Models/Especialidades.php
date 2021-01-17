<?php

namespace App\Models;
use Eloquent as Model;

class Especialidades extends Model
{
    public $table = 'especialidades';
     public $timestamps=false;
    public function materia(){
        return $this->hasMany(Materias::class);
        
    }
    
    public $fillable = [
        'esp_descripcion',
        'esp_obs',
        'esp_tipo'
    ];

    protected $casts = [
        'id' => 'integer',
        'esp_descripcion' => 'string',
        'esp_obs' => 'string',
        'esp_tipo' => 'integer'
    ];

    public function matriculas() {
        return $this->hasMany(App\Models\Matriculas::class,'esp_id','id');
    }
    
    public static $rules = [
        
    ];

    
}
