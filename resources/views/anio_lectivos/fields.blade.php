<!-- Anl Descripcion Field -->
<div class="form-group col-sm-3" >
    {!! Form::label('anl_descripcion', 'Descripcion del Periodo:') !!}
    {!! Form::text('anl_descripcion', null, ['class' => 'form-control','required' => 'required']) !!}
</div>
<!-- Anl Selected Field -->
<div class="form-group col-sm-2">
    {!! Form::label('anl_selected', 'Periodo Actual?:') !!}
    {{ Form::select('anl_selected', [
    '1' => 'SI',
    '0' => 'NO',
    ],null,['class' => 'form-control']) }}    
</div>
<div class="form-group col-sm-2">
    {!! Form::label('especial', 'Permitir Matrícula:') !!}
    {{ Form::select('especial', [
    '1' => 'NO',
    '0' => 'SI',
    ],null,['class' => 'form-control']) }}    
    
</div>
<div class="form-group col-sm-2">
    {!! Form::label('votacion', 'Votación Estudiantil:') !!}
    {{ Form::select('votacion', [
    '1' => 'SI',
    '0' => 'NO',
    ],null,['class' => 'form-control']) }}    
</div>
<div class="form-group col-sm-2">
    {!! Form::label('periodo', 'Tipo de Periodo:') !!}
    {{ Form::select('periodo', [
    '0' => 'Regular',
    '1' => 'BGU',
    ],null,['class' => 'form-control']) }}    
</div>

<div class="form-group col-sm-3">
    {!! Form::label('anl_quimestres', 'Quimestres:') !!}
    {{ Form::select('anl_quimestres', [
    '2' => '2',
    ],null,['class' => 'form-control']) }}    
</div>

<div class="form-group col-sm-2">
    {!! Form::label('anl_parciales', 'Parciales x Quimestres:') !!}
    {{ Form::select('anl_parciales', [
    '2' => '2',
    '3' => '3',
    ],null,['class' => 'form-control']) }}    
</div>

<div class="form-group col-sm-2">
    {!! Form::label('anl_evq_tipo', 'Ev. Quimestral:') !!}
    {{ Form::select('anl_evq_tipo', [
    '0' => 'Exámen',
    '1' => 'Proyecto',
    '2' => 'Otro',
    ],null,['class' => 'form-control']) }}    
</div>

<div class="form-group col-sm-2">
    {!! Form::label('anl_peso_ev', 'Peso Ev.Quim %:') !!}
    {!! Form::number('anl_peso_ev', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-2">
    {!! Form::label('anl_ninsumos', 'N° Insumos por parcial :') !!}
    {!! Form::number('anl_ninsumos', null, ['class' => 'form-control']) !!}
</div>

<!-- Anl Obs Field -->
<div class="form-group col-sm-6" >
    {!! Form::label('anl_obs', 'Observaciones:') !!}
    {!! Form::text('anl_obs', null, ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('anioLectivos.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>

</script>
