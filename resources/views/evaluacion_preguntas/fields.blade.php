<!-- Evg Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evg_id', 'Evg Id:') !!}
    {!! Form::number('evg_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Evp Pregunta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evp_pregunta', 'Evp Pregunta:') !!}
    {!! Form::text('evp_pregunta', null, ['class' => 'form-control']) !!}
</div>

<!-- Evp Imagen Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evp_imagen', 'Evp Imagen:') !!}
    {!! Form::text('evp_imagen', null, ['class' => 'form-control']) !!}
</div>

<!-- Evp Valor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evp_valor', 'Evp Valor:') !!}
    {!! Form::number('evp_valor', null, ['class' => 'form-control']) !!}
</div>

<!-- Evp Resp1 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evp_resp1', 'Evp Resp1:') !!}
    {!! Form::text('evp_resp1', null, ['class' => 'form-control']) !!}
</div>

<!-- Evp Resp2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evp_resp2', 'Evp Resp2:') !!}
    {!! Form::text('evp_resp2', null, ['class' => 'form-control']) !!}
</div>

<!-- Evp Resp3 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evp_resp3', 'Evp Resp3:') !!}
    {!! Form::text('evp_resp3', null, ['class' => 'form-control']) !!}
</div>

<!-- Evp Resp4 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evp_resp4', 'Evp Resp4:') !!}
    {!! Form::text('evp_resp4', null, ['class' => 'form-control']) !!}
</div>

<!-- Evp Resp5 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evp_resp5', 'Evp Resp5:') !!}
    {!! Form::text('evp_resp5', null, ['class' => 'form-control']) !!}
</div>

<!-- Evp Resp Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evp_resp', 'Evp Resp:') !!}
    {!! Form::number('evp_resp', null, ['class' => 'form-control']) !!}
</div>

<!-- Evp Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('evp_estado', 'Evp Estado:') !!}
    {!! Form::number('evp_estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('evaluacionPreguntas.index') !!}" class="btn btn-default">Cancel</a>
</div>
