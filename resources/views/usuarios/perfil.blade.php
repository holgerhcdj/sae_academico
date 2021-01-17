<style>
    .divisor{
        background-color:#eee; 
        border:solid 1px #ccc; 
        text-align:center;
        margin-top:5px; 
        font-weight:bolder;   
    }
</style>
<span class="divisor col-sm-12">
    DATOS DE USUARIO
    <input type="hidden" id="cambia_perfil" name="cambia_perfil" value="0" style="width:30px;"  />
</span>
<input type="hidden" id="op" name="op" value="{{$op}}" />
<div class="form-group col-sm-3">
    {!! Form::label('username', 'Usuario (Alias):') !!}
    {!! Form::text('username', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- Email Field -->
<div class="form-group col-sm-3" >
    {!! Form::label('email', 'Correo Electronico:') !!}
    {!! Form::email('email', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- Password Field -->
<div class="form-group col-sm-3">
    {!! Form::label('usu_perfil', 'Departamento/Perfil:') !!}
    {!! Form::select('usu_perfil',$departamentos,null,['class'=>'form-control']) !!}    
   
</div>

<div class="form-group col-sm-3">
    {!! Form::label('esp_id', 'Especialidad:') !!}
    {!! Form::select('esp_id',$especialidades,null,['class'=>'form-control']) !!}    
</div>




<div class="form-group col-sm-3" >
    {!! Form::label('materia', 'Materia:') !!}
    {!! Form::text('materia', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-6" >
    {!! Form::label('jor1', 'Matutitna:') !!}
    {{ Form::checkbox('jor1', 1, null, ['class' => 'field']) }}
    {!! Form::label('jor4', 'Vespertina:') !!}
    {{ Form::checkbox('jor4', 1, null, ['class' => 'field']) }}
    {!! Form::label('jor2', 'Nocturna:') !!}
    {{ Form::checkbox('jor2', 1, null, ['class' => 'field']) }}
    {!! Form::label('jor3', 'Semi-Presencial:') !!}
    {{ Form::checkbox('jor3', 1, null, ['class' => 'field']) }}
</div>

<span class="divisor col-sm-12">DATOS DE PERSONALES</span>
<div class="form-group col-sm-3" hidden="">
    {!! Form::label('usu_foto', 'Foto:') !!}
    {!! Form::text('usu_foto', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_tipo_documento', 'Tipo Documento:') !!}
    {!! Form::select('usu_tipo_documento', [
    '0' => 'CEDULA',
    '1' => 'PASAPORTE',
    ],null,['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_no_documento', 'Cedula/Pasaporte:') !!}
    {!! Form::text('usu_no_documento', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_apellidos', 'Apellidos:') !!}
    {!! Form::text('usu_apellidos', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('name', 'Nombres:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_sexo', 'Sexo:') !!}
    {!! Form::select('usu_tipo_documento', [
    '0' => 'Masculino',
    '1' => 'Femenino',
    ],null,['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_fnacimiento', 'Fecha Nacimiento:') !!}
    {!! Form::date('usu_fnacimiento', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_canton', 'Canton:') !!}
    {!! Form::text('usu_canton', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_parroquia', 'Parroquia:') !!}
    {!! Form::text('usu_parroquia', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_direccion', 'Direccion:') !!}
    {!! Form::text('usu_direccion', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_telefono', 'Telefono:') !!}
    {!! Form::text('usu_telefono', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_celular', 'Celular:') !!}
    {!! Form::text('usu_celular', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_estado_civil', 'Estado Civil:') !!}
    {!! Form::select('usu_estado_civil', [
    'SOLTERO' => 'SOLTERO',
    'CASADO' => 'CASADO',
    'DIVORCIADO'=>'DIVORCIADO',
    'VIUDO'=>'VIUDO',
    'UNION LIBRE'=>'UNION LIBRE',
    ],null,['class' => 'form-control','required'=>'required']) !!}

</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_nacionalidad', 'Nacionalidad:') !!}
    {!! Form::text('usu_nacionalidad', 'ECUATORIANA', ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_dir_nacimiento', 'Lugar de Nacimiento:') !!}
    {!! Form::text('usu_dir_nacimiento', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_disc', 'Discapacidad:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('usu_disc', false) !!}
    {!! Form::select('usu_disc', [
    '1' => 'No',
    '0' => 'Si',
    ],null,['class' => 'form-control','required'=>'required']) !!}
    </label>
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_disc_descripcion', 'Descripcion de Discapacidad:') !!}
    {!! Form::text('usu_disc_descripcion', null, ['class' => 'form-control']) !!}
</div>
<span class="divisor col-sm-12">INSTRUCCIÓN</span>
<div class="form-group col-sm-3">
    {!! Form::label('usu_nivel_instruccion', 'Nivel de Instruccion:') !!}
 {!! Form::select('usu_nivel_instruccion', [
    'EDUCACION BASICA' => 'EDUCACION BASICA',
    'SECUNDARIA' => 'SECUNDARIA',
    'TERCER NIVEL MEDIO'=>'TERCER NIVEL MEDIO',
    'TERCER NIVEL'=>'TERCER NIVEL',
    'CUARTO NIVEL'=>'CUARTO NIVEL',
    'NINGUNO'=>'NINGUNO',
    'OTRO'=>'OTRO',
    ],null,['class' => 'form-control','required'=>'required']) !!}

</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_descripcion_instruccion', 'Descripcion Instruccion:') !!}
    {!! Form::text('usu_descripcion_instruccion', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('usu_titulo', 'Titulo:') !!}
    {!! Form::text('usu_titulo', null, ['class' => 'form-control']) !!}
</div>
<span class="divisor col-sm-12">CUENTA BANCARIA</span>
<div class="form-group col-sm-3">
    {!! Form::label('usu_cta_banco', 'Banco:') !!}
    {!! Form::text('usu_cta_banco', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_cta_tipo', 'Tipo de Cuenta:') !!}
    {!! Form::select('usu_cta_tipo', [
    'AHORROS' => 'AHORROS',
    'CORRIENTE' => 'CORRIENTE',
    ],null,['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_cta_numero', 'Numero:') !!}
    {!! Form::text('usu_cta_numero', null, ['class' => 'form-control']) !!}
</div>
<span class="col-sm-12"></span>
<div class="form-group col-sm-3">
    {!! Form::label('usu_estado', 'Estado:') !!}
    {!! Form::select('usu_estado', [
    '0' => 'Activo',
    '1' => 'Inactivo',
    ],null,['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-9">
    {!! Form::label('usu_obs', 'Observaciones:') !!}
    {!! Form::text('usu_obs', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">

    @if($pr[1]==1 && $op!=3)
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    @endif

    <a href="{!! route('usuarios.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>

