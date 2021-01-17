<span class="divisor col-sm-12">
ANTECEDENTES ESCOLARES
</span>
<div class="form-group col-sm-3">
    {!! Form::label('ae_primaria', 'Primaria:') !!}
    {!! Form::text('ae_primaria', null, ['class' => 'form-control']) !!}
</div>
<!-- Ae Repetidos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_repetidos', 'Años Repetidos:') !!}
    {!! Form::text('ae_repetidos', null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Causa Rep Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_causa_rep', 'Causa de Repetición:') !!}
    {!! Form::text('ae_causa_rep', null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Inst Procedencia Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_inst_procedencia', 'Intitucion de Procedencia:') !!}
    {!! Form::text('ae_inst_procedencia', null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Motivo Cambio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_motivo_cambio', 'Motivo Cambio:') !!}
    {!! Form::text('ae_motivo_cambio', null, ['class' => 'form-control']) !!}
</div>
<span class="divisor col-sm-12">
    NECESIDADES EDUCATIVAS ESPECIALES
</span>
<!-- Ae Dificultades Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_dificultades', 'Dificultades en alguna materia?:') !!}
    {!! Form::select('ae_dificultades',[
    'NINGUNA'=>'NINGUNA',
    'MATEMÁTICAS'=>'MATEMÁTICAS',
    'CIENCIAS NATURALES'=>'CIENCIAS NATURALES',
    'ESTUDIOS SOCIALES'=>'ESTUDIOS SOCIALES',
    'LENGUA Y LITERATURA'=>'LENGUA Y LITERATURA',
    'INGLÉS'=>'INGLÉS',
    'EDUCACIÓN FÍSICA'=>'EDUCACIÓN FÍSICA',
    ],null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Dif Lectura Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_dif_lectura', 'Presenta Dificultad de Lectura?:') !!}
    {!! Form::select('ae_dif_lectura',['1'=>'NO','0'=>'SI'],null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Dif Escritura Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_dif_escritura', 'Presenta Dificultad de Escritura?:') !!}
    {!! Form::select('ae_dif_escritura',['1'=>'NO','0'=>'SI'],null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Dif Matematica Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_dif_matematica', 'Presenta Dificultad Matematica?:') !!}
    {!! Form::select('ae_dif_matematica',['1'=>'NO','0'=>'SI'],null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Dif Ideas Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_dif_ideas', 'Presenta Dificultad de extracción de Ideas?:') !!}
    {!! Form::select('ae_dif_ideas',['1'=>'NO','0'=>'SI'],null, ['class' => 'form-control']) !!}
</div>
