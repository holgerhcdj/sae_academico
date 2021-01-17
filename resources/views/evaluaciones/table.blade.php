<div class="table-responsive">
<table class="table" id="evaluaciones-table">
    <thead>
        <tr>
        <th>No</th>
        <th>Fecha Creación</th>
        <th>Descripcion</th>
        <th>Preguntas</th>
        <th>Estado</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=1?>
    @foreach($evaluaciones as $evaluaciones)
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $evaluaciones->evl_freg !!}</td>
            <td>{!! $evaluaciones->evl_descripcion !!}</td>
            <td>0</td>
            <td>
                @if($evaluaciones->evl_estado==0)
                {{'Activo'}}
                @else
                {{'InActivo'}}
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['evaluaciones.destroy', $evaluaciones->evl_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('evaluaciones.show', [$evaluaciones->evl_id]) !!}" class='btn btn-default btn-xs'><i class="fa fa-list"></i></a>
                    <a href="{!! route('evaluaciones.edit', [$evaluaciones->evl_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</div>