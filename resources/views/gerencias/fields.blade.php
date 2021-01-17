<!-- Ger Codigo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_codigo', 'Codigo:') !!}
    {!! Form::text('ger_codigo', null, ['class' => 'form-control ','required']) !!}
</div>

<!-- Ger Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_descripcion', 'Descripcion:') !!}
    {!! Form::text('ger_descripcion', null, ['class' => 'form-control','required']) !!}
</div>

<!-- Ger Ruc Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_ruc', 'Ruc:') !!}
    {!! Form::text('ger_ruc', null, ['class' => 'form-control','required']) !!}
</div>

<!-- Ger Direccion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_direccion', 'Direccion:') !!}
    {!! Form::text('ger_direccion', null, ['class' => 'form-control  ','required']) !!}
</div>

<!-- Ger Telefono Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_telefono', 'Telefono:') !!}
    {!! Form::text('ger_telefono', null, ['class' => 'form-control','required']) !!}
</div>


<!-- Ger Rep Legal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_rep_legal', 'Rep Legal:') !!}
    {!! Form::text('ger_rep_legal', null, ['class' => 'form-control  ','required']) !!}
</div>

<!-- Ger Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_estado', 'Estado:') !!}
    {!! Form::select('ger_estado',['0'=>'Activo','1'=>'Inactivo'],null, ['class' => 'form-control','required']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('gerencias.index') !!}" class="btn btn-danger pull-right">Cancel</a>
</div>
