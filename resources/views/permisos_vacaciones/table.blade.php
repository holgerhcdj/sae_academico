<table class="table table-responsive" id="permisosVacaciones-table">
    <thead>
        <tr>
        <th>Nombre</th>
        <th>F.Desde</th>
        <th>F.Hasta</th>
        <th>H.Desde</th>
        <th>H.Hasta</th>
        <th>Tipo</th>
        <th>Estado</th>
        <th>Pagado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($permisosVacaciones as $permisosVacaciones)
        <tr>
            <td>{!! $permisosVacaciones->usu_apellidos.' '.$permisosVacaciones->name !!}</td>
            <td>{!! $permisosVacaciones->f_desde !!}</td>
            <td>{!! $permisosVacaciones->f_hasta !!}</td>
            <td>{!! $permisosVacaciones->h_desde !!}</td>
            <td>{!! $permisosVacaciones->h_hasta !!}</td>
            <td>
                {{ $permisosVacaciones->tipo==0?'Permiso':'Vacaciones'}}
            </td>
            <td>
                {{ $permisosVacaciones->estado==0?'Activo':'Inactivo'}}
            </td>
            <td>
                {{ $permisosVacaciones->pagado==0?'Si':'No'}}
            </td>
            <td>
                {!! Form::open(['route' => ['permisosVacaciones.destroy', $permisosVacaciones->pmid], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('permisosVacaciones.show', [$permisosVacaciones->pmid]) !!}" target='blank' class='btn btn-default btn-xs'><i class="fa fa-file-pdf-o text-danger"></i></a>
                    <a href="{!! route('permisosVacaciones.edit', [$permisosVacaciones->pmid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>