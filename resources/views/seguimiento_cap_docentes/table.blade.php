<table class="table table-responsive table-hover" id="seguimientoCapDocentes-table">
    <thead>
        <tr>
        <th>#</th> 
        <th>Docente</th>
        <th>Ficha</th>
        <th colspan="3">Accion</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    $x=1;
    ?>
    @foreach($seguimientoCapDocentes as $seguimientoCapDocentes)
    <?php 
    if(empty($seguimientoCapDocentes->segid)){
        $segid='0&'.$seguimientoCapDocentes->docente;
    }else{
        $segid=$seguimientoCapDocentes->segid.'&'.$seguimientoCapDocentes->docente;
    }
    ?>
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $seguimientoCapDocentes->usu_apellidos.' '.$seguimientoCapDocentes->name !!}</td>
            <td>
                @if($seguimientoCapDocentes->segid>0)
                {{'SI'}}
                @else
                {{'-'}}
                @endif
            </td>
            <td>
                <div class='btn-group'>
                    <a href="{!! route('segSemanalDocentes.show', [$seguimientoCapDocentes->docente]) !!}" title="Seguimientos a docentes" class='btn btn-default btn-xs'><i class="fa fa-outdent text-primary"></i></a>
                    <a href="{!! route('seguimientoCapDocentes.edit', [$segid]) !!}" class='btn btn-default btn-xs'><i class="fa fa-file-o text-danger"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>