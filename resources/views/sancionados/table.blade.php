<table class="table table-responsive" id="sancionados-table">
    <thead>
        <tr>
        <th>Matricula</th>
        <th>Cedula</th>
        <th>Estudiante</th>
        <th>Jornada</th>
        <th>Especialidad</th>
        <th>Curso cultural</th>
        <th>Curso técnico</th>
        <th>Estado</th>
        <th colspan="3">...</th>
        </tr>
    </thead>
    <tbody>
    @foreach($sancionados as $sancionados)
        <tr>
            <td>{!! $sancionados->mat_id !!}</td>
            <td>{!! $sancionados->est_cedula !!}</td>
            <td>{!! $sancionados->est_apellidos.' '.$sancionados->est_nombres !!}</td>
            <td>{!! $sancionados->jor_descripcion !!}</td>
            <td>{!! $sancionados->esp_descripcion !!}</td>
            <td>{!! $sancionados->cur_descripcion.' '.$sancionados->mat_paralelo !!}</td>
            <td>{!! $sancionados->cur_descripcion.' '.$sancionados->mat_paralelot !!}</td>
            <td>
                @if($sancionados->mat_estado==0)
                {!! 'Inscrito' !!}
                @elseif($sancionados->mat_estado==1)
                {!! 'Matriculado' !!}
                @elseif($sancionados->mat_estado==2)
                {!! 'Retirado' !!}
                @endif
            </td>
            <td>
                <a href="{!! route('sancionados.show', [$sancionados->mat_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-list text-primary"> Sanciones</i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>