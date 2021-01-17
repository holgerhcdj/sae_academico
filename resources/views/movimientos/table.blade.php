<table class="table table-responsive" id="movimientos-table">
    <thead>
        <tr>
        <th>#</th>
        <th>Proid</th>
        <th>Div Id</th>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>Mov</th>
        <th>Tipo doc</th>
        <th>Número doc</th>
        <th>Valor unit</th>
        <th>Características</th>
        <th>Serie</th>
        <th>Observaciones</th>
        <th>Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $x=1;
         ?>
    @foreach($movimientos as $movimientos)
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $movimientos->pro_descripcion !!}</td>
            <td>{!! $movimientos->div_descripcion !!}</td>
            <td>{!! $movimientos->movfecha !!}</td>
            <td>@if($movimientos->estado==0)
                {{'Factura'}}
                @elseif($movimientos->estado==1)
                {{'Nota de Venta'}}   
                @endif</td>
            <td>{!! $movimientos->mov !!}</td>
            <td>@if($movimientos->estado==0)
                {{'Ingreso'}}
                @elseif($movimientos->estado==1)
                {{'Egreso'}}   
                @endif</td>
            <td>{!! $movimientos->movnumdoc !!}</td>
            <td>{!! $movimientos->movvalorunit !!}</td>
            <td>{!! $movimientos->procaracteristicas !!}</td>
            <td>{!! $movimientos->proserie !!}</td>
            <td>{!! $movimientos->observaciones !!}</td>
            <td>@if($movimientos->estado==0)
                {{'Activo'}}
                @elseif($movimientos->estado==1)
                {{'Inactivo'}}   
                @endif</td>
            <td>
                {!! Form::open(['route' => ['movimientos.destroy', $movimientos->movid], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('movimientos.show', [$movimientos->movid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('movimientos.edit', [$movimientos->movid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>