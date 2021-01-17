<span class="divisor col-sm-12">
DATOS DE LA MADRE
{!! Form::checkbox('m_si',null, ['class' => 'form-control']) !!}
</span>
<!-- M Apellidos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_apellidos', 'Apellidos:') !!}
    {!! Form::text('m_apellidos', null, ['class' => 'form-control input-text madre']) !!}
</div>

<!-- M Nombres Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_nombres', 'Nombres:') !!}
    {!! Form::text('m_nombres', null, ['class' => 'form-control input-text madre']) !!}
</div>

<!-- M Tipo Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_tipo_doc', 'Tipo_doc:') !!}
    {!! Form::select('m_tipo_doc',['0'=>'Cédula','1'=>'Pasaporte'],null, ['class' => 'form-control madre']) !!}
</div>

<!-- M Num Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_num_doc', 'Num Doc:') !!}
    {!! Form::text('m_num_doc', null, ['class' => 'form-control input-number madre' ,'maxlength'=>'10']) !!}
</div>

<!-- M Edad Field -->
<div class="form-group col-sm-3" >
    {!! Form::label('m_edad', 'Edad:') !!}
    {!! Form::text('m_edad', null, ['class' => 'form-control input-number madre','maxlength'=>'2']) !!}
</div>

<!-- M Est Civil Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_est_civil', 'Est Civil:') !!}
    {!! Form::select('m_est_civil',
    ['0'=>'Soltero',
    '1'=>'Casado',
    '2'=>'Divorciado',
    '3'=>'Viudo',
    '4'=>'Union Libre',
    ],
    null, ['class' => 'form-control madre']) !!}
</div>

<!-- M Instruccion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_instruccion', 'Instruccion:') !!}
    {!! Form::select('m_instruccion',[
    '0'=>'Ninguno',
    '1'=>'Básica Media',
    '2'=>'Básica Superior',
    '3'=>'Bachillerato',
    '4'=>'Superior Técnologo',
    '5'=>'Superior 3er Nivel',
    '6'=>'Superior 4to Nivel',
    '7'=>'Superior 5to Nivel',
    ],null, ['class' => 'form-control madre']) !!}
</div>

<!-- M Profesion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_profesion', 'Profesion:') !!}
    {!! Form::text('m_profesion', null, ['class' => 'form-control input-text madre']) !!}
</div>

<!-- M Ingresos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_ingresos', 'Ingresos:') !!}
    {!! Form::text('m_ingresos', null, ['class' => 'form-control input-number madre']) !!}
</div>

<!-- M Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_telefono', 'Telefono:') !!}
    {!! Form::text('m_telefono', null, ['class' => 'form-control input-number madre','maxlength'=>'9','pattern'=>'^02\d{7}$']) !!}
</div>

<!-- M Celular Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_celular', 'Celular:') !!}
    {!! Form::text('m_celular', null, ['class' => 'form-control input-number madre','maxlength'=>'10','pattern'=>'^09\d{8}$']) !!}
</div>

<!-- ///DATOS DEL PADRE/////////////////// -->
<span class="divisor col-sm-12">
DATOS DEL PADRE
{!! Form::checkbox('p_si',null, ['class' => 'form-control']) !!}
</span>

<!-- P Apellidos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_apellidos', 'Apellidos:') !!}
    {!! Form::text('p_apellidos', null, ['class' => 'form-control input-text padre']) !!}
</div>

<!-- P Nombres Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_nombres', 'Nombres:') !!}
    {!! Form::text('p_nombres', null, ['class' => 'form-control input-text padre']) !!}
</div>

<!-- P Tipo Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_tipo_doc', 'Tipo_Doc:') !!}
    {!! Form::select('p_tipo_doc',['0'=>'Cedula','1'=>'Pasaporte'],null, ['class' => 'form-control padre']) !!}
</div>

<!-- P Nup Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_nup_doc', 'Num_Doc:') !!}
    {!! Form::text('p_nup_doc', null, ['class' => 'form-control input-number padre','maxlength'=>'10',]) !!}
</div>

<!-- P Edad Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_edad', 'Edad:') !!}
    {!! Form::number('p_edad', null, ['class' => 'form-control input-number padre','maxlength'=>'2']) !!}
</div>

<!-- P Est Civil Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_est_civil', 'Estado Civil:') !!}
    {!! Form::select('p_est_civil',
    ['0'=>'Soltero',
    '1'=>'Casado',
    '2'=>'Divorciado',
    '3'=>'Viudo',
    '4'=>'Union Libre',
    ],null, ['class' => 'form-control padre']) !!}
</div>

<!-- P Instruccion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_instruccion', 'Instruccion:') !!}
    {!! Form::select('p_instruccion',[
    '0'=>'Ninguno',
    '1'=>'Básica Media',
    '2'=>'Básica Superior',
    '3'=>'Bachillerato',
    '4'=>'Superior Técnologo',
    '5'=>'Superior 3er Nivel',
    '6'=>'Superior 4to Nivel',
    '7'=>'Superior 5to Nivel',
    ],null, ['class' => 'form-control padre']) !!}
</div>

<!-- P Profesion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_profesion', 'Profesion:') !!}
    {!! Form::text('p_profesion', null, ['class' => 'form-control input-text padre']) !!}
</div>

<!-- P Ingresos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_ingresos', 'Ingresos:') !!}
    {!! Form::text('p_ingresos', null, ['class' => 'form-control input-number padre']) !!}
</div>

<!-- P Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_telefono', 'Telefono:') !!}
    {!! Form::text('p_telefono', null, ['class' => 'form-control input-number padre','maxlength'=>'9','pattern'=>'^02\d{7}$']) !!}
</div>

<!-- P Celular Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_celular', 'Celular:') !!}
    {!! Form::text('p_celular', null, ['class' => 'form-control input-number padre','maxlength'=>'10','pattern'=>'^09\d{8}$']) !!}
</div>
<span class="divisor col-sm-12">
DATOS DEL REPRESENTANTE
{!! Form::select('rp_si',[''=>'Elija una Opción','0'=>'MADRE','1'=>'PADRE','2'=>'OTRO'],null, ['class' => '']) !!}
</span>
<!-- Rp Parentezco Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_parentezco', 'Parentezco:') !!}
    {!! Form::text('rp_parentezco', null, ['class' => 'form-control input-text representante']) !!}
</div>

<!-- Rp Apellidos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_apellidos', 'Apellidos:') !!}
    {!! Form::text('rp_apellidos', null, ['class' => 'form-control input-text representante']) !!}
</div>

<!-- Rp Nombres Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_nombres', 'Nombres:') !!}
    {!! Form::text('rp_nombres', null, ['class' => 'form-control input-text representante']) !!}
</div>

<!-- Rp Tipo Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_tipo_doc', 'Tipo Doc:') !!}
    {!! Form::select('rp_tipo_doc',['0'=>'Cedula','1'=>'Pasaporte'],null, ['class' => 'form-control representante']) !!}
</div>

<!-- Rp Nurp Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_nurp_doc', 'Num Doc:') !!}
    {!! Form::text('rp_nurp_doc', null, ['class' => 'form-control input-number representante','maxlength'=>'9']) !!}
</div>

<!-- Rp Edad Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_edad', 'Edad:') !!}
    {!! Form::text('rp_edad', null, ['class' => 'form-control input-number representante','maxlength'=>'2']) !!}
</div>

<!-- Rp Est Civil Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_est_civil', 'Est Civil:') !!}
    {!! Form::select('rp_est_civil',
['0'=>'Soltero',
    '1'=>'Casado',
    '2'=>'Divorciado',
    '3'=>'Viudo',
    '4'=>'Union Libre',
    ]    
    ,null, ['class' => 'form-control representante']) !!}
</div>

<!-- Rp Instruccion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_instruccion', 'Instruccion:') !!}
    {!! Form::select('rp_instruccion',[
    '0'=>'Ninguno',
    '1'=>'Básica Media',
    '2'=>'Básica Superior',
    '3'=>'Bachillerato',
    '4'=>'Superior Técnologo',
    '5'=>'Superior 3er Nivel',
    '6'=>'Superior 4to Nivel',
    '7'=>'Superior 5to Nivel',
    ],null, ['class' => 'form-control representante']) !!}
</div>

<!-- Rp Profesion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_profesion', 'Profesion:') !!}
    {!! Form::text('rp_profesion', null, ['class' => 'form-control input-text representante']) !!}
</div>

<!-- Rp Ingresos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_ingresos', 'Ingresos:') !!}
    {!! Form::text('rp_ingresos', null, ['class' => 'form-control input-number representante']) !!}
</div>

<!-- Rp Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_telefono', 'Telefono:') !!}
    {!! Form::text('rp_telefono', null, ['class' => 'form-control input-number representante', 'maxlength'=>'9','pattern'=>'^02\d{7}$']) !!}
</div>
<!-- Rp Celular Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_celular', 'Celular:') !!}
    {!! Form::text('rp_celular', null, ['class' => 'form-control input-number representante','maxlength'=>'10','pattern'=>'^09\d{8}$']) !!}
</div>

