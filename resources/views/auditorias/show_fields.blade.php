<!-- Adt Id Field -->
<div class="form-group col-sm-3" hidden="">
    {!! Form::label('adt_id', 'Id:') !!}
    <p>{!! $auditoria->adt_id !!}</p>
</div>

<div class="form-group col-sm-3">
    {!! Form::label('usu_login', 'Usuario:') !!}
    <p>{!! $auditoria->usu_login !!}</p>
</div>
<!-- Adt Date Field -->
<div class="form-group col-sm-3">
    {!! Form::label('adt_date', 'Date:') !!}
    <p>{!! $auditoria->adt_date !!}</p>
</div>

<!-- Adt Hour Field -->
<div class="form-group col-sm-3">
    {!! Form::label('adt_hour', 'Hour:') !!}
    <p>{!! $auditoria->adt_hour !!}</p>
</div>

<!-- Adt Modulo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('adt_modulo', 'Modulo:') !!}
    <p>{!! $auditoria->adt_modulo !!}</p>
</div>

<!-- Adt Accion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('adt_accion', 'Accion:') !!}
    <p>{!! $auditoria->adt_accion !!}</p>
</div>

<!-- Adt Ip Field -->
<div class="form-group col-sm-3">
    {!! Form::label('adt_ip', 'Ip:') !!}
    <p>{!! $auditoria->adt_ip !!}</p>
</div>

<!-- Adt Documento Field -->
<div class="form-group col-sm-6">
    {!! Form::label('adt_documento', 'Documento:') !!}
    <p>{!! $auditoria->adt_documento !!}</p>
</div>

<!-- Adt Campo Field -->
<div class="form-group col-sm-12">
    {!! Form::label('adt_campo', 'Datos:') !!}
    <p>{!! $auditoria->adt_campo !!}</p>
</div>

<div class="form-group col-sm-3">
    <a href="{!! route('auditorias.index') !!}" class="btn btn-danger">Regresar</a>
</div>

{{-- <!-- Adt Vi Field -->
<div class="form-group col-sm-3">
    {!! Form::label('adt_vi', 'Adt Vi:') !!}
    <p>{!! $auditoria->adt_vi !!}</p>
</div>

<!-- Adt Vf Field -->
<div class="form-group col-sm-3">
    {!! Form::label('adt_vf', 'Adt Vf:') !!}
    <p>{!! $auditoria->adt_vf !!}</p>
</div>

<!-- Usu Login Field -->
<div class="form-group col-sm-3">
    {!! Form::label('usu_login', 'Usu Login:') !!}
    <p>{!! $auditoria->usu_login !!}</p>
</div>
 --}}
