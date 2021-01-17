@extends('layouts.app')

@section('content')
<?php
$e='0';
$c='0';
$m=0;
if(isset($_POST['jor_id'])){//Si exsite un metodo POST
    $e=$_POST['esp_id'];
    $c=$_POST['cur_id'];
    $m=$_POST['mes'];
}
?>

<script>
    $(function(){
        $("select[name=esp_id]").val('{{$e}}');
        $("select[name=cur_id]").val('{{$c}}');

    var fecha = new Date();
    //var mes = (fecha.getMonth()*1+6);
    var mes = $("#mes").val();
        np=0;
        tc=0;
        np=0;
        tc=($(".cnt").length*mes); //TOTAL GENERAL
        tp=0;
        $(".pagos").each(function(){
             if($(this).html().trim()!='-'){
                 tp++;
             }
        });
        np=tc-tp;
        t=tp*100/tc;
        if(t>100){
            t=100;
        }
        $("#prog").val(t);
        $("#txt_prog").text(t.toFixed(2)+"%");

    })

    function validar(){

        if($("#mes").val()=='0')
        {
            alert('Elija un mes');
            return false;        
        }else{
            return true;        

        }
    }

    $(document).on("click",".btn_acuerdo",function(){
        var url=window.location;
        var token=$("#_token").val();
        var mt_id=$(this).attr('data');
                    $.ajax({
                        url: url+'/ordenes',//CursosController@asg_dirgente
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {mt_id:mt_id},
                        beforeSend:function(){
                            //return false;
                        },
                        success:function(dt){
                            var x=0;
                            var rsp="";

                            $(dt).each(function(){

                                if(dt[x]['estado']==2){
                                    ac_si='selected';
                                    ac_no='';
                                }else{
                                    ac_si='';
                                    ac_no='selected';
                                }
                                rsp+="<tr><td>"+dt[x]['mes']+"</td><td>"+dt[x]['codigo']+"</td>"+
                                "<td><select class='cmb_acuerdo'><option "+ac_no+" value='0'>NO</option><option "+ac_si+" value='2'>SI</option></select></td>"+
                                "<td><input type='date' class='f_acuerdo' value='"+dt[x]['f_acuerdo']+"'  /></td>"+
                                "<td><input type='text' class='ac_no'  /></td>"+
                                "<td><i class='btn btn-primary btn-xs fa fa-floppy-o btn_save_acuerdo' data='"+dt[x]['id']+"' ></i></td>"+
                                "</tr>";
                                x++;

                            })
                            $("#tb_acuerdos").html(rsp);
                        }
                    })
    })
    $(document).on("click",".btn_save_acuerdo",function(){
        var url=window.location;
        var token=$("#_token").val();
        var id=$(this).attr('data');
        var ac=$(this).parent().parent().find(".cmb_acuerdo").val();
        var fac=$(this).parent().parent().find(".f_acuerdo").val();
        var ac_no=$(this).parent().parent().find(".ac_no").val();

        var obj=$(this).parent().parent();
        
                    $.ajax({
                        url: url+'/save_ordenes',//CursosController@asg_dirgente
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {id:id,ac:ac,fac:fac,ac_no:ac_no},
                        beforeSend:function(){
                            if(ac==2){
                                if(fac.length==0){
                                    alert('Fecha de acuerdo es obligatorio');
                                    return false;
                                }
                                // if(ac_no.length==0){
                                //     alert('No acuerdo es obligatorio');
                                //     return false;
                                // }
                            }
                            //return false;
                        },
                        success:function(dt){

                            dt==0?alert('Registro Correcto'):'';

                        }
                    })

    

    })    
</script>
<style>
    .pagos{
        background:#BCDBEF; 
    }
    #tbl_datos tr:hover{
       background:#BCDBEF !important;
       cursor:pointer; 
    }
</style>
<div class="modal fade" id="mdl_acuerdo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Acuerdos de pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
            <thead>
                <tr>
                    <td>Mes</td>
                    <td>Código</td>
                    <td>Acuerdo</td>
                    <td>Fecha</td>
                </tr>
            </thead>
            <tbody id="tb_acuerdos" >
                
            </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

    <section class="content-header">
        <h1 class="bg-primary text-center">Reporte de Pagos de Pensiones</h1>
        <br>
     <form action="pagoPensiones.index" method="POST" onsubmit="return validar()" >
            <input type="hidden" name="_token" id="_token" value="{{ csrf_token()}}">
        <table>
            <tr>
                <td>
                {!! Form::select('jor_id',$jor,null,['class'=>'form-control']) !!}    
                </td>
                <td>
                {!! Form::select('esp_id',$esp,null,['class'=>'form-control']) !!}    
                </td>
                <td>
                {!! Form::select('cur_id',$cur,null,['class'=>'form-control']) !!}
                </td>     
                <td>
                {!! Form::select('par_id',[
                    '0'=>'Todos',
                    'A'=>'A',
                    'B'=>'B',
                    'C'=>'C',
                    'D'=>'D',
                    'E'=>'E',
                    'F'=>'F',
                    'G'=>'G',
                    'H'=>'H',
                    'I'=>'I'],null,['class'=>'form-control']) !!}    
                </td>
                <td >
                {!! Form::select('mes',[
                    '0'=>'Elija Mes',
                    '2'=>'Septiembre',
                    '3'=>'Octubre',
                    '4'=>'Noviembre',
                    '5'=>'Diciembre',
                    '6'=>'Enero',
                    '7'=>'Febrero',
                    '8'=>'Marzo',
                    '9'=>'Abril',
                    '10'=>'Mayo',
                    '11'=>'Junio',
                    '12'=>'Julio',
                    '13'=>'Agosto',
                    ],null,['class'=>'form-control','id'=>'mes']) !!}    
                </td>
                <td>
                    <button class="btn btn-warning" value="search" type="submit" name="search" >
                        <i class="fa fa-search"></i>
                    </button>
                    <button  class="btn btn-primary" value="search_impr" type="submit" name="search_impr" >
                        <i class="fa fa-print"></i>
                    </button>
                    <button   class="btn btn-info" value="rep_gen" type="submit" name="rep_gen" >
                        <i class="fa fa-print">Rep.Gen</i>
                    </button>
                    <button  class="btn btn-success" value="rep_mgen" type="submit" name="rep_mgen" >
                        <i class="fa fa-file-excel-o"></i>
                    </button>
                </td>                
            </tr>
        </table>
     </form>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="bg-primary text-center" style="font-size:17px; ">
            @if(isset($dirigente[0]->usu_apellidos))
            Dirigente: {{$dirigente[0]->usu_apellidos.' '.$dirigente[0]->name}}
            @endif
            <progress max="100" value="" id="prog" style="margin-top:10px; "></progress>
            <b id="txt_prog"></b>
        </div>
        <div class="box box-primary">
            <div class="box-body">
                 <table class="table" id="tbl_datos">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Estudiante</th>
                                <th>Mat</th>
                                <th>Sep</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dic</th>
                                <th>Ene</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Abr</th>
                                <th>May</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Ago</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c=1;
                                $fa=date("m");
                                $Pag="<i class='fa fa-check text-success cls_chk'></i>";
                                $Apag="<i class='text-success cls_chk'>A</i>";
                           ?>

                            @foreach($pagoPensiones as $p)
                                    <?php
                                    $dt=explode("&",$p->est);

                                    // if($dt[2]==0){
                                    // }else{
                                    //     $Pag="<i class='fa fa-check text-danger cls_chk'></i>";
                                    // }


                                    ?>
                            <tr>
                                <td class="cnt">{{$c++}}</td>
                            <td>
                                <i class="btn btn-primary btn-xs fa fa-chevron-circle-right btn_acuerdo" data='{{$dt[1]}}' data-toggle="modal" data-target="#mdl_acuerdo"  ></i>
                                {{$dt[0]}}
                            </td>
                                <td class="pagos">{!!$Pag!!}</td>
                                <td class="<?php if($m>=2){ echo 'pagos'; }?>">{!!$p->s==0?'-':'';!!} {!!$p->s==1?$Pag:'';!!} {!!$p->s==2?$Apag:'';!!}</td>
                                <td class="<?php if($m>=3){ echo 'pagos'; }?>">{!!$p->o==0?'-':'';!!} {!!$p->o==1?$Pag:'';!!} {!!$p->o==2?$Apag:'';!!}</td>
                                <td class="<?php if($m>=4){ echo 'pagos'; }?>">{!!$p->n==0?'-':'';!!} {!!$p->n==1?$Pag:'';!!} {!!$p->n==2?$Apag:'';!!}</td>
                                <td class="<?php if($m>=5){ echo 'pagos'; }?>">{!!$p->d==0?'-':'';!!} {!!$p->d==1?$Pag:'';!!} {!!$p->d==2?$Apag:'';!!}</td>
                                <td class="<?php if($m>=6){ echo 'pagos'; }?>">{!!$p->e==0?'-':'';!!} {!!$p->e==1?$Pag:'';!!} {!!$p->e==2?$Apag:'';!!}</td>
                                <td class="<?php if($m>=7){ echo 'pagos'; }?>">{!!$p->f==0?'-':'';!!} {!!$p->f==1?$Pag:'';!!} {!!$p->f==2?$Apag:'';!!}</td>
                                <td class="<?php if($m>=8){ echo 'pagos'; }?>">{!!$p->mz==0?'-':'';!!} {!!$p->mz==1?$Pag:'';!!} {!!$p->mz==2?$Apag:'';!!}</td>
                                <td class="<?php if($m>=9){ echo 'pagos'; }?>">{!!$p->a==0?'-':'';!!} {!!$p->a==1?$Pag:'';!!} {!!$p->a==2?$Apag:'';!!}</td>
                                <td class="<?php if($m>=10){ echo 'pagos'; }?>">{!!$p->my==0?'-':'';!!} {!!$p->my==1?$Pag:'';!!} {!!$p->my==2?$Apag:'';!!}</td>
                                <td class="<?php if($m>=11){ echo 'pagos'; }?>">{!!$p->j==0?'-':'';!!} {!!$p->j==1?$Pag:'';!!} {!!$p->j==2?$Apag:'';!!}</td>
                                <td class="<?php if($m>=12){ echo 'pagos'; }?>">{!!$p->jl==0?'-':'';!!} {!!$p->jl==1?$Pag:'';!!} {!!$p->jl==2?$Apag:'';!!}</td>
                                <td class="<?php if($m>=13){ echo 'pagos'; }?>">{!!$p->ag==0?'-':'';!!} {!!$p->ag==1?$Pag:'';!!} {!!$p->ag==2?$Apag:'';!!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>   
            </div>
        </div>
    </div>
@endsection
