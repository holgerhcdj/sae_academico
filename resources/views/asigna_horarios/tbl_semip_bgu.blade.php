<table class="tbl" id="tbl_sp_bgu" border="1" >
    <tr>
        <th colspan="7" style="text-align:center " >Horario de Clases Semi-Presencial</th>
    </tr>
    <tr>
        <th>Hora</th>
        <th>Sabado</th>
    </tr>

    @foreach($sp_bgu as $l)
    <?php
    if ($l->sab == null) {
        $sab=["","","N/A",0,''];
    } else {
        $sab = explode('&', $l->sab);
        if($sab[0]=='LIBRE'){
            $sab=[$sab[0],"","",$sab[3],''];
        }
    }
    
    ?>
    <tr>
        <td>{{$l->horas}}</td>
        <td>
            <small class="materia">{{$sab[0]." "}}</small><small class="curso">{{$sab[1]." ".$sab[2]}}
                @if($sab[4]==7){{' BGU'}}@elseif($sab[4]==8){{' BSX'}}@endif
            </small>
            @if($sab[3]!=0)
                {!! Form::open(['route' => ['asignaHorarios.destroy', $sab[3]], 'method' => 'delete']) !!}
                {!! Form::button('<i class="glyphicon glyphicon-remove" ></i>', ['type' => 'submit', 'class' => 'btn btn-xs', 'onclick' => "return confirm('Esta Seguro de Eliminar Este Item? ?')"]) !!}
                {!! Form::close() !!}
            @endif
        </td>

    </tr>
    @endforeach
</table>

