<span class="divisor col-sm-12">
    DISCAPACIDAD
    {!! Form::checkbox('es_discapacidad',null, ['class' => 'form-control']) !!}
</span>
<div class="form-group col-sm-2">
    {!! Form::label('es_porcentage_disc', 'Porcentaje %:') !!}
    {!! Form::text('es_porcentage_disc',null, ['class' => 'form-control input-number discapacidad']) !!}
</div>
<div class="form-group col-sm-4">
    {!! Form::label('es_tipo_discapacidad', 'Tipo de Discapacidad:') !!}
    {!! Form::text('es_tipo_discapacidad',null, ['class' => 'form-control discapacidad']) !!}
</div>
<div class="form-group col-sm-2">
    {!! Form::label('es_carnet_conadis', 'Carnet del CONADIS:') !!}
    {!! Form::select('es_carnet_conadis',['0'=>'Si','1'=>'No','2'=>'Trámite'],null, ['class' => 'form-control discapacidad']) !!}
</div>
<!-- Es Vive Persona Discapacidad Field -->
<div class="form-group col-sm-4">
    {!! Form::label('es_vive_persona_discapacidad', 'Vive con persona con discapacidad:') !!}
    {!! Form::text('es_vive_persona_discapacidad', null, ['class' => 'form-control input-text discapacidad','placeholder'=>'Madre/Padre/Hermano/Otro']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('es_tratamiento_disc', 'Tratamiento:') !!}
    {!! Form::textarea('es_tratamiento_disc',null,['class' => 'form-control discapacidad','rows'=>'1']) !!}
</div>
<span class="divisor col-sm-12">
    
</span>

<div class="form-group col-sm-5">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado',['0'=>'Eliga una opción','1'=>'Aceptado','2'=>'Rechazado'],null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12" style="margin-top: 10px">
    <a href="{!! route('fichaDeces.index') !!}" class="btn btn-danger pull-right ">Cancelar</a>
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary pull-left ']) !!}
</div>
