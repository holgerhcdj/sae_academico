<!-- Segid Field -->
<div class="form-group" hidden="">
    {!! Form::label('segid', 'Segid:') !!}
    <p>{!! Auth::User()->id !!}</p>
</div>

<!-- Usu Id Field -->
<div class="form-group col-sm-4" hidden="">
    {!! Form::label('usu_id', 'Usu Id:') !!}
    <p>{!! Auth::User()->id !!}</p>
</div>

<!-- Usu Id2 Field -->
<div class="form-group col-sm-4">
    {!! Form::label('usu_id2', 'Capellan:') !!}
    <p>{!! $seguimientoCapDocentes->usu_apellidos.' '.$seguimientoCapDocentes->name !!}</p>
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-4">
    {!! Form::label('fecha', 'Fecha:') !!}
    <p>{!! $seguimientoCapDocentes->fecha !!}</p>
</div>

<!-- Historia Vida Field -->
<div class="form-group col-sm-4">
    {!! Form::label('historia_vida', 'Historia Vida:') !!}
    <p>{!! $seguimientoCapDocentes->historia_vida !!}</p>
</div>

<!-- Situacion Academica Field -->
<div class="form-group col-sm-4">
    {!! Form::label('situacion_academica', 'Situacion Academica:') !!}
    <p>{!! $seguimientoCapDocentes->situacion_academica !!}</p>
</div>

<!-- Recomendaciones Field -->
<div class="form-group col-sm-4">
    {!! Form::label('recomendaciones', 'Recomendaciones:') !!}
    <p>{!! $seguimientoCapDocentes->recomendaciones !!}</p>
</div>

<!-- Necesidad Oracion Field -->
<div class="form-group col-sm-4">
    {!! Form::label('necesidad_oracion', 'Necesidad Oracion:') !!}
    <p>{!! $seguimientoCapDocentes->necesidad_oracion !!}</p>
</div>

<!-- Recomendacion Field -->
<div class="form-group col-sm-4">
    {!! Form::label('recomendacion', 'Recomendacion:') !!}
    <p>{!! $seguimientoCapDocentes->recomendacion !!}</p>
</div>

<!-- Estado Field -->
<div class="form-group col-sm-4">
    {!! Form::label('estado', 'Estado:') !!}
    <p>@if($seguimientoCapDocentes->estado==0)
                {{'Activo'}}
                @elseif($seguimientoCapDocentes->estado==1)
                {{'Inactivo'}}   
                @endif</p>
</div>

