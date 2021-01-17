
<!-- Ger Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_id', 'Sucursal/Gerencia:') !!}
    {!! Form::select('ger_id',$ger,null, ['class' => 'form-control']) !!}
</div>
<!-- Pro Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_estado', 'Estado:') !!}
    {!! Form::select('pro_estado',['0'=>'Activo','1'=>'Inactivo'],null, ['class' => 'form-control']) !!}
</div>
<!-- Pro Codigo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_codigo', 'Codigo:') !!}
    {!! Form::text('pro_codigo', null, ['class' => 'form-control']) !!}
</div>
<!-- Pro Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_descripcion', 'Descripcion:') !!}
    {!! Form::text('pro_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Pro Tipo Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('pro_tipo', 'Pro Tipo:') !!}
    {!! Form::number('pro_tipo',1, ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('productosServicios.index') !!}" class="btn btn-danger pull-right">Salir</a>
</div>
