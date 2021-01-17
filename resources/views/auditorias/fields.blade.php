<!-- Usu Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Adt Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('adt_date', 'Adt Date:') !!}
    {!! Form::date('adt_date', null, ['class' => 'form-control']) !!}
</div>

<!-- Adt Hour Field -->
<div class="form-group col-sm-6">
    {!! Form::label('adt_hour', 'Adt Hour:') !!}
    {!! Form::text('adt_hour', null, ['class' => 'form-control']) !!}
</div>

<!-- Adt Modulo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('adt_modulo', 'Adt Modulo:') !!}
    {!! Form::text('adt_modulo', null, ['class' => 'form-control']) !!}
</div>

<!-- Adt Accion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('adt_accion', 'Adt Accion:') !!}
    {!! Form::text('adt_accion', null, ['class' => 'form-control']) !!}
</div>

<!-- Adt Ip Field -->
<div class="form-group col-sm-6">
    {!! Form::label('adt_ip', 'Adt Ip:') !!}
    {!! Form::text('adt_ip', null, ['class' => 'form-control']) !!}
</div>

<!-- Adt Documento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('adt_documento', 'Adt Documento:') !!}
    {!! Form::text('adt_documento', null, ['class' => 'form-control']) !!}
</div>

<!-- Adt Campo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('adt_campo', 'Adt Campo:') !!}
    {!! Form::text('adt_campo', null, ['class' => 'form-control']) !!}
</div>

<!-- Adt Vi Field -->
<div class="form-group col-sm-6">
    {!! Form::label('adt_vi', 'Adt Vi:') !!}
    {!! Form::text('adt_vi', null, ['class' => 'form-control']) !!}
</div>

<!-- Adt Vf Field -->
<div class="form-group col-sm-6">
    {!! Form::label('adt_vf', 'Adt Vf:') !!}
    {!! Form::text('adt_vf', null, ['class' => 'form-control']) !!}
</div>

<!-- Usu Login Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_login', 'Usu Login:') !!}
    {!! Form::text('usu_login', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('auditorias.index') !!}" class="btn btn-default">Cancel</a>
</div>
