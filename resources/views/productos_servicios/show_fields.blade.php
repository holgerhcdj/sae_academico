<style>
    #tbl_factura tr th{
        text-align:center; 
    }
    label{
        text-align:left;  
    }
</style>
<script>
    $(document).on("click","#btn_nuevo_cliente",function(){

        $("input[name=op]").val(1);
        $("input[name=cli_apellidos]").attr('readonly',false);
        $("input[name=cli_nombres]").attr('readonly',false);
        $("input[name=cli_telefono]").attr('readonly',false);
        $("input[name=cli_email]").attr('readonly',false);
        $("input[name=cli_direccion]").attr('readonly',false);

        $("input[name=cli_apellidos]").val(null);
        $("input[name=cli_nombres]").val(null);
        $("input[name=cli_telefono]").val(null);
        $("input[name=cli_email]").val(null);
        $("input[name=cli_direccion]").val(null);

    })
    $(document).on("click","#btn_search_client",function(){
        $("#btn_modal_client").click();
        var url=window.location;
        var token=$("input[name=_token]").val();
//        var cli=$("input[name=cli_id]").val();
        var ruc=$("input[name=cli_ced_ruc]").val();
        $.ajax({
            url: url+'/busca_cliente',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {ruc:ruc},
            beforeSend:function(){
              if($("input[name=cli_ced_ruc]").val().length<3){

                alert("Ingrese un criterio de busqueda");
                return false;

              }
              //alert('okk');
            },
            success:function(dt){
                if(dt.length==0){
                    alert("Cliente no existe");
                }else{
                    $("#client_datos").html(dt);
                }

            }
        })
    })

    $(document).on("keyup","input[name=dfc_precio_unit]",function(){
        calculos();
    })

    $(document).on("change","select[name=dfc_cantidad],select[name=dfc_iva]",function(){
        calculos();
    })

    $(document).on("click",".btn_check",function(){
      var cli=$(this).attr('data').split('*&');
      $("input[name=cli_id]").val(cli[0]);
      $("input[name=cli_ced_ruc]").val(cli[1]);
      $("input[name=cli_apellidos]").val(cli[2]);
      $("input[name=cli_nombres]").val(cli[3]);
      $("input[name=cli_telefono]").val(cli[4]);
      $("input[name=cli_email]").val(cli[5]);
      $("input[name=cli_direccion]").val(cli[6]);
    })


    function calculos(){
        var cnt=(parseFloat($("select[name=dfc_cantidad]").val())/15);
        var vu=parseFloat($("input[name=dfc_precio_unit]").val());
        var iva=parseFloat($("select[name=dfc_iva]").val());
        var tot=(cnt*vu);
        var iv=(tot*iva/100);
        $("input[name=dfc_precio_total]").val((tot+iv));
    }

    $(function(){

      $("input:text").keyup(function() {
        if($(this).attr('name')!='cli_email'){
          $(this).val($(this).val().toUpperCase());
        }else{
          $(this).val($(this).val().toLowerCase());
        }
     });
   })

  // $(document).on("input","input[name=cli_ced_ruc]",function(){
  //         this.value = this.value.replace(/[^0-9]/g,'');
  // })



</script>
<!-- Button trigger modal -->
<button type="button" id="btn_modal_client" class="btn btn-primary" data-toggle="modal" data-target="#mdl_clientes" style="display:none "></button>
<!-- Modal -->
<div class="modal fade" id="mdl_clientes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center bg-primary" id="exampleModalLabel" style="padding:5px;" >
            Clientes
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:brown;"><span aria-hidden="true">&times;</span></button>
        </h5>

      </div>
      <div class="modal-body">
        <table id="client_datos" class='table'>
            
        </table>
      </div>
    </div>
  </div>
</div>

{!! Form::open(['route' => 'productosServicios.store']) !!}

                <div class="contenido">
                    <div class="row">
                        <div class="form-group col-sm-5">
                            <div class="input-group">
                              {!! Form::hidden('cli_id',0,['class' => 'form-control','required '=>'required']) !!}

                              {!! Form::label('cli_ced_ruc', 'C.C/Ruc:',['class'=>'input-group-addon']) !!}
                              {!! Form::text('cli_ced_ruc',null,['class' => 'form-control','required '=>'required','maxlength'=>'13']) !!}
                              <span class="btn input-group-addon" id="btn_search_client" style="background:#3c8dbc;color:white"><i class="fa fa-search"></i></span>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-sm-9">
                        <div class="input-group">
                          {!! Form::label('cli_apellidos', 'Apellidos:',['class'=>'input-group-addon']) !!}
                          {!! Form::text('cli_apellidos',null,['class' => 'form-control','required '=>'required','readonly']) !!}

                          {!! Form::label('cli_nombres', 'Nombres:',['class'=>'input-group-addon']) !!}
                          {!! Form::text('cli_nombres',null,['class' => 'form-control','required '=>'required','readonly']) !!}
                      </div>
                  </div>
              </div>

              <div class="row">
                <div class="form-group col-sm-5">
                    <div class="input-group">
                      {!! Form::label('cli_telefono', 'Teléfono:',['class'=>'input-group-addon']) !!}
                      {!! Form::text('cli_telefono',null,['class' => 'form-control','required '=>'required','readonly']) !!}
                  </div>
              </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-5">
                    <div class="input-group">
                      {!! Form::label('cli_email', 'E-mail:',['class'=>'input-group-addon']) !!}
                      {!! Form::text('cli_email',null,['class' => 'form-control','required '=>'required','readonly']) !!}
                  </div>
              </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-9">
                    <div class="input-group">
                      {!! Form::label('cli_direccion', 'Dirección:',['class'=>'input-group-addon']) !!}
                      {!! Form::text('cli_direccion',null,['class' => 'form-control','required '=>'required','readonly']) !!}
                  </div>
              </div>
            </div>    
            </div>

            <table class="" id="tbl_factura">
                <tr>
                    <th>Cant</th>
                    <th>Producto</th>
                    <th>Tiempo</th>
                    <th>V.unitario</th>
                    <th>IVA</th>
                    <th>V.Total</th>
                </tr>
                <tr>
                    <td>
                        {!! Form::text('item',1,['class' => 'form-control','size'=>'1','required '=>'required','readonly']) !!}
                    </td>
                    <td>
                        {!! Form::hidden('pro_id',$productosServicios->pro_id,['class' => 'form-control','size'=>'50','required '=>'required']) !!}
                        {!! Form::text('pro_descripcion',$productosServicios->pro_descripcion,['class' => 'form-control','size'=>'50','required '=>'required','readonly']) !!}
                    </td>
                    <td>
                        {!! Form::select('dfc_cantidad',['15'=>'15 min','30'=>'30 min','45'=>'45 min','60'=>'1:00 Hora','75'=>'1:15 Horas','90'=>'1:30 Horas','105'=>'1:45 Horas','120'=>'2:00 Horas'],null,['class' => 'form-control','required '=>'required']) !!}                    </td>        
                    <td>
                        {!! Form::text('dfc_precio_unit',null,['class' => 'form-control','size'=>'10','required '=>'required']) !!}
                    </td>
                    <td>
                        {!! Form::select('dfc_iva',['0'=>'0','12'=>'12'],null,['class' => 'form-control','required '=>'required']) !!}
                    </td>
                    <td>
                        {!! Form::text('dfc_precio_total',null,['class' => 'form-control','size'=>'10','required '=>'required','readonly']) !!}
                    </td>
                </tr>
            </table>
            <br>
            <button class="btn btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
            <a href="{!! route('productosServicios.index') !!}" class="btn btn-danger pull-right"><i class="fa fa-close"></i> Salir</a>
{!! Form::close() !!}