<table class="table table-responsive" id="materias-table">
    <thead>
        <tr>
            <th>Descripcion</th>
            <th>Asignar/Materia</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cursos as $curso)
        <tr>
            <td>{!! $curso->cur_descripcion !!}</td>
            <td>
                <form action="materias.show" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="cur_id" id="cur_id" value="{{$curso->id}}" >
                    <button class="btn btn-danger"><i class="glyphicon glyphicon-edit"></i></button>
                </form>
           
            </td>
        </tr>
        @endforeach
    </tbody>
</table>