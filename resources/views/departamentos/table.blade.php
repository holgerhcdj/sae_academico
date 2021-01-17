<table class="table table-responsive" id="departamentos-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Gerencia</th>
            <th>Descripcion</th>
            <th>Obs</th>
            <th colspan="3">Accion</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=1?>
    @foreach($departamentos as $departamentos)
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $departamentos->ger_descripcion !!}</td>
            <td>{!! $departamentos->descripcion !!}</td>
            <td>{!! $departamentos->descripcion !!}</td>
            <td>{!! $departamentos->obs !!}</td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('departamentos.edit', [$departamentos->id]) !!}" title="Editar" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                    <a href="{!! route('departamentos.show', [$departamentos->id]) !!}" title="Configurar permisos" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-cog text-danger"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>