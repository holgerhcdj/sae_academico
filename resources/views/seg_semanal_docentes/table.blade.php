<style>
    #segSemanalDocentes tr td{
        border:  solid 1px #ccc;
    }
</style>
<table class="table table-responsive" id="segSemanalDocentes">
    <thead class="bg-primary">
        <tr>
            <th colspan="10" class="text-center" >SEGUIMIENTOS REALIZADOS</th>
        </tr>
        <tr>
        <!-- <th>Cap Id</th> -->
        <th>Docente</th>
        <th>Fecha</th>
        <th>Nivel</th>
        <th>Textos Biblicos</th>
        <th>Respuesta</th>
        <th>Nivel Final</th>
        <th>Estado</th>
            <th colspan="3">Accion</th>
        </tr>
    </thead>
    <tbody>
    @foreach($segSemanalDocentes as $segSemanalDocente)
        <tr>
            <!-- <td>{!! $segSemanalDocente->cap_id !!}</td> -->
            <td>{{$user[0]->usu_apellidos.' '.$user[0]->name}}</td>
            <td>{!! $segSemanalDocente->fecha !!}</td>
            <td>{!! $segSemanalDocente->nivel !!}</td>
            <td>{!! $segSemanalDocente->textos_biblicos !!}</td>
            <td>{!! $segSemanalDocente->respuesta !!}</td>
            <td>{!! $segSemanalDocente->nivel_final !!}</td>
            <td>@if($segSemanalDocente->estado==0)
                    {{"Activo"}}
                @else
                    {{"Inactivo"}}
                @endif</td>
            <td>
                {!! Form::open(['route' => ['segSemanalDocentes.destroy', $segSemanalDocente->sgmid], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Desea eliminar este registro?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>