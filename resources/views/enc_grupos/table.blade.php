<table class="table table-responsive" id="encGrupos-table">
    <thead>
        <tr>
            <th>Grp Descripcion</th>
        <th>Grp Valoracion</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $t=0;?>
    @foreach($encGrupos as $encGrupos)
    <?php $t+=$encGrupos->grp_valoracion ?>
        <tr>
            <td>{!! $encGrupos->grp_descripcion !!}</td>
            <td class="text-center">{!! $encGrupos->grp_valoracion.'%' !!}</td>
            <td>
                {!! Form::open(['route' => ['encGrupos.destroy', $encGrupos->grp_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('encGrupos.show', [$encGrupos->grp_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('encGrupos.edit', [$encGrupos->grp_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    <tr>
        <td col span="2" class="text-right">{{number_format($t).'%'}}</td>
    </tr>
    </tbody>
</table>