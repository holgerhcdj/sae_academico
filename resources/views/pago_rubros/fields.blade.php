<!-- Rub Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rub_id', 'Rub Id:') !!}
    {!! Form::number('rub_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Per Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('per_id', 'Per Id:') !!}
    {!! Form::number('per_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Usu Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Pgr Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pgr_fecha', 'Pgr Fecha:') !!}
    {!! Form::date('pgr_fecha', null, ['class' => 'form-control']) !!}
</div>

<!-- Pgr Monto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pgr_monto', 'Pgr Monto:') !!}
    {!! Form::number('pgr_monto', null, ['class' => 'form-control']) !!}
</div>

<!-- Pgr Forma Pago Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pgr_forma_pago', 'Pgr Forma Pago:') !!}
    {!! Form::text('pgr_forma_pago', null, ['class' => 'form-control']) !!}
</div>

<!-- Pgr Banco Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pgr_banco', 'Pgr Banco:') !!}
    {!! Form::text('pgr_banco', null, ['class' => 'form-control']) !!}
</div>

<!-- Pgr Fecha Efectiviza Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pgr_fecha_efectiviza', 'Pgr Fecha Efectiviza:') !!}
    {!! Form::date('pgr_fecha_efectiviza', null, ['class' => 'form-control']) !!}
</div>

<!-- Pgr Documento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pgr_documento', 'Pgr Documento:') !!}
    {!! Form::text('pgr_documento', null, ['class' => 'form-control']) !!}
</div>

<!-- Pgr Tipo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pgr_tipo', 'Pgr Tipo:') !!}
    {!! Form::number('pgr_tipo', null, ['class' => 'form-control']) !!}
</div>

<!-- Pgr Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pgr_estado', 'Pgr Estado:') !!}
    {!! Form::number('pgr_estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('pagoRubros.index') !!}" class="btn btn-default">Cancel</a>
</div>
