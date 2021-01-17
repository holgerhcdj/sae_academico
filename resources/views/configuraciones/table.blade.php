<table class="table table-responsive" id="configuraciones-table">
    <thead>
        <tr>
        <th>Descripcion</th>
        <th>Valor</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($configuraciones as $configuraciones)
        <tr>
            <td>{!! $configuraciones->con_nombre !!}</td>
            <td>
                @if($configuraciones->con_valor==0)
                {{'Inactivo'}}
                @else
                {{'Activo'}}
                @endif
            </td>
            <td>
                    <a href="{!! route('configuraciones.edit', [$configuraciones->con_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>