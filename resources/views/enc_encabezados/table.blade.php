<table class="table table-responsive" id="encEncabezados-table">
    <thead>
        <tr>
            <th>#</th>
        <th>Descripcion</th>
        <th>Objetivo</th>
        <th>F.Reg</th>
        <th>Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($encEncabezados as $encEncabezado)
        <tr>
            <td>{!! $encEncabezado->enc_numero !!}</td>
            <td>{!! $encEncabezado->enc_descripcion !!}</td>
            <td>{!! $encEncabezado->enc_objetivo !!}</td>
            <td>{!! $encEncabezado->enc_freg !!}</td>
            <td>{!! $encEncabezado->enc_estado !!}</td>
            <td style="width:100px; ">
                {!! Form::open(['route' => ['encEncabezados.destroy', $encEncabezado->enc_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('encEncabezados.show', [$encEncabezado->enc_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-list text-danger"></i></a>
                    <a href="{!! route('encEncabezados.edit', [$encEncabezado->enc_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil"></i></a>
<!--                     {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} -->
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>