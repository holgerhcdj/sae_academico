<table class="table table-responsive" id="movimientosRequerimientos-table">
    <thead>
        <tr>
            <th>Emisor</th>
            <th>Para</th>
            <th>Copia</th>
            <th>Tramite</th>
            <th>Detalle</th>
        </tr>
    </thead>
    <tbody>
        @foreach($movimientosRequerimiento as $movimientosRequerimiento)
        <tr>
            <td>{!! $movimientosRequerimiento->usu_apellidos.' '. $movimientosRequerimiento->name !!}</td>
            <td>{!! $movimientosRequerimiento->personas !!}</td>
            <td>{!! $movimientosRequerimiento->cc_personas !!}</td>
            <td>{!! $movimientosRequerimiento->nombre_tramite!!}</td>
            <td>{!! $movimientosRequerimiento->mvr_descripcion!!}</td>

        </tr>
        @endforeach
    </tbody>
</table>