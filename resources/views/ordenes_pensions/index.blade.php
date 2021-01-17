@extends('layouts.app')

@section('content')
    <section class="content-header input-group ">
    <h1 class="input-group-addon" style='background:#367fa9;color:white  '>Ordenes de Pensiones</h1>
    @if(Auth::user()->id==1)
        <form action="generar_matriculas_provisionales_nuevo_anio" method="POST">
            {{csrf_field()}}
            <button class='btn btn-warning fa fa-warning '>Generar Matriculas Para Nuevo Año</button>    
            
        </form>
    @endif    
   </section>
<style>
i:hover{
    cursor:pointer; 
}   
.fa-floppy-o{
    background:green; 
    color:white; 
    padding:5px;
    border-radius:2px;
}
.fa-floppy-o:hover{
    font-weight:bolder; 
}
.fa-minus-circle{
    background:brown; 
    color:white; 
    padding:5px;
    border-radius:2px;   
    margin-left:5px;    
}
.fa-minus-circle:hover{
    font-weight:bolder;
}
#tbl_orden{
    display:none; 
    border:solid 1px #ccc ; 
}
#tbl_nueva_orden{
    background:brown;
    color:white;
    font-weight:bolder;
    border:solid 1px #000;  
}
#tbl_independiente{
/*     position:fixed;
    background:white;
    border:solid 1px #ccc;
    z-index:999;
    box-shadow:5px 5px 5px #ccc;  
    margin-top:0%;
    margin-left:5%; */
}
</style>
    <div class="row panel">
        <div class="form-group col-md-2"  >
            {!! Form::label('opcion', 'Opcion:') !!}
            {{ Form::select('opcion', [
            '0' => 'Regular',
            '1' => 'BGU',
            ],null,['class' => 'form-control']) }}    
        </div> 

        <div class="form-group col-md-2"  >
            {!! Form::label('tipo', 'Tipo:') !!}
            {{ Form::select('tipo', [
            '0' => 'Mensualidad',
            '1' => 'Matricula',
            '2' => 'Otro',
            '3' => 'BGU',
            ],null,['class' => 'form-control']) }}    
        </div> 

        <div class="form-group col-md-2"  >
            {!! Form::label('mes', 'Mes:') !!}
            {{ Form::select('mes', [
            'S' => 'Septiembre',
            'O' => 'Octubre',
            'N' => 'Noviembre',
            'D' => 'Diciembre',
            'E' => 'Enero',
            'F' => 'Febrero',
            'MZ' => 'Marzo',
            'A' => 'Abril',
            'MY' => 'Mayo',
            'J' => 'Junio',
            'JL' => 'Julio',
            'AG' => 'Agosto',
            ],null,['class' => 'form-control']) }}    
        </div> 

        <div class="form-group col-md-3"  >
                {!! Form::label('jor_id', 'Jornada:') !!}
                {!! Form::select('jor_id',$jornadas,null,['class'=>'form-control']) !!}                    
        </div> 

        <div class="form-group col-md-3" style="margin-top:25px;" >
                {{ Form::button('Generar', array('class' => 'btn btn-primary ','id'=>'btn_generar')) }}
                {{ Form::button('Nuevo', array('class' => 'btn btn-warning pull-right','id'=>'btn_genera_independiente')) }}
        </div>
</div>


    <div class="content">
        <div class="clearfix"></div>
            @include('flash::message')
        <div class="clearfix"></div>
        <div class="box box-primary" style="margin-top:-2%;" >
            <div class="box-body table-responsive">

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span  style="padding:5px;background:#BDA500;color:#FFF261   ">Solo puede añadir un estudiante a la vez</span></h4>
      </div>
      <div class="modal-body" id="lst_estudiantes"></div>
    </div>
  </div>
</div>

               
<table id="tbl_independiente" class="table" style="display:none">
    <caption class="text-center" style="background:brown;color:white;border-radius:2px;  ">
    GENERAR ORDENES INDEPENDIENTE
    <button type="button" class="close" style="margin-right:10px;border:solid 1px;padding:0px 3px 0px 3px;background:red;border-radius:2px;" id="btn_close" >&times;</button>
</caption>
    <thead>
        <tr>
            <th width="150px" colspan="2">
                <input type="text" id="ord_name" class="form-control" value="" disabled>
            </th>
            <th width="150px" colspan="2">
                <input type="text" id="ord_identificador"  class="form-control" value="" disabled>
            </th>
            <th>Estudiante:</th>
            <th colspan="2">
                <input type="text" id="est_estudiante"  class="form-control" value="" placeholder="cedula/apellidos/nombres" >
            </th>
            <th>
                <button class="btn btn-info" id="btn_search_est" data-toggle="modal" data-target="#myModal" >Buscar</button>
            </th>
        </tr>
                            <tr>
                                <th>No</th>
                                <th>JORNADA</th>
                                <th>ESPECIALIDAD</th>
                                <th>CURSO</th>
                                <th>PARALELO</th>
                                <th>CEDULA</th>
                                <th>ESTUDIANTE</th>
                                <th>CODIGO</th>                                
                                <th>VALOR</th>                                
                                <th>MOTIVO</th>
                            </tr>        
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">
                <button class="btn btn-success" id="finaliza_ind">Finalizar</button>
            </td>
        </tr>
    </tfoot>
</table>
                    <table id="tbl_ordenes" class="table table-striped table-bordered table-hover table-sm" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ORDEN</th>
                                <th>IDENTIFICADOR</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody >
                            <?php $x=1;?>
                            @foreach($ordenesPensions as $o)
                            <tr> 
                                <td>{{$x++}}</td>
                                <td>{{$o->obs}}</td>
                                <td>{{$o->identificador}}</td>                                
                                <td>

                                    <input type="button"  value="ver" class="btn btn-danger pull-left vista" lang="{{$o->identificador}}" />                                    
                                    <form action="ordenesPensions.excel" method="POST" accept-charset="utf-8">
                                        {{ csrf_field() }}
                                            <button class="btn btn-success pull-left" name="xls_orden" id="ord_excel" >xls</button>
                                            <input type="hidden" name="identificador" id="identificador" value="{{ $o->identificador }}" placeholder="">
                                            <input type="submit" name="pdf_novedades" value="Nov" class="btn btn-warning pull-left novedades" lang="{{$o->identificador}}" />                                    
                                   </form>
                                    <form action="elimina_orden" method="POST" accept-charset="utf-8" onsubmit="return confirm('Esta seguro de eliminar??')" >
                                        {{ csrf_field() }}
                                        <input type="hidden" name="identificador" id="identificador" value="{{ $o->identificador }}" placeholder="">
                                            <button name="del_ord" class="btn btn-danger" value="Del"><i class="fa fa-trash"></i></button>
                                    </form>        
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

 
                  <table id="tbl_orden" class="table table-striped table-bordered table-hover table-sm">
                   <caption>
                                      <table class="" style="" id="tbl_nueva_orden">
                                        <thead>
                                            <tr>
                                                <th colspan="6" class="text-center" >Agregar Nueva Orden</th>
                                            </tr>
                                          <tr>
                                              <td><input id="est_cedula" type="text" class="form-control" style="width:100px !important " placeholder="Cedula" list="lst_productos" ></td>
                                              <td>
                                                  {{ Form::button("<i class='fa fa-search ' ></i>", array('class' => 'btn btn-primary pull-left','id'=>'btn_buscar')) }}
                                              </td>
                                              <td><input id="estudiante" disabled type="text" class="form-control" style="width:500px !important " ></td>
                                              <td><input id="codigo" type="text" class="form-control" placeholder="Codigo" style="width:100px !important " ></td>
                                              <td>
                                               <input type="hidden" id="datos" value=""  >
                                               <input id="valor_est" type="text" class="form-control" placeholder="Valor" style="width:100px !important " >
                                           </td>
                                           <td><input id="motivo"  type="text" class="form-control" placeholder="Motivo" style="width:250px !important " ></td>
                                           <td>
                                            <button class="btn btn-success" id="btn_add">+</button>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                    </caption>
                        <thead>
                            <tr>
                                <th colspan="5">
                                    <div class="input-group "> 
                                        <span class="input-group-addon">BUSCAR EN LISTA</span>
                                        <input id="entradafilter" type="text" style="width:200px !important " class="form-control">
                                    </div>                                    
                                </th>
                                <th colspan="4"><h4>Orden No:</h4></th>                                
                                <th>
                                    <button class="btn btn-success" id="btn_back">Atras</button>
                                </th>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>JORNADA</th>
                                <th>ESPECIALIDAD</th>
                                <th>CURSO</th>
                                <th>PARALELO</th>
                                <th>CEDULA</th>
                                <th>ESTUDIANTE</th>
                                <th>CODIGO</th>                                
                                <th>VALOR</th>                                
                                <th>MOTIVO</th>
                            </tr>
                        </thead>
                        <tbody class="contenidobusqueda">
                        </tbody>
                    </table>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>

$(document).ready(function () {
   $('#entradafilter').keyup(function () {

      var rex = new RegExp($(this).val(), 'i');
        $('.contenidobusqueda tr').hide();
        $('.contenidobusqueda tr').filter(function () {
            return rex.test($(this).text());
        }).show();
        })
});  


    $(function(){

        $("#btn_generar").click(function() {
            var url = window.location;
            var dt=$('#tipo').val()+'_'+$('#mes').val()+'_'+$('#jor_id').val()+'_'+$('#opcion').val();

                    $.ajax({
                        url: url + "/genera_ord/"+dt,
                        type: 'GET', 
                        dataType: 'json',
                        beforeSend: function () {
                        },
                        success: function (datos) {
                    if($.isNumeric(datos)){
                        if(datos==0){
                            alert('Algun Error al guardar Intentelo de nuevo porfavor');
                        }else if(datos==1){
                            alert('Orden ya fue generada');
                        }
                    }else{
                        var nFilas = $("#tbl_ordenes tr").length;
                        data='<tr><td>'+nFilas+'</td><td>'+
                        datos['obs']+'</td><td>'+
                        datos['identificador']+
                        '</td><td><input type="submit" id="vista" value="Ver" class="btn btn-danger" lang='+datos['identificador']+' /> </td>'+
                        ''
                        '</tr>';
                    }
                    $('#tbl_ordenes tbody').append(data);
                }
            });
        });

        $("#btn_buscar").click(function() {
            var url = window.location;
            $.ajax({
                url: url + "/busca_est/"+$("#est_cedula").val(),
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                    },
                    success: function (datos) {
                        est=datos[0]['est_apellidos']+" "+datos[0]['est_nombres'];
                        dat=datos[0]['jor_descripcion']+" - "+datos[0]['esp_descripcion']+" - "+datos[0]['cur_descripcion']+" - "+datos[0]['mat_paralelo'];
                        $('#estudiante').val(est +" "+dat);
                        ord=$("#datos").val();
                        $("#datos").val(datos[0]['mat_id']+"&"+ord);
                        // $('#estudiante h4').text(dat);

                    }
                });

        });

    })

        $(document).on('click', '.vista', function () {
            var url = window.location;
            lg=this.lang;

            $("#datos").val(lg);

            $.ajax({
                url: url + "/busca_orden/"+lg,
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                    },
                    success: function (datos) {
                            rw="";
                            x=0;
                        $(datos).each(function() {
                            cod=datos[x]['codigo'];
                            motivo=datos[x]['motivo'];
                            if(datos[x]['motivo']==null){
                                motivo="&nbsp";
                            }
                            rw+="<tr><td>"+(x+1)+"</td>"+
                            "<td>"+datos[x]['jor_descripcion']+"</td>"+
                            "<td>"+datos[x]['esp_descripcion']+"</td>"+
                            "<td>"+datos[x]['cur_descripcion']+"</td>"+
                            "<td>"+datos[x]['mat_paralelot']+"</td>"+
                            "<td>"+datos[x]['est_cedula']+"</td>"+
                            "<td>"+datos[x]['est_apellidos']+" "+datos[x]['est_nombres']+"</td>"+
                            "<td>"+datos[x]['codigo']+"</td>"+
                            "<td>"+
                                "<input size='2' id="+datos[x]['ord_id']+" maxlength='4' type='text' value="+datos[x]['valor']+" class='txt_valor form-control'  />"+
                            "</td>"+
                            "<td>"+
                                "<input type='text' value='"+motivo+"'  class='txt_motivo form-control'  />"+
                            "</td>"+
                            "<td style='width:80px'>"+
                                "<i class='fa fa-floppy-o btn_update_valor ' ></i>"+
                                "<i class='fa fa-minus-circle btn_del_est' ></i>"+
                            "</td>"+

                            "</tr>";
                            x++;                            
                        })

                    $('#tbl_orden tbody').html(rw);
                    $( "#tbl_orden" ).show();
                    $( "#tbl_ordenes" ).hide();
                    
                    $('#tbl_orden thead h4').html("Orden No: "+lg);

                    }
                });

        });

        $(document).on('click', '.btn_update_valor', function () {
            url=window.location;
             obj=$(this).parent().parent().find(".txt_valor");
             mot=$(this).parent().parent().find(".txt_motivo");
             dt=$(obj).attr('id')+"&"+$(obj).val()+"&"+$(mot).val();

//alert($.trim($(mot).val()))

            $.ajax({
                url: url + "/update_orden/"+dt,
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {

                        if(isNaN(parseFloat(obj.val()))){
                            alert("Valor incorrecto");
                            return false;
                        }

                        
                    },
                    success: function (datos) {
                        if(datos!=0){
                            alert("Algun error ha ocurrido");
                        }else{
                            alert("Guardado Correctamente");
                        }

                    }
                });

        });

        $(document).on('click', '.btn_del_est', function () {
            url=window.location;
                tr=$(this).parent().parent();
                obj=$(this).parent().parent().find(".txt_valor");
                dt=$(obj).attr('id')+"&"+$(obj).val();
             if(confirm("Esta seguro de eliminar?")){

            $.ajax({
                url: url + "/delete_este/"+dt,
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {

                    },
                    success: function (datos) {
                        if(datos!=0){
                            alert("Algun error ha ocurrido");
                        }else{
                            alert("Eliminado Correctamente");
                            tr.remove();
                        }
                    }
                });

        }

        });

        $(document).on('click', '#btn_add', function () {
            url=window.location;
            var dat=$("#datos").val()+"&"+$("#valor_est").val()+"&"+$("#codigo").val()+"&"+$("#motivo").val();

            $.ajax({
                url: url + "/add_est/"+dat,
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                    },
                    success: function (datos) {
                        if(datos!=0){
                            alert("Algun error ha ocurrido");
                        }else{
                            alert("Insertado Correctamente");
                        }
                    }
                });
        });

        $(document).on('click', '#btn_back', function () {
            $( "#tbl_orden" ).hide();
            $( "#tbl_ordenes" ).show();
        })


        $(document).on('click', '#btn_search_est', function () {
            var url = window.location;
            if($("#est_estudiante").val().length<3){
                alert('Escriba Cedula/Nombres/Apellidos del Estudiante');
            }else{           
                var meses="<select class='form-control' >"+ 
                "<option value='S'>Septiembre</option>"+
                "<option value='O'>Octubre</option>"+
                "<option value='N'>Noviembre</option>"+
                "<option value='D'>Diciembre</option>"+
                "<option value='E'>Enero</option>"+
                "<option value='F'>Febrero</option>"+
                "<option value='MZ'>Marzo</option>"+
                "<option value='A'>Abril</option>"+
                "<option value='MY'>Mayo</option>"+
                "<option value='J'>Junio</option>"+
                "<option value='JL'>Julio</option>"+
                "<option value='AG'>Agosto</option>"+
                "</select>"; 
          
                $.ajax({
                url: url + "/busca_varios_est/"+$("#est_estudiante").val(),
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {

                    },
                    success: function (dat) {
                        var resp="<table class='table'>";
                        var c=0;
                        $(dat).each(function(){
                            var est=$(this);
                            c++;
                            resp+="<tr>"+
                            "<td>"+c+"</td>"+
                            "<td>"+est[0]['jor_descripcion']+"</td>"+
                            "<td>"+est[0]['cur_descripcion']+" "+est[0]['mat_paralelo']+"</td>"+
                            "<td>"+est[0]['est_apellidos']+" "+est[0]['est_nombres']+"</td>"+
                            "<td><input type='text' class='form-control' size='5' id='valor' placeholder='Valor'></td>"+
                            "<td><input type='text' class='form-control' id='motivo' placeholder='Motivo'></td>"+
                            "<td><button class='btn btn-success btn_add_ind' data-dismiss='modal' data='"+est[0]['mat_id']+"' >+</button></td>"+
                            "</tr>";
                        })
                        resp+="</table>";
                        
                        $("#lst_estudiantes").html(resp);

                    }
                }); 

            }
        })

        $(document).on('click', '#btn_genera_independiente', function () {

            url=window.location;
            $.ajax({
                url: url + "/ord_independiente",
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                    },
                    success: function (datos) {
                        $("#ord_name").val("ORD-IND-"+datos[1]);
                        $("#ord_identificador").val(datos[0]);
                        $("#tbl_independiente").show("slow");
                        $("#tbl_ordenes").hide();
                        
                    }
                });            

        })

        $(document).on('click', '#btn_close', function () {
            $("#tbl_independiente").hide("slow");
            $("#tbl_ordenes").show();
        })        

        $(document).on('click', '#finaliza_ind', function () {
            $("#tbl_independiente").hide("slow");
            $("#tbl_ordenes").show();
        })        

        $(document).on('click', '.btn_add_ind', function () {
            var obj=$(this).parent().parent();

            var mes=$("input[name=mes]").val();
            var tipo=$("input[name=tipo]").val();

            var valor=obj.find("#valor").val();
            var motivo=obj.find("#motivo").val();

             url=window.location;
             var dat=$(this).attr('data')+"&"+$("#ord_name").val()+"&"+$("#ord_identificador").val()+"&"+codigo+"&"+valor+"&"+motivo;
           $.ajax({
                url: url + "/add_est_ord_ind/"+dat, //OrdenesPensionController@add_est_ord_ind
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                    },
                    success: function (datos) {
                            rw="";
                            x=0;
                        $(datos).each(function() {
                            cod=datos[x]['codigo'];
                            motivo=datos[x]['motivo'];
                            if(datos[x]['motivo']==null){
                                motivo="&nbsp";
                            }
                            rw+="<tr><td>"+(x+1)+"</td>"+
                            "<td>"+datos[x]['jor_descripcion']+"</td>"+
                            "<td>"+datos[x]['esp_descripcion']+"</td>"+
                            "<td>"+datos[x]['cur_descripcion']+"</td>"+
                            "<td>"+datos[x]['mat_paralelot']+"</td>"+
                            "<td>"+datos[x]['est_cedula']+"</td>"+
                            "<td>"+datos[x]['est_apellidos']+" "+datos[x]['est_nombres']+"</td>"+
                            "<td>"+datos[x]['codigo']+"</td>"+
                            "<td>"+
                                "<input size='2' id="+datos[x]['ord_id']+" maxlength='4' type='text' value="+datos[x]['valor']+" class='txt_valor form-control'  />"+
                            "</td>"+
                            "<td>"+
                                "<input type='text' value='"+motivo+"'  class='txt_motivo form-control'  />"+
                            "</td>"+
                            "<td style='width:80px'>"+
                                "<i class='fa fa-floppy-o btn_update_valor ' ></i>"+
                                "<i class='fa fa-minus-circle btn_del_est' ></i>"+
                            "</td>"+

                            "</tr>";
                            x++;                            
                        })

                        $("#tbl_independiente tbody").html(rw);
                    }
                });
        });



    </script>
@endsection

