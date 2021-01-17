@extends('layouts.app')

@section('content')
    <script>

$(function(){
    var x=0;
    var token=$("input[name=_token]").val();
    $(".prg_id").each(function(){
        var obj=$(this); 
    var prg_id=$(this).attr('id'); 
//if(x==0){
    $.ajax({
        url: 'busca_registro_encuesta',
        headers:{'X-CSRF-TOKEN':token},
        type: 'POST',
        dataType: 'json',
        data: {prg_id:prg_id},
        beforeSend:function(){
    //alert(prg_id);
        },
        success:function(dt){
            if(dt.length>0){
                var r=$(obj).parent();
                var resp=$(r).find("input[value='"+dt[0]['respuesta']+"']");
                $(resp).prop('checked',true);
                // if(dt[0]['reg_estado']==1){
                //     // $("a").each(function(){
                //     //     $(this).attr('disabled',true);
                //     // });
                //     $(r).find("input").each(function(){
                //         $(this).attr('disabled',true);
                //     });
                // }
            }
            //alert(resp.val());

        }
    });
//}


        x++;
    });



})


$(document).on("click",".rd_preg",function(){
var obj=$(this);
    var token=$("input[name=_token]").val();
    var prg_id=$(this).attr('data'); 
    var reg_id=$(this).attr('reg_id'); 
    var respuesta=$(this).val(); 
   $.ajax({
    url: 'registra_encuesta',
    headers:{'X-CSRF-TOKEN':token},
    type: 'POST',
    dataType: 'json',
    data: {prg_id:prg_id,respuesta:respuesta,reg_id:reg_id},
    beforeSend:function(){
        //return false;
      //alert(mat_id);
    },
    success:function(dt){
      if(dt>0){
        $(obj).attr('reg_id',dt);
      }else{
        alert('Error');
    }
    }
  })
})        
    </script>
    <style>
            .rotate_tx{
                writing-mode: vertical-lr;
                transform: rotate(180deg);
                 padding: 5px 0px 5px 0px;/*top right boottom left*/
                 font-size:11px; 
                 font-size:15px; 
            }   
            .table tr:hover{
                background:#B2EDFA;
                cursor:pointer;  
            }     
    </style>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    {{csrf_field()}}
<table class="table">
    <tr>
        <th colspan="7" class="text-center" style="font-size:20px; ">{{$encabezado->enc_descripcion}}</th>
    </tr>
    <tr>
        <td colspan="7"><span style="font-weight:bolder; " >Objetivo: </span>{{$encabezado->enc_objetivo}}</td>
    </tr>
    <tr>
        <th style="text-align:center;vertical-align:middle;" class="bg-info">#</th>
        <th style="text-align:center;vertical-align:middle;" class="bg-info">Pregunta</th>
        <th class="bg-info"><span class="rotate_tx">Siempre</span></th>
        <th class="bg-info"><span class="rotate_tx">Casi Siempre</span></th>
        <th class="bg-info"><span class="rotate_tx">Ocacionalmente</span></th>
        <th class="bg-info"><span class="rotate_tx">A veces</span></th>
        <th class="bg-info"><span class="rotate_tx">Nunca</span></th>
    </tr>
    <tbody>
<?php $x=0;?>
        @foreach($preguntas as $p )
        <?php $x++;?>
        <tr>
            <td class="prg_id" id="{{$p->prg_id}}">{{$loop->iteration}}</td>
            <td style="font-size:20px; ">{{$p->prg_pregunta}}</td>
            <td>
                <input type="radio" class="rd_preg" data="{{$p->prg_id}}" value="SIEMPRE" name="{{'rd_enc'.$x}}">
            </td>
            <td>
                <input type="radio" class="rd_preg" data="{{$p->prg_id}}" value="CASI SIEMPRE" name="{{'rd_enc'.$x}}">
            </td>
            <td>
                <input type="radio" class="rd_preg" data="{{$p->prg_id}}" value="OCACIONALMENTE" name="{{'rd_enc'.$x}}">
            </td>
            <td>
                <input type="radio" class="rd_preg" data="{{$p->prg_id}}" value="A VECES" name="{{'rd_enc'.$x}}">
            </td>
            <td>
                <input type="radio" class="rd_preg" data="{{$p->prg_id}}" value="NUNCA" name="{{'rd_enc'.$x}}">
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<form action="finalizar_encuesta" method="POST" >
    {{csrf_field()}}
    <input type="hidden" id="enc_id" name="enc_id" value="{{$encabezado->enc_id}}">
    <button class="btn btn-info pull-right" id="btn_finalizar"><i class="fa fa-clock-o "></i>Finalizar Encuesta</button>
</form>

                </div>
            </div>
        </div>
    </div>
@endsection
