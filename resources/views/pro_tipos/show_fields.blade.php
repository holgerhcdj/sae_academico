<!-- Tpid Field -->
<div class="form-group col-sm-6" hidden="">
    {!! Form::label('tpid', 'Tpid:') !!}
    <p>{!! $proTipo->tpid !!}</p>
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    <p>{!! $proTipo->descripcion !!}</p>
</div>

<!-- Observacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observacion', 'Observacion:') !!}
    <p>{!! $proTipo->observacion !!}</p>
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    <p>@if($proTipo->estado==0)
                {{'Activo'}}
                @elseif($proTipo->estado==1)
                {{'Inactivo'}}   
                @endif</p>
</div>

