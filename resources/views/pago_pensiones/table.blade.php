<table class="table table-responsive" id="pagoPensiones-table">
    <thead>
        <tr>
        <th>Nombre Orden</th>
        <th>Codigo Orden</th>
        <th>Solicitado</th>
        <th>Recaudado</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pagoPensiones as $pagoPensiones)
        <tr>
            <td>{!! $pagoPensiones->obs !!}</td>
            <td>{!! $pagoPensiones->identificador !!}</td>
            <td>{!! number_format($pagoPensiones->vsolicitado,2) !!}</td>
            <td>{!! number_format($pagoPensiones->vrecaudado,2) !!}</td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('pagoPensiones.show', [$pagoPensiones->identificador]) !!}" class='btn btn-default btn-xs' title="Detalle"><i class="glyphicon glyphicon-list"></i></a>
                    <a href="{!! route('pagoPensiones.edit', [$pagoPensiones->identificador]) !!}" class='btn btn-default btn-xs' title="Personas por rubros"><i class="glyphicon glyphicon-file"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>