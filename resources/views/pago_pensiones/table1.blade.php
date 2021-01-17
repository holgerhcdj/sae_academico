<table class="table table-responsive" id="pagoPensiones-table">
    <thead>
        <tr>
        <th>Descripcion</th>
        <th>SAE</th>
        <th>Cedula</th>
        <th>Estudiante</th>
        <th>Valor Pagar</th>
        <th>Fecha Pago</th>
        <th>Valor Pagado</th>
        <th>Cod Orden</th>
        <th>F Registro</th>
        <th>Responsable</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pagoPensiones as $pagoPensiones)
        <tr>
            <td>{!! $pagoPensiones->descripcion !!}</td>
            <td>{!! $pagoPensiones->cedula !!}</td>
            <td>{!! $pagoPensiones->estudiante !!}</td>
            <td>{!! $pagoPensiones->valor !!}</td>
            <td>{!! $pagoPensiones->fecha_pago !!}</td>
            <td>{!! $pagoPensiones->valor_p !!}</td>
            <td>{!! $pagoPensiones->cod_orden !!}</td>
            <td>{!! $pagoPensiones->f_registro !!}</td>
            <td>{!! $pagoPensiones->responsable !!}</td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('pagoPensiones.show', [$pagoPensiones->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>