<!-- Id Field -->
<div class="form-group" hidden="">
    {!! Form::label('id', 'Id:') !!}
    {!! Form::number('id',$sugerencias->id, ['class' => 'form-control']) !!}
</div>
<!-- Revisado Field -->
<div class="form-group" hidden>
    {!! Form::label('revisado', 'Revisado:') !!}
    {!! Form::text('revisado',Auth::user()->name .' '. Auth::user()->usu_apellidos  , ['class' => 'form-control']) !!}
</div>
<!-- Asunto Field -->
<div class="form-group col-sm-8">
    {!! Form::label('asunto', 'Asunto:') !!}
    <p>{!! $sugerencias->asunto !!}</p>
</div>
<!-- F Registro Field -->
<div class="form-group col-sm-4">
    {!! Form::label('f_registro', 'Fecha de solicitud:') !!}
    <p>{!! $sugerencias->f_registro !!}</p>
</div>
<!-- Detalle Field -->
<div class="form-group col-sm-12">
    {!! Form::label('detalle', 'Detalle:') !!}
    <p>{!! $sugerencias->detalle !!}</p>
</div>
<!-- Contestacion Field -->
<div class="form-group">
    {!! Form::label('contestacion', 'Contestacion:') !!}
    {!! Form::textarea('id',$sugerencias->contestacion, ['class' => 'form-control']) !!}
</div>

