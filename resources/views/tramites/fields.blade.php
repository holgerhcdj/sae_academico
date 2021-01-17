<!-- Dep Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dep_id', 'Dep Id:') !!}
	{!! Form::select('dep_id',$dep,null,['class'=>'form-control','id'=>'dep_id' ]) !!}    

</div>

<!-- Nombre Tramite Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre_tramite', 'Nombre Tramite:') !!}
    {!! Form::text('nombre_tramite', null, ['class' => 'form-control']) !!}
</div>

<!-- Obs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('obs', 'Obs:') !!}
    {!! Form::text('obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('tramites.index') !!}" class="btn btn-default">Cancelar</a>
</div>
