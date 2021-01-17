<table class="table table-responsive" id="parciales-table">
    <thead>
        <tr>
        <th>Descripcion</th>
        <th>F_inicio</th>
        <th>F_fin</th>
        <th>Matutina</th>
        <th>Semipresencial</th>
        <th>Bloqueado estudiantes</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($parciales as $parciales)
        <tr>
            <td>{!! $parciales->par_descripcion !!}</td>
            <td>{!! $parciales->par_finicio !!}</td>
            <td>{!! $parciales->par_ffin !!}</td>
            <td>@if($parciales->par_act_m==1) {{'ABIERTO'}} @else {{'CERRADO'}} @endif</td>
            <td>@if($parciales->par_act_s==1) {{'ABIERTO'}} @else {{'CERRADO'}} @endif</td>
            
            <td>@if($parciales->par_estado==1) {{'NO'}} @else {{'SI'}} @endif</td>

            <td>
                {!! Form::open(['route' => ['parciales.destroy', $parciales->par_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('parciales.show', [$parciales->par_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('parciales.edit', [$parciales->par_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>