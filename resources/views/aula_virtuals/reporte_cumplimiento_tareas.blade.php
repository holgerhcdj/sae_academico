@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="bg-primary">
            Reporte de cumplimiento de tareas / profesor
        </h1>
   </section>
   <style>
     tbody tr:hover{
      background:#94E1E9;
      cursor:pointer;  
     }
     th,td{
      border:solid 1px #ccc; 
     }
   </style>
   <script>
     $(document).on("click",".barra_tareas",function(){
            us=$(this).attr('usuid');
            var tipo=$("select[name=tar_tipo]").val();
            var token=$("input[name=_token]").val();
                $.ajax({
                    url:"{{route('load_detalle_cumplimiento')}}",
                    headers:{'X-CSRF-TOKEN':token},
                    type: 'POST',
                    dataType: 'json',
                    data: {us:us,tipo:tipo},
                    beforeSend:function(){
                    Swal.showLoading();
                },
                success:function(dt){
                     Swal.hideLoading();
                     $("#mdl_detalle_cumplimineto").modal("show");
                     $("#rst_datos").html(dt);

                }
            })    
     })

     $(document).on("click",".btn_info_cumplimiento",function(){
          us=$(this).attr('usuid');
          tipo=$("select[name=tar_tipo]").val();
          inftp=$(this).attr('info_tipo');
          porc=$(this).attr('porc');
          $("#usu_id").val(us);
          $("#info_tipo").val(inftp);
          $("#tipo").val(tipo);
          $("#porc").val(porc);
           $("#frm_informe_cumplimiento_tareas").submit();


     })


   </script>

  <div class="modal fade" id="mdl_detalle_cumplimineto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document" >
      <div class="modal-content ">
        <div class="modal-header">
          <div style="background:#3A4E57;color:white;padding:5px;border-radius:2px;  " >  
                  <span id="titulo"></span>
                  <button type="button" class="btn btn-danger btn-xs pull-right" data-dismiss="modal" aria-label="Close">&times;</button>
          </div>
                  Total: <span id="tgeneral" class="text-black" style="font-size:16px;font-weight:bolder;padding:3px;" ></span>                
        </div>
        <div class="modal-body" id="rst_datos">
          
        </div>
      </div>
    </div>
  </div>

  <form action="{{route('informe_cumplimiento_tareas')}}" method="POST" id="frm_informe_cumplimiento_tareas">
    {{csrf_field()}}
    <input type="hidden" name="usu_id" id="usu_id">
    <input type="hidden" name="info_tipo" id="info_tipo">
    <input type="hidden" name="tipo" id="tipo">
    <input type="hidden" name="porc" id="porc">

  </form>


   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
            <div class="row table-responsive" class="form-group" style="background:white " >
              <form action="aulaVirtuals_reporte_tareas_recibidas" method="POST" >
                {{ csrf_field() }}
                <div class="col-md-4">
                  <input type="text" name="profe" placeholder="Apellidos / Cedula" class="form-control">
                </div>
                <div class="col-md-2">
                {!! Form::select('tar_tipo',['0'=>'Tarea','1'=>'Evaluacion','3'=>'Tarea/Opcional','4'=>'Proyecto Integrador'],null, ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-6">
                  <button type="submit" name="btn_reporte_cumplimiento_tareas" class="btn btn-primary" value="Reporte" ><i class="fa fa-file-o"></i> Reporte</button>
                  <button type="submit" style="margin-left:20px" name="btn_reporte_cumplimiento_tareas" class="btn btn-success" value="Excel" ><i class="fa fa-file-excel-o"></i> Excel</button>
<!--                   <span class="label label-warning btn fa fa-question-circle pull-right"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{{}}"> </span> -->
                  <span class="label label-success pull-right" style="margin-left:2px;padding:5px;  "> Mayor 70% </span>
                  <span class="label label-warning pull-right" style="margin-left:2px;padding:5px;  "> Mayor 50% y Menor a 70% </span>
                  <span class="label label-danger pull-right" style="margin-left:2px;padding:5px;  "> Menor a 50% </span>

                </div>
              </form>

                <table class="table" style="margin-top:50px " >
                  <thead style="background:#c4dce4 ">
                      <tr>
                        <th>#</th>
                        <th>Profesor</th>
                        <th>Tar.Enviadas</th>
                        <th>Tar.Cumplidas</th>
                        <th>%</th>
                      </tr>
                  </thead>
                  <tbody>
                    {!!$rst!!}
                  </tbody>

                </table>
            </div>
           </div>
       </div>
   </div>
@endsection
