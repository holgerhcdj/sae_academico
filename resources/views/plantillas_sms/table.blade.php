<table class="table table-responsive" id="plantillasSms-table">
    <thead>
        <tr>
            <th>Id</th>
        <th>Descripcion</th>
        <th>Var1</th>
        <th>Var2</th>
        <th>Var3</th>
        <th>Var4</th>
        <th>Var5</th>
        <th>Estado</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($plantillasSms as $plantillasSms)
        <tr>
            <td>{!! $plantillasSms->pln_id !!}</td>
            <td>{!! $plantillasSms->pln_descripcion !!}</td>
            <td>{!! $plantillasSms->pln_var1 !!}</td>
            <td>{!! $plantillasSms->pln_var2 !!}</td>
            <td>{!! $plantillasSms->pln_var3 !!}</td>
            <td>{!! $plantillasSms->pln_var4 !!}</td>
            <td>{!! $plantillasSms->pln_var5 !!}</td>
            <td>
                @if($plantillasSms->pln_estado==0)
                {{'Activo'}}
                @else
                {{'Inactivo'}}
                @endif
            </td>
            <td>
                @if(Auth::user()->id==1)
                {!! Form::open(['route' => ['plantillasSms.destroy', $plantillasSms->pln_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('plantillasSms.edit', [$plantillasSms->pln_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>