<table class="table table-responsive" id="novedadesInspeccions-table">
    <thead>
            <tr id="tbl_head">
                <th colspan="7" style="text-align:center;font-size:20px  " >Novedades de Inspección</th>
            </tr>
        <tr>
            <th>#</th>
        <th>Estudiante</th>
        <th>Responsable</th>
        <th>Fecha</th>
        <th>Novedad</th>
        <th>Reportada A</th>
        <th>Estado</th>
            <th colspan="3">Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=1; ?>
    @foreach($novedadesInspeccions as $novedadesInspeccion)
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $novedadesInspeccion->est_apellidos.' '.$novedadesInspeccion->est_nombres !!}</td>
            <td>{!! $novedadesInspeccion->usu_apellidos.' '.$novedadesInspeccion->name !!}</td>
            <td>{!! $novedadesInspeccion->fecha !!}</td>
            <td>{!! $novedadesInspeccion->novedad !!}</td>
            <td>{!! $novedadesInspeccion->reportada_a !!}</td>
            <td>
                @if($novedadesInspeccion->estado==0)
                {{"Activo"}}
                @else
                {{"Inactivo"}}
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['novedadesInspeccions.destroy', $novedadesInspeccion->inspid], 'method' => 'delete','class'=>'frm_acciones']) !!}
                <div class='btn-group'>
                    <a href="{!! route('novedadesInspeccions.show', [$novedadesInspeccion->inspid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('novedadesInspeccions.edit', [$novedadesInspeccion->inspid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Está seguro?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>