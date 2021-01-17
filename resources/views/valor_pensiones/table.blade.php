<table class="table table-responsive" id="valorPensiones-table">
    <thead>
        <tr>
        <th>Jornada</th>
        <th>Descripcion</th>
        <th>Valor</th>
        <th>Responsable</th>
        <th>Estado</th>
        <th>Observacion</th>        
        <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($valorPensiones as $valorPensiones)
        <tr>
            <td>{!! $valorPensiones->jor_descripcion !!}</td>
            <td>{!! $valorPensiones->descripcion !!}</td>
            <td>{!! $valorPensiones->valor.'$' !!}</td>
            <td>{!! $valorPensiones->responsable !!}</td>
            <td>
                @if($valorPensiones->estado==0)
                {{'Activo'}}
                @else
                {{'InActivo'}}
                @endif
                
            </td>
            <td>{!! $valorPensiones->observacion !!}</td>            
            <td>
                {!! Form::open(['route' => ['valorPensiones.destroy', $valorPensiones->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('valorPensiones.edit', [$valorPensiones->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>