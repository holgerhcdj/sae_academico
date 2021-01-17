<table class="table table-responsive" id="modulos-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Menu</th>
            <th>Submenu</th>
            <th>Direccion</th>
            <th>Grupo</th>
            <th>Estado</th>
            <th colspan="3">Accion</th>
        </tr>
    </thead>
    <tbody>
        @foreach($modulos as $modulos)
        <tr>
            <td>{!! $modulos->id !!}</td>
            <td>{!! $modulos->menu !!}</td>
            <td>{!! $modulos->submenu !!}</td>
            <td>{!! $modulos->direccion !!}</td>
            <td>{!! $modulos->mod_grupo !!}</td>
            <td>
                @if($modulos->estado==0)
                {{'Activo'}}
                @else
                {{'Inactivo'}}
                @endif
            </td>
            <td hidden="">
                {!! Form::open(['route' => ['modulos.destroy', $modulos->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('modulos.show', [$modulos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('modulos.edit', [$modulos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>