<style>
    .divisor{
        background-color:#eee; 
        border:solid 1px #ccc; 
        text-align:center;
        margin-top:5px; 
        font-weight:bolder;   
    }
</style>
@include('flash::message')
<span class="divisor col-sm-12">DATOS DE USUARIO</span>
<input type="hidden" id="op" name="op" value="{{$op}}" />
<div class="form-group col-sm-3">
    {!! Form::label('username', 'Usuario (Alias):') !!}
    {!! Form::text('username', null, ['class' => 'form-control','required'=>'required','readonly'=>'readonly']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_apellidos', 'Apellidos:') !!}
    {!! Form::text('usu_apellidos', null, ['class' => 'form-control','required'=>'required','readonly'=>'readonly']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('name', 'Nombres:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','required'=>'required','readonly'=>'readonly']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('email', 'E-mail:') !!}
    {!! Form::text('email', null, ['class' => 'form-control','required'=>'required','readonly'=>'readonly']) !!}
</div>

<span class="divisor col-sm-12">CAMBIO DE CLAVE</span>
<div class="form-group col-sm-3">
    {!! Form::label('psw_n', 'Nueva Clave:') !!}
    {{ Form::password('psw_n',['class' => 'form-control','autocomplete'=>'off']) }}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('password', 'Repita Clave:') !!}
    {{ Form::password('password',['class' => 'form-control','autocomplete'=>'off']) }}
</div>
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
</div>

