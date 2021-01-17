<table class="table table-responsive" id="erpDivisions-table">
    <thead>
        <tr>
        <th>#</th>
        <th>Codigo</th>
        <th>Descripcion</th>
        <th>Gerencia</th>
        <th>Siglas</th>
        <th>Estado</th>
        <th colspan="3">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $x=1;
         ?>
    @foreach($erpDivisions as $erpDivision)
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $erpDivision->div_codigo !!}</td>
            <td>{!! $erpDivision->div_descripcion !!}</td>
            <td>{!! $erpDivision->ger_descripcion !!}</td>
            <td>{!! $erpDivision->div_siglas !!}</td>
            <td>@if($erpDivision->estado==0)
                {{'Activo'}}
                @elseif($erpDivision->estado==1)
                {{'Inactivo'}}   
                @endif</td>
            <td>
                {!! Form::open(['route' => ['erpDivisions.destroy', $erpDivision->div_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('erpDivisions.edit', [$erpDivision->div_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>