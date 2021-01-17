<table class="tbl" id="tbl_noc_bgu" border="1" >
    <tr>
        <th colspan="7" style="text-align:center " >Horario de Clases Nocturna</th>
    </tr>
    <tr>
        <th>Hora</th>
        <th>Lunes</th>
        <th>Martes</th>
        <th>Miercoles</th>
        <th>Jueves</th>
        <th>Viernes</th>
        <th>Sabado</th>
    </tr>

    @foreach($n_bgu as $l)
    <?php
    if ($l->lun == null) {
        $lun=["","","N/A",0,""];
    } else {
        $lun = explode('&', $l->lun);
        if($lun[0]=='LIBRE'){
            $lun=[$lun[0],"","",$lun[3],""];
        }
    }

    if ($l->mar == null) {
        $mar=["","","N/A",0,''];
    } else {
        $mar = explode('&', $l->mar);
        if($mar[0]=='LIBRE'){
            $mar=[$mar[0],"","",$mar[3],''];
        }
    }
    
    if ($l->mie == null) {
        $mie=["","","N/A",0,''];
    } else {
        $mie = explode('&', $l->mie);
        if($mie[0]=='LIBRE'){
            $mie=[$mie[0],"","",$mie[3],''];
        }
    }
    if ($l->jue == null) {
        $jue=["","","N/A",0,''];
    } else {
        $jue = explode('&', $l->jue);
        if($jue[0]=='LIBRE'){
            $jue=[$jue[0],"","",$jue[3],''];
        }
    }
    if ($l->vie == null) {
        $vie=["","","N/A",0,''];
    } else {
        $vie = explode('&', $l->vie);
        if($vie[0]=='LIBRE'){
            $vie=[$vie[0],"","",$vie[3],''];
        }
        
    }
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
            <small class="materia">{{$lun[0]." "}}</small><small class="curso">{{$lun[1]." ".$lun[2]." "}}
                @if($lun[4]==7){{' BGU'}}@elseif($lun[4]==8){{' BSX'}}@endif
            </small>
            @if($lun[3]!=0)
                {!! Form::open(['route' => ['asignaHorarios.destroy', $lun[3]], 'method' => 'delete']) !!}
                {!! Form::button('<i class="glyphicon glyphicon-remove" ></i>', ['type' => 'submit', 'class' => 'btn btn-xs', 'onclick' => "return confirm('Esta Seguro de Eliminar Este Item? ?')"]) !!}
                {!! Form::close() !!}
            @endif
        </td>
        <td>
            <small class="materia">{{$mar[0]." "}}</small><small class="curso">{{$mar[1]." ".$mar[2]}}
                @if($mar[4]==7){{' BGU'}}@elseif($mar[4]==8){{' BSX'}}@endif
            </small>
            @if($mar[3]!=0)
                {!! Form::open(['route' => ['asignaHorarios.destroy', $lun[3]], 'method' => 'delete']) !!}
                {!! Form::button('<i class="glyphicon glyphicon-remove" ></i>', ['type' => 'submit', 'class' => 'btn btn-xs', 'onclick' => "return confirm('Esta Seguro de Eliminar Este Item? ?')"]) !!}
                {!! Form::close() !!}
            @endif
        </td>
        <td>
            <small class="materia">{{$mie[0]." "}}</small><small class="curso">{{$mie[1]." ".$mie[2]}}
                @if($mie[4]==7){{' BGU'}}@elseif($mie[4]==8){{' BSX'}}@endif
            </small>
            @if($mie[3]!=0)
                {!! Form::open(['route' => ['asignaHorarios.destroy', $mie[3]], 'method' => 'delete']) !!}
                {!! Form::button('<i class="glyphicon glyphicon-remove" ></i>', ['type' => 'submit', 'class' => 'btn btn-xs', 'onclick' => "return confirm('Esta Seguro de Eliminar Este Item? ?')"]) !!}
                {!! Form::close() !!}
            @endif
        </td>
        <td>
            <small class="materia">{{$jue[0]." "}}</small><small class="curso">{{$jue[1]." ".$jue[2]}}
                @if($jue[4]==7){{' BGU'}}@elseif($jue[4]==8){{' BSX'}}@endif
            </small>
            @if($jue[3]!=0)
                {!! Form::open(['route' => ['asignaHorarios.destroy', $jue[3]], 'method' => 'delete']) !!}
                {!! Form::button('<i class="glyphicon glyphicon-remove" ></i>', ['type' => 'submit', 'class' => 'btn btn-xs', 'onclick' => "return confirm('Esta Seguro de Eliminar Este Item? ?')"]) !!}
                {!! Form::close() !!}
            @endif
        </td>
        <td>
            <small class="materia">{{$vie[0]." "}}</small><small class="curso">{{$vie[1]." ".$vie[2]}}
                @if($vie[4]==7){{' BGU'}}@elseif($vie[4]==8){{' BSX'}}@endif
            </small>
            @if($vie[3]!=0)
                {!! Form::open(['route' => ['asignaHorarios.destroy', $vie[3]], 'method' => 'delete']) !!}
                {!! Form::button('<i class="glyphicon glyphicon-remove" ></i>', ['type' => 'submit', 'class' => 'btn btn-xs', 'onclick' => "return confirm('Esta Seguro de Eliminar Este Item? ?')"]) !!}
                {!! Form::close() !!}
            @endif
        </td>
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

