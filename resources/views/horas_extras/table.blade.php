<table class="table table-responsive" id="horasExtras-table">
    <thead>
        <tr>
            <th>Colaborador</th>
        <th>F_Registro</th>
        <th>Mes</th>
        <th>Horas</th>
        <th>Descripcion</th>
        <th>Estado</th>
        <th>Responsable</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($horasExtras as $horasExtras)
        <tr>
            <td>{!! $horasExtras->usu_apellidos.' '.$horasExtras->name !!}</td>
            <td>{!! $horasExtras->f_reg !!}</td>
            <td>
                {{$horasExtras->mes==1?'Enero':''}}
                {{$horasExtras->mes==2?'Febrero':''}}
                {{$horasExtras->mes==3?'Marzo':''}}
                {{$horasExtras->mes==4?'Abril':''}}
                {{$horasExtras->mes==5?'Mayo':''}}
                {{$horasExtras->mes==6?'Junio':''}}
                {{$horasExtras->mes==7?'Julio':''}}
                {{$horasExtras->mes==8?'Agosto':''}}
                {{$horasExtras->mes==9?'Septiembre':''}}
                {{$horasExtras->mes==10?'Octubre':''}}
                {{$horasExtras->mes==11?'Noviembre':''}}
                {{$horasExtras->mes==12?'Diciembre':''}}
            </td>
            <td>{!! $horasExtras->horas !!}</td>
            <td>{!! $horasExtras->descripcion !!}</td>
            <td>
                {!! $horasExtras->estado==0?'Activo':'Inactivo' !!}
            </td>
            <td>{!! $horasExtras->responsable !!}</td>
            <td>
                {!! Form::open(['route' => ['horasExtras.destroy', $horasExtras->heid], 'method' => 'delete']) !!}
                <div class='btn-group'>
<!--                     <a href="{!! route('horasExtras.show', [$horasExtras->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> -->
                    <a href="{!! route('horasExtras.edit', [$horasExtras->heid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>