@extends('layouts.app')

@section('content')

    <script>
        $(document).on("click",".btn_printer",function(){

            window.print();

        })
        $(document).on("click",".btn_detalle_encuesta",function(){
            us=$(this).attr('usu_id');
            $("#titulo").text($(this).attr('usu_name'));
            $("#tgeneral").text($(this).attr('tot_gen_por')+"%");
            var token=$("input[name=_token]").val();
            var url=window.location;
                $.ajax({
                    url:url+'/load_detalle_encuesta',
                    headers:{'X-CSRF-TOKEN':token},
                    type: 'POST',
                    dataType: 'json',
                    data: {us:us},
                    beforeSend:function(){
                    Swal.showLoading()
                },
                success:function(dt){

                    $("#mdl_detalle_encuesta").modal("show");
                    $("#rst_datos").html(dt);
                    Swal.hideLoading()

                    

                }
            })            


        })


    </script>

<style>
    body {
      font-family: "Ubuntu", "Trebuchet MS", sans-serif;
    }
    table {
      border-collapse: collapse;
    }
    th, td {
      padding: 5px 10px;
      border: 1px solid #999;
      font-size: 12px;
    }
    th {
      background-color: #eee;
    }

    @media print{

        .btn_detalle_encuesta{
            display:none;
        }
        #ttl_table{
            display:block; 
            background:#000;
            color:white;
        }

    }

/*@media screen {
  #printSection {
      display: none;
  }
}*/

/*@media print {
  body * {
    visibility:hidden;
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    position:absolute;
    left:0;
    top:0;
  }
}*/


</style>

    <section class="content-header" >
    <div class="bg-primary text-center" style="padding:5px">
        Reporte de Evaluación por Docente
        <i class=" btn-default fa fa-print pull-right btn-xs btn_printer" style="padding:3px "> Imprimir</i>
    </div>
    </section>
    <div class="content" >

            <div class="box-body"  >
                <div class="row" style="padding-left: 20px">
                    <div id="ttl_table" hidden style="padding:3px;">REPORTE DE EVALUACIÓN POR DOCENTE</div>
                    <table class="table-hover tbl_table" >
                        <thead>
                            <th>#</th>
                            <th>Docente</th>
                            <th style="width:50% !important">% Resultado</th>
                            <th>Detalle</th>
                        </thead>
                        <tbody id="tbl_datos">
                            {!!html_entity_decode($rst)!!}
                        </tbody>
                    </table>
                </div>
            </div>

    </div>

<div class="modal fade" id="mdl_detalle_encuesta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:75%">
    <div class="modal-content">
      <div class="modal-header">
        <div style="background:#3A4E57;color:white;padding:5px;border-radius:2px;  " >  
                <span id="titulo"></span>
                <button type="button" class="btn btn-danger btn-xs pull-right" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
                Total Obtenido: <span id="tgeneral" class="text-black" style="font-size:16px;font-weight:bolder;padding:3px;" ></span>                
      </div>
      <div class="modal-body" id="rst_datos">
        
      </div>
    </div>
  </div>
</div>

@endsection
