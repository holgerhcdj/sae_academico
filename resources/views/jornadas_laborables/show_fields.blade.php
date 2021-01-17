<?php
$dlu=false;
$dma=false;
$dmi=false;
$dju=false;
$dvi=false;
$dsa=false;
$ddo=false;   
$hd='00:00';
$hh='00:00';
$almd='00:00';
$almh='00:00';

 if(isset($jornadasLaborables)){
    $jornadasLaborables->jrl_lun==1?$dlu=true:'';
    $jornadasLaborables->jrl_mar==1?$dma=true:'';
    $jornadasLaborables->jrl_mie==1?$dmi=true:'';
    $jornadasLaborables->jrl_jue==1?$dju=true:'';
    $jornadasLaborables->jrl_vie==1?$dvi=true:'';
    $jornadasLaborables->jrl_sab==1?$dsa=true:'';

    $hd=$jornadasLaborables->jrl_desde;
    $hh=$jornadasLaborables->jrl_hasta;

 }
?>
<script type="text/javascript">
$(document).ready(function() {
  $(".sel-status").select2();
   habilita($("#asg_jrl_alm"));
});
$(document).on("click","#asg_jrl_alm",function(){
    habilita($(this));
})
function habilita(obj){

     if($(obj).prop('checked')==false){
        $(".asg_jrl_alm_desde").attr('readOnly',true);
        $(".asg_jrl_alm_hasta").attr('readOnly',true);
        $(".asg_jrl_alm_desde").val('00:00');
        $(".asg_jrl_alm_hasta").val('00:00');
     }else{
        $(".asg_jrl_alm_desde").attr('readOnly',false);
        $(".asg_jrl_alm_hasta").attr('readOnly',false);
    }

}


</script>
<div class="form-group col-sm-12">
    {!! Form::open(['route' => 'asgJornadasLaborables.store']) !!}
    {!!Form::hidden('jrl_id',$jornadasLaborables->jrl_id) !!}
    <table class="table" border="1">
        <tr>
            <th colspan="2" class="text-center bg-primary"></th>
            <th colspan="2" class="text-center bg-primary">Jornada</th>
            <th colspan="2" class="text-center bg-primary">
            Almuerzo
            {!! Form::checkbox('asg_jrl_alm',null,true,['id'=>'asg_jrl_alm']) !!}
            </th>
            <th colspan="7" class="text-center bg-primary">Días Laborables</th>
            <th class="text-center bg-primary"></th>
        </tr>
        <tr>
            <th></th>
            <th>Persona</th>
            <th>Entrada:</th>
            <th>Salida:</th>
            <th>Desde:</th>
            <th>Hasta:</th>
            <th class="text-center" style="width:80px ">Lun</th>
            <th class="text-center" style="width:80px ">Mar</th>
            <th class="text-center" style="width:80px ">Mie</th>
            <th class="text-center" style="width:80px ">Jue</th>
            <th class="text-center" style="width:80px ">Vie</th>
            <th class="text-center" style="width:80px ">Sab</th>
            <th class="text-center" style="width:80px ">Dom</th>
        </tr>
        <tr class="tr_clone">
            <td></td>
            <td>
                {!! Form::select('usuarios', $usuarios,null,['class' => 'form-control usuarios sel-status','style'=>'width:350px']) !!}
            </td>
            <td>
                {!! Form::time('asg_jrl_desde',$hd, ['class' => 'form-control asg_jrl_desde','style'=>'width:120px']) !!}
            </td>
            <td>
                {!! Form::time('asg_jrl_hasta',$hh, ['class' => 'form-control asg_jrl_hasta','style'=>'width:120px']) !!}
            </td>
            <td>
                {!! Form::time('asg_jrl_alm_desde',$almd, ['class' => 'form-control asg_jrl_alm_desde','style'=>'width:120px']) !!}
            </td>
            <td>
                {!! Form::time('asg_jrl_alm_hasta',$almh, ['class' => 'form-control asg_jrl_alm_hasta','style'=>'width:120px']) !!}
            </td>
            <td class="text-center">{!! Form::checkbox('asg_jrl_lun',null,$dlu) !!}</td>
            <td class="text-center">{!! Form::checkbox('asg_jrl_mar',null,$dma) !!}</td>
            <td class="text-center">{!! Form::checkbox('asg_jrl_mie',null,$dmi) !!}</td>
            <td class="text-center">{!! Form::checkbox('asg_jrl_jue',null,$dju) !!}</td>
            <td class="text-center">{!! Form::checkbox('asg_jrl_vie',null,$dvi) !!}</td>
            <td class="text-center">{!! Form::checkbox('asg_jrl_sab',null,$dsa) !!}</td>
            <td class="text-center">{!! Form::checkbox('asg_jrl_dom',null,$ddo) !!}</td>
            <td>
                {!! Form::submit('+', ['class' => 'btn btn-primary']) !!}
            </td>
        </tr>  
         <?php $c=1;?>
        @foreach($asg_jor as $a)
        <tr>
            <td>{{$c++}}</td>
            <td>{{$a->usu_apellidos.' '.$a->name}}</td>
            <td>{{$a->asg_jrl_desde}}</td>
            <td>{{$a->asg_jrl_hasta}}</td>
            <td>{{$a->asg_jrl_alm_desde}}</td>
            <td>{{$a->asg_jrl_alm_hasta}}</td>
            <td class="text-center">@if($a->asg_jrl_lun==1){{'X'}}@else{{'-'}}@endif</td>
            <td class="text-center">@if($a->asg_jrl_mar==1){{'X'}}@else{{'-'}}@endif</td>
            <td class="text-center">@if($a->asg_jrl_mie==1){{'X'}}@else{{'-'}}@endif</td>
            <td class="text-center">@if($a->asg_jrl_jue==1){{'X'}}@else{{'-'}}@endif</td>
            <td class="text-center">@if($a->asg_jrl_vie==1){{'X'}}@else{{'-'}}@endif</td>
            <td class="text-center">@if($a->asg_jrl_sab==1){{'X'}}@else{{'-'}}@endif</td>
            <td class="text-center">@if($a->asg_jrl_dom==1){{'X'}}@else{{'-'}}@endif</td>
            <td class="text-center">

                <form action="elimina_asignacion_jornada" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="asg_jrl_id" value="{{$a->asg_jrl_id}}" >
                    <div class='btn-group'>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                </form>

            </td>

        </tr>
        @endforeach
    </table>
    {!! Form::close() !!}

</div>


