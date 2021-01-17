<table class="table table-responsive" id="cursos-table">
    <thead>
        <th>Descripcion</th>
        <th>Observaciones</th>
    </thead>
    <tbody>
    @foreach($cursos as $cursos)
        <tr>
            <td>{!! $cursos->cur_descripcion !!}</td>
            <td>{!! $cursos->cur_obs !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>