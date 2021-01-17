<table class="table table-responsive" id="avances-table">
    <thead>
        <tr>
            <th>#</th>
            <th>F Inicio</th>
        <th>Descripcion</th>
        <th>Modulo</th>
        <th>Solicita</th>
        <th>Estado</th>
        <th>F_Fin</th>
        <th style="width:100px ">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $x=1?>
    @foreach($avances as $avances)
    <?php
        $nm=Auth::user()->name.' '.Auth::user()->usu_apellidos;
    ?>
        <tr>
            <td>{!! $x++ !!}</td>
            <td>{!! $avances->f_inicio !!}</td>
            <td>{!! $avances->descripcion !!}</td>
            <td>{!! $avances->obs !!}</td>
            <td>{!! $avances->responsable !!}</td>
            <td>
                @if($avances->estado==0)
                {!! 'Solicitado' !!}
                @elseif($avances->estado==1)
                {!! 'Aprobado' !!}
                @elseif($avances->estado==2)
                {!! 'Finalizado' !!}
                @endif
            </td>
            <td>
                @if($avances->estado==2)
                {!! $avances->f_fin !!}
                @else
                {!! '' !!}
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['avances.destroy', $avances->avcid], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    @if($avances->responsable==$nm)
                        <a href="{!! route('avances.edit', [$avances->avcid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                    @else                            
                        <a href="#" class='btn btn-default btn-xs' disabled><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                    @endif

                    @if($avances->responsable==$nm)
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    @else
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs','disabled','onclick' => "return confirm('Are you sure?')"]) !!}
                    @endif
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>