@extends('layouts.app')

@section('content')
<style>
    td,th{
       border:solid 1px #ccc;  
    }
    #tbl_datos tr:hover{
        background:#9BD5E1; 
    } 
</style>
<script>

$(function(){
    $('#radioBtn a').on('click', function(){
        var sel = $(this).data('title');
        var tog = $(this).data('toggle');
        $('#'+tog).prop('value', sel);
        $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
        $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');

        if(sel==0){
            $(".col_nota").show();
        }else{
            $(".col_nota").hide();
        }
    })
})

function limpiar_datos_modal(){
    $("#quim1").prop("checked",false);
    $("#quim2").prop("checked",false);
    $("#nota").val(null);
}

$(document).on("click",".btn_asigna_notas",function(){
    $("#mdl_notas").modal("show");
    var esp=$("select[name=esp_id]").val();
    var tipo="Técnicas";
    if(esp==10 || esp==8 || esp==7){
        tipo="Culturales";
    }
    var nmest=$(this).attr('nm_estudiante');
    var mat_id=$(this).attr('mat_id');
    $("#mat_id").val(mat_id);
    $("#lbl_estudiante").text(nmest+" ("+tipo+")");
})

$(document).on("click","#btn_save_notes",function(){
    var esp=$("select[name=esp_id]").val();
    var mat_id=$("#mat_id").val();
    var nota=$("#nota").val();
    var qm1=$("#quim1").prop("checked");
    var qm2=$("#quim2").prop("checked");
    var token=$("input[name=_token]").val();
    var url=window.location;
    $.ajax({
        url:url+'/registra_notas_aulav',
        headers:{'X-CSRF-TOKEN':token},
        type: 'POST',
        dataType: 'json',
        data: {esp:esp,mat_id:mat_id,nota:nota,qm1:qm1,qm2:qm2},
        beforeSend:function(){
            
            if(!qm1 && !qm2){
                Swal.fire(
                  'Elija un quimestre',
                  'Debe seleccionar una opción',
                  'error'
                  )
                return false;
            }

            if (isNaN(nota)){
                Swal.fire(
                  'Nota No Válida',
                  'Debe ser numérico',
                  'error'
                  )
                return false;
            }

            if( (nota<7 || nota>10) ){
                Swal.fire(
                  'Nota Incorrecta',
                  'De: 1 a 10 es válida',
                  'error'
                  )
                return false;
            }

                Swal.showLoading();

            },
            success:function(dt){
                if(dt==0){
                    Swal.fire(
                      'Proceso Correcto',
                      '',
                      'success'
                      )    
                      $("#mdl_notas").modal("hide");
                      limpiar_datos_modal();                
                }else{
                    Swal.fire(
                      'Error Intente de nuevo',
                      'Si el problema persiste informe a sistemas',
                      'error'
                      )                    
                }
                //$("input[name=tar_codigo]").val(dt);
          }
      })

    //$("#mdl_notas").modal("show");
})

$(document).on("click",".btn_folder",function(){
    $("#folder_mat_id").val( $(this).attr('mat_id') );
    $("#folder_estudiante").val( $(this).attr('estudiante') );
    $("#frm_descarga_folder").submit();
})

</script>


<!-- Modal -->
<div class="modal fade" id="mdl_notas" tabindex="-1" role="dialog" aria-labelledby="labelModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title bg-primary text-center" id="labelModal" style="padding:5px ">
            Asignar Notas Masivas
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </h5>
      </div>
      <div class="modal-body">
        <div class="row text-center" style="font-size:14px;margin-top:-10px ">
            <label id="lbl_estudiante"></label>
        </div>

        <div class="row">
            <div class="input-group">
                <label class="btn input-group-addon" style="font-size:16px;background:#eee;margin-left:2px ">
                    <input type="checkbox" id="quim1" disabled  > Quimestre 1
                </label>
                <label class="btn input-group-addon" style="font-size:16px;background:#eee;margin-left:2px ">
                    <input type="checkbox" id="quim2"  > Quimestre 2
                </label>
                <label class="input-group-addon" style="font-size:16px">Nota:</label>
                <input type="hidden" class="form-control" id="mat_id" style="width:50%" >
                <input type="text" class="form-control" id="nota" style="width:50%" >
            </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success pull-left" id="btn_save_notes" >Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>



<form action="student_folder_search/comprimirDescargar" id="frm_descarga_folder" method="POST">
    {{ csrf_field()}}
    <input type="hidden" id="folder_mat_id" name="folder_mat_id">
    <input type="hidden" id="folder_estudiante" name="folder_estudiante">
</form>


    <section class="content-header">
        <div class="row text-center bg-primary" style="padding:5px ">
                Folder del Estudiante
        </div>
    </section>
    <div class="content">
        <div class="box box-primary">
<br>
<form action="student_folder_search" method="POST" >
    {{csrf_field()}}
        <div class="form-group row">
          <div class="input-group">
            <label for="jor_id" class='input-group-addon'></label>
            {!! Form::select('jor_id',$jor,null, ['class' => 'form-control input-group-addon']) !!}
            <label for="esp_id" class='input-group-addon'></label>
            {!! Form::select('esp_id',$esp,null,['class' => 'form-control input-group-addon']) !!}
            <label for="cur_id" class='input-group-addon'></label>
            {!! Form::select('cur_id',$cur,null, ['class' => 'form-control ']) !!}
            <label for="paralelo" class='input-group-addon'></label>
            {!! Form::select('paralelo',['A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E','F'=>'F','G'=>'G','H'=>'H',],null, ['class' => 'form-control']) !!}
            <label  class='input-group-addon'></label>
            <button class="form-control btn btn-primary fa fa-search" value="search" name="btn_buscar"></button>
            <label  class='input-group-addon'></label>
            <button class="form-control btn btn-success fa fa-file-excel-o" value="excel" name="btn_buscar"> Excel</button>
          </div>
        </div>  
</form>


        @if(isset($datos))
        <div class="table-responsive">
            <table class="table table-border ">
                <tr class="bg-primary">
                    <th>#</th>
                    <th> -----------------Estudiante----------------------

                    <div class="input-group " id="only_percentes" >
                        <div id="radioBtn" class="btn-group"  >
                            <a class="btn btn-info btn-sm active" data-toggle="option" data-title="0">Mostrar Materias</a>
                            <a class="btn btn-info btn-sm notActive" data-toggle="option" data-title="1">Ocultar Materias</a>
                        </div>
                   </div> 


                    </th>
                        @foreach($tx_materia as $th)
                        <th class="col_nota" >{{$th}}</th>
                        @endforeach
                        <th style="background:#fff" ><i class="fa fa-check-circle" style="font-size:30px;color:#46E301;" aria-hidden="true"></i></th>
                        <th style="background:#fff" ><i class="fa fa-times-circle" style="font-size:30px;color:#F21414;" aria-hidden="true"></i></th>
                        <th style="background:#fff;color:#000">Tot.Tareas</th>
                        <th >%Completado</th>
                        <th>Asg.Nota</th>
                </tr>
                <tbody id="tbl_datos">
                <?php $x=1;?>
                @foreach($datos as $d)
                <?php $dtest=explode("&",$d->estudiante) ?>
                <tr class="row_estudiante" >
                    <td>{{$x++}}</td>
                    <td>
                       <div class="dropdown" >
                          <label  style="font-size:12px;cursor:pointer;font-weight:500;   " type="button" data-toggle="dropdown">{{$dtest[0]}}<span class="caret"></span> </label>
                              <ul class="dropdown-menu" style="border:solid 2px #75BDCC;" >
                                <li><a href="javascript:void(0)" class="btn_folder" estudiante="{{$dtest[0]}}" mat_id="{{$dtest[1]}}" ><i class="fa fa-folder text-primary"></i>Descargar Folder</a></li>
                                <li><a href="javascript:void(0)" class="btn_asigna_notas" nm_estudiante='{{$dtest[0]}}' mat_id='{{$dtest[1]}}' ><i class="fa fa-sort-numeric-asc text-primary"></i>Ingresar Notas</a></li>
                            </ul>
                        </div> 
                    </td>
                    <?php $cump=0;$ncump=0?>
                    @foreach($tx_head as $th)
                        <?php $nota=explode('&',$d->$th)?> 

                                @if( !empty($nota[0]) && $nota[1]==5 )
                                    <?php $cump++;?>
                                    <td class="col_nota" ><i class="fa fa-check text-success"></i></td>
                                @else
                                    <?php $ncump++;?>
                                    <td class="col_nota" >-</td>
                                @endif

                    @endforeach
                    <?php 
                        $p_co=number_format(($cump*100/($ncump+$cump)),2);
                        $p_nco=number_format(($ncump*100/($ncump+$cump)),2);
                        $tot=($ncump+$cump);
                        $cls="";
                        if($p_co>=70){
                            $cls="alert-success";
                        }
                        if($p_co>=50 && $p_co<70){
                            $cls="alert-warning";
                        }

                        if($p_co>=0 && $p_co<50){
                            $cls="alert-danger";
                        }

                    ?>
                    <td style="text-align:right;" class="alert-success">{{$cump}}</td>
                    <td style="text-align:right;" class="alert-danger">{{$ncump}}</td>
                    <td style="text-align:right;" class="alert-default">{{$tot}}</td>
                    <td style="text-align:right;" class="{{$cls}}">{{$p_co.' %'}}</td>
                    <td>
                        <i class="btn btn-default fa fa-sort-numeric-asc btn_asigna_notas" nm_estudiante='{{$dtest[0]}}' mat_id='{{$dtest[1]}}' title="Asignar Notas del Portafolio"></i>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>   
        </div>
        @endif
       </div>
    </div>
@endsection
