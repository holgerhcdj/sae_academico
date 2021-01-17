<!-- Proid Field -->
<div class="form-group" hidden="">
    {!! Form::label('proid', 'Proid:') !!}
    <p>{!! $productos->proid !!}</p>
</div>

<!-- Tpid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tpid', 'Tipo de Producto:') !!}
    <p>{!! $productos->descripcion !!}</p>
</div>

<!-- Pro Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_descripcion', 'Descripcion:') !!}
    <p>{!! $productos->pro_descripcion !!}</p>
</div>

<!-- Pro Medida Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_medida', ' Medida:') !!}
    <p>{!! $productos->pro_medida !!}</p>
</div>

<!-- Pro Marca Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_marca', ' Marca:') !!}
    <p>{!! $productos->pro_marca !!}</p>
</div>

<!-- Pro Tipo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_tipo', ' Tipo:') !!}
    <p>{!! $productos->pro_tipo !!}</p>
</div>

<!-- Pro Unidad Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_unidad', ' Unidad:') !!}
    <p>{!! $productos->pro_unidad !!}</p>
</div>

<!-- Pro Serie Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_serie', ' Serie:') !!}
    <p>{!! $productos->pro_serie !!}</p>
</div>

<!-- Pro Codigo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_codigo', ' Codigo:') !!}
    <p>{!! $productos->pro_codigo !!}</p>
</div>

<!-- Pro Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pro_estado', ' Estado:') !!}
    <p>@if($productos->estado==0)
                {{'Activo'}}
                @elseif($productos->estado==1)
                {{'Inactivo'}}   
                @endif</p>
</div>

