<!-- Div Id Field -->
<div class="form-group col-sm-6" hidden="">
    {!! Form::label('div_id', 'Div Id:') !!}
    <p>{!! $erpDivision->div_id !!}</p>
</div>

<!-- Div Codigo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('div_codigo', ' Codigo:') !!}
    <p>{!! $erpDivision->div_codigo !!}</p>
</div>

<!-- Div Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('div_descripcion', ' Descripcion:') !!}
    <p>{!! $erpDivision->div_descripcion !!}</p>
</div>

<!-- Ger Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ger_id', 'Gerencia:') !!}
    <p>@if($erpDivision->estado==0)
                {{'Unidad Educativa Ténica Vida Nueva'}}
                @endif</p>
</div>

<!-- Div Siglas Field -->
<div class="form-group col-sm-6">
    {!! Form::label('div_siglas', ' Siglas:') !!}
    <p>{!! $erpDivision->div_siglas !!}</p>
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    <p>@if($erpDivision->estado==0)
                {{'Activo'}}
                @elseif($erpDivision->estado==1)
                {{'Inactivo'}}   
                @endif</p>
</div>

