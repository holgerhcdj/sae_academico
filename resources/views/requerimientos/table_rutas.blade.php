<table class="table table-responsive" id="requerimientos-table">
    <thead>
        <tr>
            <th>No</th>
            <th>De</th>  
            <th>Para</th>
            <th>Cc</th>
            <th>Descripcion</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php $n=1?>
        @foreach($movimientosRequerimiento as $req)
        <tr>
            <td>{!! $n++ !!}</td>
            <td>{!! $req->usu_apellidos." ".$req->name !!}</td>
            <td>{!! $req->personas !!}</td>
            <td>{!! $req->cc_personas !!}</td>
            <td>{!! $req->mvr_descripcion !!}</td>
            <td>{!! $req->mvr_fecha.' '.$req->mvr_hora !!}</td>
        </tr>
        @endforeach

    </tbody>
</table>