<!-- Id Field -->
<div class="form-group col-sm-6" >
    {!! Form::label('id', 'Id:') !!}
    <input type="hidden" value="{{$especialidades->id}}" name="id" id="id" />
</div>

<!-- Esp Descripcion Field -->
<div class="form-group col-sm-12">
    {!! Form::label('esp_descripcion', 'Especialidad:') !!}
    <p>{!! $especialidades->esp_descripcion !!}</p>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('mtr_descripcion', 'Materia:') !!}
    {!! Form::text('mtr_descripcion', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6" hidden="hidden">
    {!! Form::label('mtr_tipo', 'Tipo:') !!}
    {!! Form::number('mtr_tipo', '1', ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('mtr_obs', 'Observaciones:') !!}
    {!! Form::text('mtr_obs', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('materias.index') !!}" class="btn btn-default">Cancelar</a>
</div>

