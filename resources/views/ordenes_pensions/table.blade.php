<table class="table table-responsive" id="ordenesPensions-table" >
    <thead>
        <tr>
            <th>Anl Id</th>
        <th>Mat Id</th>
        <th>Fecha</th>
        <th>Mes</th>
        <th>Codigo</th>
        <th>Valor</th>
        <th>Fecha Pago</th>
        <th>Tipo</th>
        <th>Estado</th>
        <th>Responsable</th>
        <th>Obs</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($ordenesPensions as $ordenesPension)
        <tr>
            <td>{!! $ordenesPension->anl_id !!}</td>
            <td>{!! $ordenesPension->mat_id !!}</td>
            <td>{!! $ordenesPension->fecha !!}</td>
            <td>{!! $ordenesPension->mes !!}</td>
            <td>{!! $ordenesPension->codigo !!}</td>
            <td>{!! $ordenesPension->valor !!}</td>
            <td>{!! $ordenesPension->fecha_pago !!}</td>
            <td>{!! $ordenesPension->tipo !!}</td>
            <td>{!! $ordenesPension->estado !!}</td>
            <td>{!! $ordenesPension->responsable !!}</td>
            <td>{!! $ordenesPension->obs !!}</td>
            <td>
                {!! Form::open(['route' => ['ordenesPensions.destroy', $ordenesPension->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('ordenesPensions.show', [$ordenesPension->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('ordenesPensions.edit', [$ordenesPension->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>