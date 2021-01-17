<table class="table table-responsive" id="rubros-table">
    <thead class="bg-info">
        <tr>
        <th></th>
        <th>Numero</th>
        <th>Descripcion</th>
        <th>Siglas</th>
        <th>Valor</th>
        <th>Fecha Reg</th>
        <th>Estado</th>
        <th>...</th>
        <th>Recaudado</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=0;?>
    @foreach($rubros as $rubros)
    <?php
    if($rubros->rub_estado==0){
        $x++;
    }
    ?>
    <tr>
            <td>{{$x}}</td>
            <td>{!! $rubros->rub_no !!}</td>
            <td>{!! $rubros->rub_descripcion !!}</td>
            <td>{!! $rubros->rub_siglas !!}</td>
            <td>{!! $rubros->rub_valor."$" !!}</td>
            <td hidden="">
                @if($rubros->rub_grupo==0)
                {!! 'Estudiantes' !!}
                @elseif($rubros->rub_grupo==1)
                {!! 'Otros' !!}
                @endif
            </td>
            <td>{!! $rubros->rub_fecha_reg !!}</td>
            <td hidden="">{!! $rubros->rub_fecha_max !!}</td>
            <td>
                @if($rubros->rub_estado==0)
                {!! 'Activo' !!}
                @else($rubros->rub_grupo==1)
                {!! 'Finalizado' !!}
                @endif
            </td>
            <td class="text-left">
                @if($rubros->rub_estado==0)
                {{''}}
                @else
                {{$rubros->rub_obs}}
                @endif
            </td>
            <td class="text-center">{{$rubros->sum}}$</td>
            <td>
                {!! Form::open(['route' => ['rubros.destroy', $rubros->rub_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                <a href="{!! route('pagoRubros.index',['rub_id'=>$rubros->rub_id]) !!}" title="Reporte de Pagos" class='btn btn-default btn-xs'><i class="fa fa-list text-success" aria-hidden="true"></i></a>                                    
                <a href="{!! route('rubros.show', [$rubros->rub_id]) !!}" title="Recaudacion" class='btn btn-default btn-xs'><i class="fa fa-money text-success" aria-hidden="true"></i></a>
                <a href="{!! route('pagoRubros.show', [$rubros->rub_id]) !!}" target="_blank" title="Estadística" class='btn btn-default btn-xs'><i class="fa fa-file text-success" aria-hidden="true"></i></a>
                    @if($permisos['edit']==1)          
                    <a href="{!! route('rubros.edit', [$rubros->rub_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                    @endif          

                    @if($permisos['del']==1)          
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    @endif                    
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>