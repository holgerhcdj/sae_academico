<!-- Movid Field -->
<div class="form-group col-sm-6" hidden="">
    {!! Form::label('movid', 'Movid:') !!}
    <p>{!! $movimientos->movid !!}</p>
</div>

<!-- Proid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('proid', 'Proid:') !!}
    <p>{!! $movimientos->pro_descripcion !!}</p>
</div>

<!-- Div Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('div_id', 'Div Id:') !!}
    <p>{!! $movimientos->div_descripcion !!}</p>
</div>

<!-- Movfecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('movfecha', 'Fecha:') !!}
    <p>{!! $movimientos->movfecha !!}</p>
</div>

<!-- Movtipo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('movtipo', 'Tipo:') !!}
    <p>@if($movimientos->estado==0)
                {{'Ingreso'}}
                @elseif($movimientos->estado==1)
                {{'Egreso'}}   
                @endif</p>
</div>

<!-- Mov Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mov', 'Mov:') !!}
    <p>{!! $movimientos->mov !!}</p>
</div>

<!-- Movtpdoc Field -->
<div class="form-group col-sm-6">
    {!! Form::label('movtpdoc', 'Tipo doc:') !!}
    <p>@if($movimientos->estado==0)
                {{'Factura'}}
                @elseif($movimientos->estado==1)
                {{'Nota de Venta'}}   
                @endif</p>
</div>

<!-- Movnumdoc Field -->
<div class="form-group col-sm-6">
    {!! Form::label('movnumdoc', 'Número doc:') !!}
    <p>{!! $movimientos->movnumdoc !!}</p>
</div>

<!-- Movvalorunit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('movvalorunit', 'Valor unit:') !!}
    <p>{!! $movimientos->movvalorunit !!}</p>
</div>

<!-- Procaracteristicas Field -->
<div class="form-group col-sm-6">
    {!! Form::label('procaracteristicas', 'Características:') !!}
    <p>{!! $movimientos->procaracteristicas !!}</p>
</div>

<!-- Proserie Field -->
<div class="form-group col-sm-6">
    {!! Form::label('proserie', 'Serie:') !!}
    <p>{!! $movimientos->proserie !!}</p>
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    <p>{!! $movimientos->observaciones !!}</p>
</div>

<!-- Movestado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('movestado', 'Estado:') !!}
    <p>@if($movimientos->estado==0)
                {{'Activo'}}
                @elseif($movimientos->estado==1)
                {{'Inactivo'}}   
                @endif</p>
</div>

