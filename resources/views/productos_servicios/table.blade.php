<table class="table table-responsive" id="productosServicios-table">
    <thead>
        <tr>
            <th>Codigo</th>
        <th>Gerencia</th>
        <th>Tipo</th>
        <th>Descripcion</th>
        <th>Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($productosServicios as $productosServicios)
        <tr>
            <td>{!! $productosServicios->pro_codigo !!}</td>
            <td>{!! $productosServicios->ger_descripcion !!}</td>
            <td>
                @if($productosServicios->pro_tipo==1)
                {{'Servicios'}}
                @else
                {{'Productos'}}
                @endif
            </td>
            <td>{!! $productosServicios->pro_descripcion !!}</td>
            <td>
                @if($productosServicios->pro_estado==0)
                {{'Activo'}}
                @else
                {{'Inactivo'}}
                @endif                
            </td>
            <td>
                {!! Form::open(['route' => ['productosServicios.destroy', $productosServicios->pro_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('productosServicios.show', [$productosServicios->pro_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-book text-danger"></i></a>
                    <a href="{!! route('productosServicios.edit', [$productosServicios->pro_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>