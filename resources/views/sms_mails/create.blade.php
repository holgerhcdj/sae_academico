@extends('layouts.app')

@section('content')
<?php
$dep=Auth::user()->usu_perfil;
if(isset($_POST['btn_buscar'])){
    $espid=$_POST['esp_id'];
}else{
    $espid=0;
}
?>
<script src="{{asset('ckeditor/ckeditor.js')}}"></script>
<script>
    $(function(){
        var dep='<?php echo $dep?>';
        $("select[name=mtr_id]").val(10);
        $("select[name=cur_id]").val(0);
        if(dep==6){// si es inspector
            $("select[name=tp_asis]").val(0);
            $("select[name=esp_id]").val('<?php echo $espid?>');
            $("select[name=mtr_id]").val(3);
            $("#mtr_id").hide();
            $("#mtr_id_t").hide();
        }else{
            $("select[name=tp_asis]").val(1);
            $("select[name=esp_id]").val('<?php echo $espid?>');
            $("#mtr_id").show();
            $("#mtr_id_t").show();
        }
        $("#contador").val(0);

         CKEDITOR.config.height=300;
         CKEDITOR.config.width='auto';
         CKEDITOR.replace('sms_mensaje2');

        $(".est_combo").select2();
    })    
    function validar(){
        var op=$("#opcion").val();
        if(op==''){
            alert('Debe elegir una opcion');
            return false;
        }else{
            if(op==2 || op==0){
                var tx=$("#txt_plantilla").text();
                $("#sms_mensaje").val(tx);
            }

        }
    }
    $(document).on("click",".btn_add_estudiante",function(){
        $("#contador").val(parseInt($("#contador").val())+1);
        var ct=$("#contador").val();
        var est="<td colspan='5'><input type='hidden' name='est"+ct+"' value='"+$( "select[name=est_id]" ).val()+"' >"+$( "select[name=est_id] option:selected" ).text()+"</td>";        
        var btn="<td><i class='btn btn-danger btn-xs btn_del_par' >x</i></td>";
        var tp="<td><input type='hidden' value='0' name='tp"+ct+"' >Individual</td>";
        var parametros="<tr class='row_par' >"+tp+est+btn+"</tr>";
        $("#cont_parametros").append(parametros);

    })
    $(document).on("click",".btn_add_parametros",function(){

        var aux_anl=$( "input[name=anl_id]" ).val();
        if($('select[name=esp_id]').val()==7)
        {
            aux_anl=$( "select[name=per_id]" ).val();
        }

        $("#contador").val(parseInt($("#contador").val())+1);
        var ct=$("#contador").val();
        var anl="<input type='hidden' name='anl"+ct+"' value='"+aux_anl+"' >";
        var jor="<td><input type='hidden' name='jr"+ct+"' value='"+$( "select[name=jor_id]" ).val()+"' >"+$( "select[name=jor_id] option:selected" ).text()+"</td>";
        var esp="<td><input type='hidden' name='es"+ct+"' value='"+$( "select[name=esp_id]" ).val()+"' >"+$( "select[name=esp_id] option:selected" ).text()+"</td>";
        var cur="<td><input type='hidden' name='cu"+ct+"' value='"+$( "select[name=cur_id]" ).val()+"' >"+$( "select[name=cur_id] option:selected" ).text()+"</td>";
        var par="<td><input type='hidden' name='pr"+ct+"' value='"+$( "select[name=par_id]" ).val()+"' >"+$( "select[name=par_id] option:selected" ).text()+"</td>";
        var aux_mtr=$( "select[name=mtr_id] option:selected" ).text();
        if($( "select[name=mtr_id] option:selected" ).text()=='LIBRE'){
            aux_mtr='GENERAL';
        }
        var mtr="<td><input type='hidden' name='mt"+ct+"' value='"+$( "select[name=mtr_id]" ).val()+"' >"+aux_mtr+"</td>";
        var btn="<td><i class='btn btn-danger btn-xs btn_del_par' >x</i></td>";
        var tp="<td><input type='hidden' value='1' name='tp"+ct+"' >Grupal</td>";        
        var parametros="<tr class='row_par' >"+anl+tp+jor+esp+cur+par+mtr+btn+"</tr>";
            $("#cont_parametros").append(parametros);
    })
    $(document).on("click",".btn_del_par",function(){
        obj=$(this).parent().parent();
        obj.remove();
    })

    $(document).on("click",".btn_select",function(){
        pln_id=$(this).attr('data');
            var token=$("input[name=_token]").val();
            var url=window.location;
         $.ajax({
            url:url+'/busca_una_plantilla',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {pln_id:pln_id},
            beforeSend:function(){

            },
            success:function(dt){
                $(".close").click();
                $("#pln_var1").val(dt[0]['pln_var1']);
                $("#pln_var2").val(dt[0]['pln_var2']);
                $("#pln_var3").val(dt[0]['pln_var3']);
                $("#pln_var4").val(dt[0]['pln_var4']);
                $("#pln_var5").val(dt[0]['pln_var5']);

                $("#pln_var1").attr('placeholder',dt[0]['pln_var1']);
                $("#pln_var2").attr('placeholder',dt[0]['pln_var2']);
                $("#pln_var3").attr('placeholder',dt[0]['pln_var3']);
                $("#pln_var4").attr('placeholder',dt[0]['pln_var4']);
                $("#pln_var5").attr('placeholder',dt[0]['pln_var5']);
                
                $("#cont_sms_plantilla").show();
                var txp=dt[0]['pln_descripcion'];
                var r1=txp.replace("VAR1","<span id='sp_pln_var1'>"+dt[0]['pln_var1']+"</span>");
                var r2=r1.replace("VAR2","<span id='sp_pln_var2'>"+dt[0]['pln_var2']+"</span>");
                var r3=r2.replace("VAR3","<span id='sp_pln_var3'>"+dt[0]['pln_var3']+"</span>");
                var r4=r3.replace("VAR4","<span id='sp_pln_var4'>"+dt[0]['pln_var4']+"</span>");
                var r5=r4.replace("VAR5","<span id='sp_pln_var5'>"+dt[0]['pln_var5']+"</span>");
                $("#txt_plantilla").html(r5);
                $("#tx_num").text($("#txt_plantilla").text().length);

            }
        })        
    })

    $(document).on("keyup",".pln_var",function(){
        var id=$(this).attr('id');
        $("#sp_"+id).text($(this).val());
        $("#tx_num").text($("#txt_plantilla").text().length);
        var nm=$("#txt_plantilla").text().length;
        if(nm>=140 && nm<150){
            $("#tx_num").attr('class','badge bg-yellow');
        }else if(nm>=150){
            $("#tx_num").attr('class','badge bg-red');
        }else{
            $("#tx_num").attr('class','badge bg-green');
        }

    })

    $(document).on("change","#opcion",function(){
         var op=$("#opcion").val(); //0->sms 1->Correo 2->Sms y Correo
         var obj=(this);
                $("#sms_mensaje").val(null);
                $("#sms_mensaje2").text(null);
         if(op==''){
            alert('Elija una Opción');
        }else{
             if(op==1){
                $("#cont_sms_mensaje").show();
                $("#cont_sms_plantilla").hide();
            }else{
                var token=$("input[name=_token]").val();
                var url=window.location;
                $.ajax({
                    url:url+'/busca_plantillas',
                    headers:{'X-CSRF-TOKEN':token},
                    type: 'POST',
                    dataType: 'json',
                    data: {op:0},
                    beforeSend:function(){
                    },
                    success:function(dt){
                        $("#cont_plantillas").html(dt);
                        $("#btn_action_modal").click();
                        $("#cont_sms_mensaje").hide();
                    }
                })
            }
    }

    })



</script>
<style>
    .row_par{
        border:solid 1px white;
    }
</style>

<!-- Modal -->
<button type="button" hidden id="btn_action_modal" data-toggle="modal" data-target="#modal_plantilla"></button>
<div class="modal fade" id="modal_plantilla" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body" id="cont_plantillas">

      </div>
    </div>
  </div>
</div>


    <section class="content-header">
        <div class="row bg-primary" >
            <div class="col-sm-11 text-center">
                <span style="font-size:16px;" >Envío de Comunicaciones SMS/Mail</span>
            </div>
            <div class="col-sm-1 bg-info">
                <a class="btn btn-primary pull-right"  href="{!! route('smsMails.create') !!}">Nuevo</a>
            </div>
        </div>

    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="border:solid 1px">
                            <table class="table" style="margin-top:0px;" border="0">
                                <thead class="bg-info">
                                    <tr>
                                        <th class="text-center">Jornada</th>
                                        <th class="text-center">Especialidad</th>
                                        <th class="text-center">Curso</th>
                                        <th class="text-center">Paralelo</th>
                                        <th class="text-center" id="mtr_id_t">Materia</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td hidden>
                                        {!! Form::select('tp_asis',['0'=>'General','1'=>'Docente'],null,['class'=>'form-control']) !!}    
                                    </td>
                                    <td hidden id="anl_id">
                                        {!! Form::text('anl_id',$anl,null,['class'=>'form-control']) !!}    
                                    </td>
                                    <td hidden id='td_perid'>
                                        {!! Form::select('per_id',$per,null,['class'=>'form-control']) !!}    
                                    </td>
                                    <td id="jor_id">
                                        {!! Form::select('jor_id',$jor,null,['class'=>'form-control']) !!}    
                                    </td>
                                    <td id="esp_id">
                                        {!! Form::select('esp_id',$esp,null,['class'=>'form-control']) !!}    
                                    </td>
                                    <td id="cur_id">
                                        {!! Form::select('cur_id',$cur,null,['class'=>'form-control']) !!}    
                                    </td>
                                    <td>
                                        {!! Form::select('par_id',[
                                        '0'=>'TODOS',
                                        'A'=>'A',
                                        'B'=>'B',
                                        'C'=>'C',
                                        'D'=>'D',
                                        'E'=>'E',
                                        'F'=>'F',
                                        'G'=>'G',
                                        'H'=>'H',
                                        'I'=>'I',
                                        'J'=>'J',
                                        ],null,['class'=>'form-control','id'=>'par_id']) !!}    
                                    </td>            
                                    <td id="mtr_id">
                                        {!! Form::select('mtr_id',$mtr,null,['class'=>'form-control']) !!}    
                                    </td>            
                                    <td>
                                        <i class="btn bg-green fa fa-users btn_add_parametros"> Grupal</i>
                                    </td>
                                </tr> 
                                <tr class="bg-info">
                                    <th colspan="6">ESTUDIANTE</th> 
                                </tr> 
                                <tr>
                                    <td colspan="2">
                                        {!! Form::select('est_id',$est,null,['class'=>'form-control est_combo']) !!}    
                                        <i class="btn bg-green fa fa-user btn_add_estudiante">Individual</i>
                                    </td>
                                    <td colspan="2">
                                    </td>  
                                </tr>
                            </table>

                    {!! Form::open(['route' => 'smsMails.store','onsubmit'=>'return validar()']) !!}

                    <input type="hidden" id="contador" name="contador" value="0" >
                    <div class="row">
                                <div class="col-sm-6">
                                    <table class="table">
                                        <tr class="bg-info">
                                            <th>Tipo</th>
                                            <th>Jornada</th>
                                            <th>Especialidad</th>
                                            <th>Curso</th>
                                            <th>Paralelo</th>
                                            <th>Materia</th>
                                            <th>...</th>
                                        </tr>
                                        <tbody id="cont_parametros" style="background:#ecf0f5;" >
                                        </tbody>
                                    </table>
                                </div> 
                                <div class="col-sm-6" >
                                    <div class="row" style="background:#ecf0f5;padding:10px;  " id="cont_sms_plantilla" hidden>
                                    <div class="col-sm-12 text-center">
                                        <span class="bg-danger text-danger" style="padding:5px ">ESCRIBA EN LOS CASILLEROS LA DESCRIPCIÓN DEL MENSAJE </span>    
                                    </div>
                                        <div class="col-sm-6">
                                            {!! Form::text('pln_var1','',['class'=>'form-control pln_var','id'=>'pln_var1']) !!} 
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::text('pln_var2','',['class'=>'form-control pln_var','id'=>'pln_var2']) !!} 
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::text('pln_var3','',['class'=>'form-control pln_var','id'=>'pln_var3']) !!} 
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::text('pln_var4','',['class'=>'form-control pln_var','id'=>'pln_var4']) !!} 
                                        </div>
                                        <div class="col-sm-6">
                                            {!! Form::text('pln_var5','',['class'=>'form-control pln_var','id'=>'pln_var5']) !!} 
                                        </div>
                                        <div class="col-sm-10 bg-info " id="txt_plantilla" style="border:solid 2px #ccc;padding:10px;margin-top:5px;border-radius:5px  ">
                                        </div>
                                        <div class="col-sm-2" >
                                            <span class="badge bg-green" style="font-weight:bolder;padding:5px;font-size:15px" id="tx_num"></span>
                                        </div>
                                    </div>
                                    <div class="row" id="cont_sms_mensaje" hidden >
                                        <div class="col-sm-12"  >
                                            {!! Form::hidden('sms_mensaje',null,['class'=>'form-control','id'=>'sms_mensaje']) !!}    
                                            {!! Form::textarea('sms_mensaje2',null,['class'=>'form-control','id'=>'sms_mensaje2']) !!}    
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="row container-fluid " >
                                        <div class="input-group col-sm-3" style="margin-left:10px;">
                                            {!! Form::select('opcion',[''=>'Elija una Opcion','2'=>'SMS y Correo','0'=>'SMS','1'=>'Correo'],null,['class'=>'form-control','id'=>'opcion']) !!}    
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-warning pull-right">Enviar Notificación</button>
                                            </span>
                                        </div>

                        </div>
                       {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    

@endsection
