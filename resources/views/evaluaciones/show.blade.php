@extends('layouts.app')

@section('content')

<div class="modal fade" id="modal_preguntas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="evaluaciones.store_questions" method="POST" enctype="multipart/form-data" id="frm_guarda_pregunta">
            {{csrf_field()}}
            <div class='col-sm-12 input-group'>
                <input type="hidden" class='form-control' name="evp_id" id="evp_id" value="0" >
                <input type="hidden" class='form-control' name="aux_evg_id" id="aux_evg_id" >
                <span class='input-group-addon' style='width:100px ' ><b>Pregunta</b></span>
                <textarea class='form-control' name="evp_pregunta" id="evp_pregunta" rows="3"></textarea>
            </div>
            <div class='col-sm-12 input-group'>
                <span class='input-group-addon' style='width:100px ' ><b>Gráfico</b></span>
                <div class="form-group">
                    <input type='file' name="evp_imagen" id='evp_imagen' onchange="readURL(this);" />
                    <img id="img_prev" src="#" width="250px"  />
                </div>
            </div>

            <div class='col-sm-12 input-group'>
                <span class='input-group-addon' style='width:100px ' ><b>a)</b><input type="radio" name="op_resp" value="1" ></span>
                <input type="text" class='form-control' name="evp_resp1" id="evp_resp1" >
            </div>
            <div class='col-sm-12 input-group'>
                <span class='input-group-addon' style='width:100px ' ><b>b)</b><input type="radio" name="op_resp" value="2" ></span>
                <input type='text'class='form-control' name="evp_resp2" id="evp_resp2" >
            </div>
            <div class='col-sm-12 input-group'>
                <span class='input-group-addon' style='width:100px ' ><b>c)</b><input type="radio" name="op_resp" value="3" ></span>
                <input type='text'class='form-control' name="evp_resp3" id="evp_resp3" >
            </div>
            <div class='col-sm-12 input-group'>
                <span class='input-group-addon' style='width:100px ' ><b>d)</b><input type="radio" name="op_resp" value="4" ></span>
                <input type='text'class='form-control' name="evp_resp4" id="evp_resp4" >
            </div>
            <div class='col-sm-12 input-group'>
                <span class='input-group-addon' style='width:100px ' ><b>e)</b><input type="radio" name="op_resp" value="5" ></span>
                <input type='text'class='form-control' name="evp_resp5" id="evp_resp5" >
                <input type='hidden'class='form-control' name="evp_resp" id="evp_resp" >
            </div>
        </form>
            <div class="modal-footer">
                <button class="btn btn-primary pull-left btn_guarda_pregunta">Guardar</button>
                <button class="btn btn-danger" data-dismiss="modal" >Cancelar</button>
            </div>

      </div>
    </div>
  </div>
</div>  

    <script>
        $(document).on("click",".btn_guarda_pregunta",function(){
            var resp=$("input[name=op_resp]:checked").val();
            $("#evp_resp").val(resp);
            $("#frm_guarda_pregunta").submit();
        })
        $(document).on("click",".btn_agrega_grupo",function(){

            if($("#evg_descripcion").val().length==0){
                alert('Campo Grupo es Obligatorio');
                $("#evg_descripcion").select();
            }else if($("#evg_valoracion").val().length==0){
                alert('Campo Valor es Obligatorio');
                $("#evg_valoracion").select();
            }else if( isNaN($("#evg_valoracion").val()) ){
                      alert('Campo Valor debe ser numérico');
                     $("#evg_valoracion").select();
            }else{
                $("#frm_guarda_grupos").submit();
            }

        })
        $(document).on("click",".btn_modal_preguntas",function(){
            $("#aux_evg_id").val($(this).attr('data'));
            $("#modal_preguntas").modal("show");
        })

        $(document).on("click",".btn_edita_pregunta",function(){

                        var token=$("input[name=_token]").val();
                        var url=window.location;

                        $.ajax({
                            url:url+'/load_pregunta',
                            headers:{'X-CSRF-TOKEN':token},
                            type: 'POST',
                            dataType: 'json',
                            data: {evp_id:$(this).attr('data')},
                            beforeSend:function(){

                        },
                        success:function(dt){

                            $("#evp_id").val(dt['evp_id']);
                            $("#aux_evg_id").val(dt['evg_id']);
                            $("#evp_pregunta").val(dt['evp_pregunta']);
                            // $("#evp_imagen").val(dt['evp_imagen']);
                            $("#evp_resp1").val(dt['evp_resp1']);
                            $("#evp_resp2").val(dt['evp_resp2']);
                            $("#evp_resp3").val(dt['evp_resp3']);
                            $("#evp_resp4").val(dt['evp_resp4']);
                            $("#evp_resp5").val(dt['evp_resp5']);
                            $("#evp_resp").val(dt['evp_resp']);

                            var obj=$("#evp_resp"+dt['evp_resp']).parent();
                            $(obj).find("input[name=op_resp]").prop("checked",true);

                            $("#modal_preguntas").modal("show");
                        }
                    }) 
        })

        $(document).on("click",".btn_edita_grupo",function(){
            $("#evg_id").val($(this).attr('evg_id'));
            $("#evg_descripcion").val($(this).attr('evg_descripcion'));
            $("#evg_valoracion").val($(this).attr('evg_valoracion'));
        })

        $(document).on("click",".btn_elimina_pregunta",function(){
            var evp_id=$(this).attr('data');
            if(confirm("Se eliminará la pregunta \n Continuar?  ")){
                $("#elimina_evp_id").val(evp_id);
                $("#elimina_evg_id").val(0);
                $("#frm_elimina_grupo").submit();
            }
        })


        $(document).on("click",".btn_elimina_grupo",function(){
            if(confirm("Se eliminaran las preguntas con el grupo \n Continuar?  ")){
                $("#elimina_evg_id").val($(this).attr('evg_id'));
                $("#elimina_evp_id").val(0);
                $("#frm_elimina_grupo").submit();
            }

        })


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img_prev').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>




    <style>
        .rw_table:hover{
            background:#B3E7F8;
            cursor:pointer; 
            font-weight: 
        }
        #tbl_preguntas td,th{
            border:solid 1px #ccc ;
        }
        .col_respuestas{
            height:30px; 
            /* border-bottom:solid 1px #ccc ; */
        }
    </style>
    <section class="content-header">
        <h1>
            {{$evaluaciones->evl_descripcion}}
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">

                            <form action="evaluaciones.elimina_grupo" method="POST" id="frm_elimina_grupo">
                                {{csrf_field()}}
                                <input type="hidden" class='form-control' name="elimina_evg_id" id="elimina_evg_id" value="0" >
                                <input type="hidden" class='form-control' name="elimina_evp_id" id="elimina_evp_id" value="0" >
                            </form>


                            <form action="evaluaciones.store_groups" method="POST" id="frm_guarda_grupos">
                                {{csrf_field()}}
                                <div class='col-sm-6 input-group'>
                                    <input type="hidden" class='form-control' name="evl_id" id="evl_id" value="{{$evaluaciones->evl_id}}" >
                                    <input type="hidden" class='form-control' name="evg_id" id="evg_id" value="0" >
                                    <span class='input-group-addon'><b>Grupo</b></span>
                                    <input type="text" class='form-control' name="evg_descripcion" id="evg_descripcion" placeholder="Nombre del Grupo" >
                                    <span class='input-group-addon'><b>Valor</b></span>
                                    <input type="text" class='form-control' size="1" name="evg_valoracion"  id="evg_valoracion" placeholder="Nota " >
                                    <span class='input-group-addon btn label-primary btn_agrega_grupo'><i class='fa fa-plus-square' ></i> Guardar</span>
                                </div>
                            </form>

                            <br>
                            <div class='table-responsive'>
                                <table class='table' id="tbl_preguntas" border="0">
                                    <tbody>
                                        {!!$datos!!}

                                    </tbody>

                                </table>
                            </div>
                </div>
            </div>
        </div>
    </div>

@endsection

