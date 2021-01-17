<!-- Anl Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('anl_id', 'Anl Id:') !!}
    {!! Form::number('anl_id', $anl[0]['id'], ['class' => 'form-control']) !!}
</div>

<!-- Usu Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id',null, ['class' => 'form-control']) !!}
</div>

<!-- Suc Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('suc_id', 'Suc Id:') !!}
    {!! Form::number('suc_id', 1, ['class' => 'form-control']) !!}
</div>
<!-- Esp Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('esp_id', 'Esp Id:') !!}
    {!! Form::number('esp_id',10, ['class' => 'form-control']) !!}
</div>

<!-- Tipo Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('tipo', 'Tipo:') !!}
  {!! Form::number('horas', 0, ['class' => 'form-control']) !!}
</div>
<!-- Obs Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('obs', 'Obs:') !!}
    {!! Form::text('obs', null, ['class' => 'form-control']) !!}
</div>
<!-- //////////////****************///////////////// -->
<div class="form-group col-sm-2">
    {!! Form::label('jor_id', 'Jornada:') !!}
    {!! Form::select('jor_id',$jornadas,null,['class'=>'form-control']) !!}
</div>
<!-- Mtr Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('mtr_id', 'Materia:') !!}
    {!! Form::select('mtr_id',$materias,null,['class'=>'form-control']) !!}
</div>
<!-- Cur Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('cur_id', 'Curso:') !!}
    {!! Form::select('cur_id',$cursos,null,['class'=>'form-control']) !!}
</div>
<!-- Paralelo Field -->
<div class="form-group col-sm-2">
    {!! Form::label('paralelo', 'Paralelo:') !!}
    {{ Form::select('paralelo', [
    'A' => 'A',
    'B' => 'B',
    'C' => 'C',
    'D' => 'D',
    'E' => 'E',
    'F' => 'F',
    'G' => 'G',
    'H' => 'H',
    'I' => 'I',
    'J' => 'J',
    ],null,['class' => 'form-control']) }}
</div>

<!-- Horas Field -->
<div class="form-group col-sm-2">
    {!! Form::label('horas', 'Horas:') !!}
    {!! Form::number('horas', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
</div>


