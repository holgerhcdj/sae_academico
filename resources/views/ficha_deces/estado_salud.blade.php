<span class="divisor col-sm-12">
ANTECEDENTES DE SALUD
{!! Form::checkbox('sa_si',null, ['class' => 'form-control']) !!}
</span>

<div class="form-group col-sm-3">
    {!! Form::label('es_enfermedad1', 'Enfermedad:') !!}
    {!! Form::text('es_enfermedad1', null, ['class' => 'form-control enfermedad']) !!}
</div>

<!-- Es Enfermedad2 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_enfermedad2', 'Enfermedad:') !!}
    {!! Form::text('es_enfermedad2', null, ['class' => 'form-control enfermedad']) !!}
</div>

<!-- Es Enfermedad3 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_enfermedad3', 'Enfermedad:') !!}
    {!! Form::text('es_enfermedad3', null, ['class' => 'form-control enfermedad']) !!}
</div>
<!-- Es Enfermedad4 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_enfermedad4', 'Enfermedad:') !!}
    {!! Form::text('es_enfermedad4', null, ['class' => 'form-control enfermedad']) !!}
</div>

<!-- Es Tratamiento1 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_tratamiento1', 'Tratamiento:') !!}
    {!! Form::textarea('es_tratamiento1', null, ['class' => 'form-control enfermedad','rows'=>'3']) !!}
</div>

<!-- Es Tratamiento2 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_tratamiento2', 'Tratamiento:') !!}
    {!! Form::textarea('es_tratamiento2', null, ['class' => 'form-control enfermedad','rows'=>'3']) !!}
</div>

<!-- Es Tratamiento3 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_tratamiento3', 'Tratamiento:') !!}
    {!! Form::textarea('es_tratamiento3', null, ['class' => 'form-control enfermedad','rows'=>'3']) !!}
</div>

<!-- Es Tratamiento4 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_tratamiento4', 'Tratamiento:') !!}
    {!! Form::textarea('es_tratamiento4', null, ['class' => 'form-control enfermedad','rows'=>'3']) !!}
</div>

<!-- Es Alergias1 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_alergias1', 'Alergias:') !!}
    {!! Form::textarea('es_alergias1', null, ['class' => 'form-control enfermedad','rows'=>'4']) !!}
</div>
<!-- Es Operaciones1 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_operaciones1', 'Operaciones:') !!}
    {!! Form::textarea('es_operaciones1', null, ['class' => 'form-control enfermedad','rows'=>'4']) !!}
</div>
<!-- Es Ant Graves Fmla1 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_ant_graves_fmla1', 'Antecedentes Familiares Graves:') !!}
    {!! Form::textarea('es_ant_graves_fmla1', null, ['class' => 'form-control enfermedad','rows'=>'4']) !!}
</div>
<span class="divisor col-sm-12">
    SEGURO
</span>
<!-- Es Tipo Seguro Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_tipo_seguro', 'Tiene Seguro?:') !!}
    {!! Form::select('es_tipo_seguro',['0'=>'NO','1'=>'IESS','2'=>'OTRO'],null, ['class' => 'form-control']) !!}
</div>
<!-- Es Seguro Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_seguro', 'Nombre del Seguro:') !!}
    {!! Form::text('es_seguro', null, ['class' => 'form-control']) !!}
</div>

<!-- Es Observaciones Field -->
<div class="form-group col-sm-6">
    {!! Form::label('es_observaciones', 'Observaciones:') !!}
    {!! Form::textarea('es_observaciones', null, ['class' => 'form-control','rows'=>'1']) !!}
</div>
<!-- Es Maps Field -->
<!-- <div class="form-group col-sm-3">
    {!! Form::label('es_maps', 'Croquis:') !!}
    {!! Form::text('es_maps', null, ['class' => 'form-control']) !!}
    
</div> -->
