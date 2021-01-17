<!-- Usu Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id',Auth::user()->id, ['class' => 'form-control']) !!}
</div>

<!-- Revisado Field -->
<div class="form-group col-sm-6" hidden >
    {!! Form::label('revisado', 'Revisado:') !!}
    {!! Form::text('revisado', null, ['class' => 'form-control']) !!}
</div>

<!-- Asunto Field -->
<div class="form-group col-sm-6">
    {!! Form::label('asunto', 'Asunto:') !!}
    {!! Form::text('asunto', null, ['class' => 'form-control']) !!}
</div>

<!-- F Registro Field -->
<div class="form-group col-sm-6">
    {!! Form::label('f_registro', 'F Registro:') !!}
    {!! Form::date('f_registro',date('Y-m-d'), ['class' => 'form-control','readonly']) !!}
</div>

<!-- F Vista Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('f_vista', 'F Vista:') !!}
    {!! Form::date('f_vista', null, ['class' => 'form-control']) !!}
</div>

<!-- Detalle Field -->
<div class="form-group col-sm-6">
    {!! Form::label('detalle', 'Detalle:') !!}
    {!! Form::textarea('detalle', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado',['0'=>'Solicitado','1'=>'Aprobado','2'=>'Rechazado'],null, ['class' => 'form-control']) !!}
</div>

<!-- Contestacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contestacion', 'Contestacion:') !!}
    {!! Form::textarea('contestacion', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('sugerencias.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
