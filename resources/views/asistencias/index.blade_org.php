@extends('layouts.app')

@section('scripts')

<script>
    var url = window.location;        
    $(function () {
        $("#search").click(function () {
            var mtr=$("#mtr_id").val();
            j = $("#jor_id").val();
            e = $("#esp_id").val();
            curso = $("#cur_id").val();
            dat=curso.split("-");
            c=dat[0];
            p=dat[1];
                $.ajax({
                    url: url + "/lista/"+j+"&"+e+"&"+c+"&"+p+"&"+mtr,
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                    },
                    success: function (dt) {
                         $("#tbl_asistencia").html(dt);
                        // $(".bloqueo").css('visibility', 'hidden');
                    }
                });
        });   

        $("#save").click(function () {
            var mtr=$("#mtr_id").val();
            var usu=$("#usu_id").val();
            var token=$("#token").val();
            c=0;
            data=[];
            //alert('ok');
            $(".asist").each(function() {
                item=[];
                id=$(this).attr('id');
                nov=$("#nov_"+id).val();
                obs=$("#obs_"+id).val();
            if(nov!='0'){
                item.push(id);
                item.push(nov);
                item.push(obs);
                data.push(item); 
                c++;
            }
        });

                $.ajax({
                    url: url + "/lista_save",
                    headers:{'X-CSRF-TOKEN':token},
                    type: 'POST',
                    dataType: 'json',
                    data: {'dat':data,mtr:mtr,usu:usu},
                    beforeSend: function () {

                    },
                    success: function (dt) {
                        if(dt==0){
                            alert("Datos Guardados correctamente");
                        }else{
                            alert("Algun error a sucedido");
                        }
                        //$("#tbl_asistencia").html(dt);
                        // $(".bloqueo").css('visibility', 'hidden');
                    }
                });
        })

        $("#jor_id").val('0');
                    var mod=$("#mod_id").val();
                    if($('#opt_tipo').val()==0){
                    //    $('#cont_esp').hide();
                    //    $('#cont_mtr').hide();
                }else{
                    //    $('#cont_esp').show();
                    //    $('#cont_mtr').show();
                }


        $("#mtr_id").val('0');
        $("#esp_id").val('0');

        $('#radioBtn a').on('click', function(){
            var sel = $(this).data('title');
            var tog = $(this).data('toggle');
            $('#'+tog).prop('value', sel);

            $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
            $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');

            if($('#'+tog).val()==0){
                $('#cont_esp').hide();
                $('#cont_mtr').hide();
            }else{
                $('#cont_esp').show();
                $('#cont_mtr').show();
            }
        })
    });
        $(document).on("change","#jor_id",function(){
            var token=$("#token").val();
            //alert(url+"/search");
            $.ajax({
                url: url + "/search",
                headers:{'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {jor:$(this).val(),op:1},
                beforeSend: function () {
                },
                success: function (dt) {
                    $("#cur_id").append(dt);
                    if($('#opt_tipo').val()==0){
                        $('#esp_id').html("<option value='10'>Cultural</option>");
                    }else{
                        //$('#esp_id').html("<option value='0'>Seleccione</option>");
                    }
                }
            });
        });    

        $(document).on("change","#cur_id",function(){
            var token=$("#token").val();
            $.ajax({
                url: url + "/search",
                headers:{'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {cur:$(this).val(),op:2},
                beforeSend: function () {

                },
                success: function (dt) {
                    $("#mtr_id").html(dt);
                }
            });
        });    

</script>
@endsection

@section('content')
<style>
#tbl_asistencia tr{
    border-bottom:dashed 1px #eee; 
}
    #tbl_asistencia tr:hover{
        background:#eee; 
    }
</style>
<?php
$fecha=date("d/m/Y");
?>
    <section class="content-header">
        <div class="form-group col-sm-12" style="margin-top:-30px;"  >
        <h3 class="text-center">
            Registro de Asistencia General {{$fecha}} 
            <input type="hidden" value="{{csrf_token()}}" id="token">
            <input type="hidden" id="usu_id" value="{{Auth::user()->id}}">
            <input type="hidden" id="mod_id" value="{{$permisos->mod_id}}">
        </h3>
        </div>

        <div class="input-group pull-left col-sm-12" style="margin-top:-50px " >
            <div id="radioBtn" class="btn-group  mx-5">
                <a class="btn btn-primary btn-sm active" data-toggle="opt_tipo" data-title="0">CULTURAL</a>
                <a class="btn btn-primary btn-sm notActive" data-toggle="opt_tipo" data-title="1">TÉCNICO</a>
            </div>
            <input type="hidden" name="opt_tipo" value="0" id="opt_tipo">
        </div>  

            <div class="form-group col-sm-2"  >
                {!! Form::label('jor_id', 'Jornada:') !!}
                {!! Form::select('jor_id',$jor,null,['class'=>'form-control']) !!}    
            </div>
            <div class="form-group col-sm-3" id="cont_esp"  >
                {!! Form::label('esp_id', 'Especialidad:') !!}
                {!! Form::select('esp_id',$esp,null,['class'=>'form-control']) !!}    
            </div>
            <div class="form-group col-sm-2"  >
                {!! Form::label('cur_id', 'Curso:') !!}
                {!! Form::select('cur_id',$cur,null,['class'=>'form-control']) !!}    
            </div>
            <div class="form-group col-sm-3" id="cont_mtr" >
                {!! Form::label('mtr_id', 'Materia:') !!}
                {!! Form::select('mtr_id',$mtr,null,['class'=>'form-control','id'=>'mtr_id']) !!}    
            </div>            
            <div class="form-group col-sm-1">
                <button id="search" class="btn btn-info pull-left" style="margin-top:25px;margin-left:-30px "><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>

    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <table id="tbl_asistencia" class="table table-hover">

                </table>
            </div>
        </div>
        <div class="text-center">
        <input type="button" id="save" class="btn btn-primary pull-left" value="Guardar" >
        <input type="button" id="cancel" class="btn btn-danger pull-right" value="Cancelar" >
        </div>
    </div>
@endsection

