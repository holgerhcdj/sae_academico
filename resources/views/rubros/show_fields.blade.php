<?php
//dd($permisos['new']);
?>
<script>
    $(function(){
            var nw ='<?php echo $permisos['new']?>';
            var ed ='<?php echo $permisos['edit']?>';
            var dl ='<?php echo $permisos['del']?>';

                $(document).on("click",".btn_elimina_pago",function(){
                    var url=window.location;
                    var token=$("#token").val();
                    var pgr_id=$(this).attr("data");
                    $.ajax({
                        url: url+'/elimina_pago',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {'pgr_id':pgr_id},
                        beforeSend:function(){
                            if(dl==0){
                                alert("Ud no tiene permisos de eliminar");
                                return false;
                            }
                        },
                        success:function(dt){
                            lista_pagos(dt)

                        }
                    })

                })

    })
        $(document).on('click', '#btn_search_est', function () {
            var url = window.location;
            if($("#est_estudiante").val().length<3){
                alert('Escriba Cedula/Nombres/Apellidos del Estudiante');
            }else{           
                $.ajax({
                url: url + "/busca_varios_est/"+$("#est_estudiante").val(),
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {

                    },
                    success: function (dat) {
                        var resp="<table class='table'><tr><th>No</th><th>Jornada</th><th>Curso</th><th>Cedula</th><th>Apellidos</th></tr>";
                        var c=0;
                        $(dat).each(function(){
                            var est=$(this);
                            var dt_est=est[0]['mat_id']+"&"+est[0]['est_apellidos']+" "+est[0]['est_nombres'];
                            c++;
                            resp+="<tr>"+
                            "<td>"+c+"</td>"+
                            "<td>"+est[0]['jor_descripcion']+"</td>"+
                            "<td>"+est[0]['cur_descripcion']+" "+est[0]['mat_paralelo']+"</td>"+
                            "<td>"+est[0]['est_cedula']+"</td>"+
                            "<td>"+est[0]['est_apellidos']+" "+est[0]['est_nombres']+"</td>"+
                            "<td><button class='btn btn-success btn_ver_pago' data-dismiss='modal' data='"+dt_est+"' >Ver</button></td>"+
                            "</tr>";
                        })
                        resp+="</table>";
                        
                         $("#lst_estudiantes").html(resp);

                     }
                }); 

            }
        })    

        $(document).on('click', '.btn_ver_pago', function () {
            var url = window.location;
            var obj=$(this).attr('data').split("&");

            $("#per_id").val(obj[0]);
            data=$("#rub_id").val()+"&"+obj[0];

                $.ajax({
                url: url + "/busca_pagos_est/"+data,
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {

                    },
                    success: function (dt) {
                        $("#estudiante").val(obj[1]);
                        lista_pagos(dt);
                      }
                 }); 
        }) ;

        $(document).on("click","#btn_pagar",function(){
            var url=window.location;
            var token=$("#token").val();
            var saldo=parseFloat($("#pago_saldo").html());
            var datos=[
                $('#rub_id').val(),
                $('#per_id').val(),
                $('#pgr_monto').val(),
                $('#pgr_forma_pago').val(),
                $('#pgr_banco').val(),
                $('#pgr_documento').val(),
                $('#pgr_obs').val()
            ];

            $.ajax({
                url: url+'/guarda_pago',
                headers:{'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {'datos':datos},
                beforeSend:function(){

                    if($("#estudiante").val().length==0){
                        alert("Elija Un Estudiante");
                        return false;
                    }else if($("#pgr_monto").val().length==0){
                        $("#pgr_monto").css("border","solid 1px brown")
                        return false;
                    }else{
                        if(parseFloat($("#pgr_monto").val())>saldo){
                            alert("El valor de pago no puede se mayor al saldo")
                            return false;
                        }else{

                            if($("#pgr_forma_pago").val()!=0){

                                if($("#pgr_banco").val().length==0){
                                    $("#pgr_banco").css("border","solid 1px brown")
                                    return false;
                                }else if($("#pgr_documento").val().length==0){
                                    $("#pgr_documento").css("border","solid 1px brown")
                                    return false;
                                }


                            }else{
                                return true;
                            }

                        }
                    }
                },
                success:function(dt){
                    lista_pagos(dt);

                }
            })

        })
        function lista_pagos(dat){
                                    var resp="";
                        var c=0;
                        var tot=0;
                        var jor=0;
                        $(dat).each(function(){
                            var est=$(this);
                            jor=est[0]['jor_id'];
                            tot+=parseFloat(est[0]['pgr_monto']);
                            c++;
                            if(est[0]['pgr_forma_pago']==0){
                                frmpago='Efectivo';
                            }else if(est[0]['pgr_forma_pago']==1){
                                frmpago='Transeferecia/Deposito';
                            }else if(est[0]['pgr_forma_pago']==2){
                                frmpago='Cheque';
                            }else if(est[0]['pgr_forma_pago']==3){
                                frmpago='Tarjeta';
                            }else{
                                frmpago='Otro';
                            }
                            if(est[0]['pgr_estado']==0){
                                estado='Activo';
                            }else{
                                estado='Anulado';
                            }     
                            if(est[0]['pgr_banco']==null){
                                var banco="";
                            }else{
                                var banco=est[0]['pgr_banco'];
                            }
                            if(est[0]['pgr_documento']==null){
                                var doc="";
                            }else{
                                var doc=est[0]['pgr_documento'];
                            }
                            if(est[0]['pgr_obs']==null){
                                var obs="";
                            }else{
                                var obs=est[0]['pgr_obs'];
                            }                            

                            resp+="<tr>"+
                            "<td>"+est[0]['pgr_num']+"</td>"+
                            "<td>"+est[0]['pgr_fecha']+"</td>"+
                            "<td>"+est[0]['pgr_monto']+"</td>"+
                            "<td>"+frmpago+"</td>"+
                            "<td>"+banco+"</td>"+
                            "<td>"+doc+"</td>"+
                            "<td>"+obs+"</td>"+
                            "<td>"+estado+"</td>"+
                            "<td><button class='btn btn-danger btn-xs btn_elimina_pago' data-dismiss='modal' data='"+est[0]['pgr_id']+"' ><i class='fa fa-minus ' aria-hidden='true'></i></button></td>"+
                            "</tr>";
                        })
                        resp+="";

                        if($("#rub_id").val()==4 && (jor==2 || jor==3 )){
                            $("#rub_valor").val(20);
                        }
                        
                         $("#tbl_pagos tbody").html(resp);
                         $("#pago_saldo").html(parseFloat($("#rub_valor").val())-tot);
                $('#pgr_monto').val("");
                $('#pgr_banco').val("");
                $('#pgr_documento').val("");
                $('#pgr_obs').val("");


        }

        
    </script>
<input type="hidden" value="{{csrf_token()}}" id="token">
<div class="contenedor form-group col-sm-3">
    <input type="text" id="est_estudiante" class="form-control" name="" value="" placeholder="Cedula Apellidos Nombres ">
</div>
<div class="contenedor form-group col-sm-1">
    <button class="btn btn-info" id="btn_search_est" data-toggle="modal" data-target="#myModal" >Buscar</button>
</div>

<div class="contenedor form-group col-sm-1">
    <label>Pagos de:</label>
</div>
<div class="contenedor form-group col-sm-6">
    <input type="text" class="form-control" id="estudiante" disabled >
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span  style="padding:5px;background:#BDA500;color:#FFF261   ">Solo puede añadir un estudiante a la vez</span></h4>
      </div>
      <div class="modal-body" id="lst_estudiantes">
          
      </div>
    </div>
  </div>
</div>
<div class="form-group" hidden >
{{--     {!! Form::text('rub_id', $rubros->rub_id, ['class' => 'form-control','id'=>'rub_id']) !!} --}}
{{--     {!! Form::text('per_id',0 , ['class' => 'form-control','id'=>'per_id']) !!} --}}
{!! Form::text('rub_valor',$rubros->rub_valor, ['class' => 'form-control','id'=>'rub_valor']) !!}
</div>

    
<div class="form-group col-sm-12" id="cont_pagos">
    <table id="tbl_pagos">
        <thead style="border:solid 1px #ccc; ">
            <tr>
                <th class="text-center" width="100px">No</th>
                <th class="text-center" width="100px">Fecha</th>
                <th class="text-center" width="100px">Valor</th>
                <th class="text-center">Forma de Pago</th>
                <th class="text-center">Banco</th>
                <th class="text-center">Documento</th>
                <th class="text-center">Observaciones</th>
                <th class="text-center" colspan="3">Acciones</th>
            </tr>
            <tr>
                <th></th>
                <th></th>
                <th><input type="text" class="form-control" id="pgr_monto" ></th>
                <th>
                    <select id="pgr_forma_pago" class="form-control" >
                        <option value="0">Efectivo</option>
                        <option value="1">Transferencia/Deposito</option>
                        <option value="2">Cheque</option>
                        <option value="3">Tarjeta</option>
                    </select>
                </th>
                <th>
                    <input type="text" class="form-control" id="pgr_banco" >
                </th>
                <th><input type="text" class="form-control" id="pgr_documento" ></th>
                <th><input type="text" class="form-control" id="pgr_obs" ></th>
                <th>
                <div class='btn-group'>
                    @if($permisos['new']==1)
                        <button class="btn btn-primary" id="btn_pagar"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                    @endif
                    <form action="imrpime_pago" style="width:80px " method="post" target="_blank" accept-charset="utf-8">
                        {{ csrf_field() }}
                        {!! Form::hidden('rub_id', $rubros->rub_id, ['class' => 'form-control','id'=>'rub_id']) !!}
                        {!! Form::hidden('per_id',0 , ['class' => 'form-control','id'=>'per_id']) !!}
                        <button class="btn btn-default " title="Imprimir Pagos"><i class="fa fa-print text-danger" aria-hidden="true"></i></button>
                    </form>
                </div>
                </th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr style="font-size:15px;color:#A30101;font-weight:bolder;   ">
                <th colspan="2">Saldo</th>
                <th id="pago_saldo"></th>
            </tr>
        </tfoot>
    </table>
</div>