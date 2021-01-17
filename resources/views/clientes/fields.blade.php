<?php
if(isset($Clientes)){
    $f=$Clientes->cli_fecha;
}else{
    $f=date('Y-m-d');

}

?>
<!-- Cli Raz Social Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('cli_raz_social', 'Raz Social:') !!}
    {!! Form::text('cli_raz_social', null, ['class' => 'form-control']) !!}
</div>

<!-- Cli Retencion Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('cli_retencion', 'Retencion:') !!}
    {!! Form::text('cli_retencion', null, ['class' => 'form-control']) !!}
</div>

<!-- Cli Cup Maximo Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('cli_cup_maximo', 'Cup Maximo:') !!}
    {!! Form::number('cli_cup_maximo', null, ['class' => 'form-control']) !!}
</div>

<!-- Cli Nacionalidad Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('cli_nacionalidad', 'Nacionalidad:') !!}
    {!! Form::text('cli_nacionalidad', null, ['class' => 'form-control']) !!}
</div>
<!-- Cli Fecha Field -->
<div class="form-group col-sm-6" hidden >
    {!! Form::label('cli_fecha', 'Fecha:') !!}
    {!! Form::text('cli_fecha', null, ['class' => 'form-control']) !!}
</div>
<!-- Cli Codigo Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('cli_codigo', 'Codigo:') !!}
    {!! Form::text('cli_codigo', null, ['class' => 'form-control']) !!}
</div>

<!-- Cli Apellidos Field -->
<div class="form-group col-sm-6">
    <div class="input-group">    
        {!! Form::label('cli_apellidos', 'Apellidos:',['class'=>'input-group-addon'] ) !!}
        {!! Form::text('cli_apellidos', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Cli Nombres Field -->
<div class="form-group col-sm-6">
    <div class="input-group">    
    {!! Form::label('cli_nombres', 'Nombres:',['class'=>'input-group-addon']) !!}
    {!! Form::text('cli_nombres', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Cli Ced Ruc Field -->
<div class="form-group col-sm-6">
    <div class="input-group">    
    {!! Form::label('cli_ced_ruc', 'Ced Ruc:',['class'=>'input-group-addon']) !!}
    {!! Form::text('cli_ced_ruc', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Cli Direccion Field -->
<div class="form-group col-sm-6">
    <div class="input-group">    
    {!! Form::label('cli_direccion', 'Direccion:',['class'=>'input-group-addon']) !!}
    {!! Form::text('cli_direccion', null, ['class' => 'form-control']) !!}
    </div>
</div>
<!-- Cli Telefono Field -->
<div class="form-group col-sm-6">
    <div class="input-group">    
    {!! Form::label('cli_telefono', 'Telefono:',['class'=>'input-group-addon']) !!}
    {!! Form::text('cli_telefono', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Cli Email Field -->
<div class="form-group col-sm-6">
    <div class="input-group">    
    {!! Form::label('cli_email', 'Email:',['class'=>'input-group-addon']) !!}
    {!! Form::text('cli_email', null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Cli Estado Field -->
<div class="form-group col-sm-6">
    <div class="input-group">    
    {!! Form::label('cli_estado', 'Estado:',['class'=>'input-group-addon']) !!}
    {!! Form::select('cli_estado',['0'=>'Activo','1'=>'Inactivo'],null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar' , ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('clientes.index') !!}" class="btn btn-danger pull-right"><i class='fa fa-close'></i> Salir</a>
</div>
