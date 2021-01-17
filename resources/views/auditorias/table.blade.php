<table class="table table-responsive" id="auditorias-table">
    <thead>
        <tr>
            <th>Usuario</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Modulo</th>
        <th>Accion</th>
        <th>Ip</th>
        <th>Documento</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($auditorias as $auditoria)
        <tr>
            <td>{!! $auditoria->usu_login !!}</td>
            <td>{!! $auditoria->adt_date !!}</td>
            <td>{!! $auditoria->adt_hour !!}</td>
            <td>{!! $auditoria->adt_modulo !!}</td>
            <td>{!! $auditoria->adt_accion !!}</td>
            <td>{!! $auditoria->adt_ip !!}</td>
            <td>{!! $auditoria->adt_documento !!}</td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('auditorias.show', [$auditoria->adt_id]) !!}" title="Detalles" class='btn btn-warning btn-xs'><i class="fa fa-eye text-black "></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>