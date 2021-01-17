<?php
$hidden = "hidden";
?>
<!-- Anl Id Field -->
<div class="form-group col-sm-6" <?php echo $hidden; ?> >
    {!! Form::label('anl_id', 'Anl Id:') !!}
    {!! Form::number('anl_id', $datos['anl_id'], ['class' => 'form-control']) !!}
</div>

<!-- Suc Id Field -->
<div class="form-group col-sm-6" <?php echo $hidden; ?> >
    {!! Form::label('suc_id', 'Suc Id:') !!}
    {!! Form::number('suc_id', $datos['suc_id'], ['class' => 'form-control']) !!}
</div>

<!-- Jor Id Field -->
<div class="form-group col-sm-6" <?php echo $hidden; ?> >
    {!! Form::label('jor_id', 'Jor Id:') !!}
    {!! Form::number('jor_id', $datos['jor_id'], ['class' => 'form-control']) !!}
</div>

<!-- Esp Id Field -->
<div class="form-group col-sm-6" <?php echo $hidden; ?> >
    {!! Form::label('esp_id', 'Esp Id:') !!}
    {!! Form::number('esp_id', $datos['esp_id'], ['class' => 'form-control']) !!}
</div>

<!-- Cur Id Field -->
<div class="form-group col-sm-6" <?php echo $hidden; ?> >
    {!! Form::label('cur_id', 'Cur Id:') !!}
    {!! Form::number('cur_id', $datos['anl_id'], ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6" <?php echo $hidden; ?> >
    {!! Form::label('tipo', 'Cur Id:') !!}
    {!! Form::number('tipo', $datos['tipo'], ['class' => 'form-control']) !!}
</div>

<!-- Mtr Id Field -->
<div class="form-group col-sm-3">

    <select name="mtr_id" id="mtr_id" class="form-control" >
        <option value="0">Nueva Materia</option>
        @foreach($materias as $m)
        <option value="{{$m->id}}">{{$m->mtr_descripcion .' ->('.$m->esp_descripcion.')'}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-sm-3">
    {!! Form::text('mtr_descripcion', null, ['class' => 'form-control','placeholder'=>'NUEVA MATERIA']) !!}
</div>

<!-- Horas Field -->
<div class="form-group col-sm-2">
    {!! Form::number('horas', null, ['class' => 'form-control','required'=>'required','placeholder'=>'Número de Horas']) !!}
</div>
<div class="form-group col-sm-2">
    {!! Form::number('bloques', null, ['class' => 'form-control','required'=>'required','placeholder'=>'Número de Bloques']) !!}
</div>
<!-- Obs Field -->
<div class="form-group col-sm-3" hidden="">
    {!! Form::text('obs', null, ['class' => 'form-control','placeholder'=>'Observaciones']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-1">
    {!! Form::submit('+', ['class' => 'btn btn-primary','title'=>'Asignar Materia']) !!}
</div>
