<table class="table table-responsive" id="sugerencias-table">
    <thead>
        <tr>
        <th>Solicitado</th>
        <th>Asunto</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($sugerencias as $sugerencias)
        <tr>
            <td>{!! $sugerencias->name .' '.$sugerencias->usu_apellidos !!}</td>
            <td>{!! $sugerencias->asunto !!}</td>
            <td>{!! $sugerencias->f_registro !!}</td>
            <td>
                @if($sugerencias->estado==0)
                {{'Solicitado'}}
                @else
                {{'Revisado'}}
                @endif
                
            </td>
            <td>
                {!! Form::open(['route' => ['sugerencias.destroy', $sugerencias->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('sugerencias.show', [$sugerencias->id]) !!}" title='Responder' class='btn btn-default btn-xs'><i class="fa fa-reply text-warning"></i></a>
                    <a href="{!! route('sugerencias.edit', [$sugerencias->id]) !!}" title='Editar' class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['title'=>'Eliminar','type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Desea Eliminar?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>