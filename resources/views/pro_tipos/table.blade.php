<table class="table table-responsive" id="proTipos-table">
    <thead>
        <tr>
        <th>#</th>
        <th>Descripcion</th>
        <th>Observacion</th>
        <th>Estado</th>
            <th colspan="3">Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php 
        $x=1;
     ?>
    @foreach($proTipos as $proTipo)
   
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $proTipo->descripcion !!}</td>
            <td>{!! $proTipo->observacion !!}</td>
            <td>@if($proTipo->estado==0)
                {{'Activo'}}
                @elseif($proTipo->estado==1)
                {{'Inactivo'}}   
                @endif</td>
            <td>
                {!! Form::open(['route' => ['proTipos.destroy', $proTipo->tpid], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('proTipos.show', [$proTipo->tpid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('proTipos.edit', [$proTipo->tpid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('¿Estás Seguro de Elimiar este campo?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>