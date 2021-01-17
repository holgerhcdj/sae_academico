<style>
    .btn_enc i{
        font-size:25px; 
        padding:10px; 
    }
</style>
<table class="table table-responsive" id="encRegistros-table">
    <thead>
        <tr>
            <th>Numero</th>
        <th>Encuesta</th>
        <th>Estado</th>
        </tr>
    </thead>
    <tbody>
    @foreach($encRegistros as $encr)
        <tr>
            <td>{!! $encr->enc_numero !!}</td>
            <td>{!! $encr->enc_descripcion !!}</td>
            <td>
                @if($encr->enc_estado==0)
                {{'Activo'}}
                @else
                {{'Inactivo'}}
                @endif
            </td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('encRegistros.show', [$encr->enc_id]) !!}" class='btn btn-default btn-xs btn_enc'><i class="fa fa-arrow-right text-success"> Realizar</i></a>
                    <a href="{!! route('encRegistros.edit', [$encr->enc_id]) !!}" style="margin-left:10px; " class='btn btn-default btn-xs btn_enc' target="_blank"><i class="fa fa-print text-danger"> Imprimir</i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>