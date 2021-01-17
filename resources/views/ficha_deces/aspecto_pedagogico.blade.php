<span class="divisor col-sm-12">
ASPECTO PEDAGÓGICO
</span>
<!-- Ap Lugar Estudio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_lugar_estudio', 'Tiene un lugar de estudio:') !!}
    {!! Form::select('ap_lugar_estudio',['0'=>'SI','1'=>'NO'],null, ['class' => 'form-control']) !!}
</div>
<!-- Ap Tipo Lugar Estudio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_tipo_lugar_estudio', 'Lugar Estudio:') !!}
    {!! Form::select('ap_tipo_lugar_estudio',['ESTUDIO'=>'ESTUDIO','HABITACIÓN'=>'HABITACIÓN','COMPARTIDO'=>'COMPARTIDO','NO TIENE'=>'NO TIENE'],null, ['class' => 'form-control']) !!}
</div>
<!-- Ap Apoyo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_apoyo', 'Tiene apoyo académico:') !!}
    {!! Form::select('ap_apoyo',['0'=>'SI','1'=>'NO'],null, ['class' => 'form-control']) !!}
</div>
<!-- Ap Apoyo Nombre Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_apoyo_nombre', 'Persona que Apoya:') !!}
    {!! Form::text('ap_apoyo_nombre', null, ['class' => 'form-control']) !!}
</div>
<!-- Ap Recursos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_recursos', 'Posee recursos necesarios para el estudio?:') !!}
    {!! Form::select('ap_recursos',['0'=>'SI','1'=>'NO'],null, ['class' => 'form-control']) !!}
</div>

<!-- Ap Horas Estudio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_horas_estudio', 'Horas destinadas para el estudio:') !!}
    {!! Form::text('ap_horas_estudio', null, ['class' => 'form-control input-number']) !!}
</div>
