<?php

namespace App\Models;
use Eloquent as Model;


class AsignaMaterias extends Model
{
    public $table = 'asg_mat_esp';
    public $timestamps=false;
    
    public $fillable = [
        'esp_id',
        'mtr_id',
        'asg_mtr_obs'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'esp_id' => 'integer',
        'mtr_id' => 'integer',
        'asg_mtr_obs'=> 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];    
    
}
