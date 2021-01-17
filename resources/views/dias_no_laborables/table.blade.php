<table class="table table-responsive" id="diasNoLaborables-table">
    <thead>
        <tr>
            <th>F_Reg</th>
        <th>Responsable</th>
        <th>F Desde</th>
        <th>F Hasta</th>
        <th>Descripcion</th>
        <th>Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($diasNoLaborables as $diasNoLaborables)
        <tr>
            <td>{!! $diasNoLaborables->f_reg !!}</td>
            <td>{!! $diasNoLaborables->responsable !!}</td>
            <td>{!! $diasNoLaborables->f_desde !!}</td>
            <td>{!! $diasNoLaborables->f_hasta !!}</td>
            <td>{!! $diasNoLaborables->descripcion !!}</td>
            <td>{{ $diasNoLaborables->estado==0?'Activo':'Inactivo' }}</td>
            <td>
                {!! Form::open(['route' => ['diasNoLaborables.destroy', $diasNoLaborables->dnlid], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <!-- <a href="{!! route('diasNoLaborables.show', [$diasNoLaborables->dnlid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> -->
                    <a href="{!! route('diasNoLaborables.edit', [$diasNoLaborables->dnlid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>