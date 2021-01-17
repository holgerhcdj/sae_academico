@extends('layouts.app')

@section('content')
<?php
if(isset($_POST['btn_search'])){
$fd=$_POST['desde'];
$fh=$_POST['hasta'];
}else{
    $fd=date('Y-m-d');
    $fh=date('Y-m-d');
}
?>
    <section class="content-header">
        <h1 class="bg-primary text-center">
            Reporte Estadístico de Trámites Atendidos
        </h1>
    </section>

<script>
    $(document).on("click",".btn_trm_atrasados",function () {
        $("#dt_atrasados").text($(this).attr("data"));
    });
</script>

<!-- Modal -->
<div class="modal fade" id="modal_tramites" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tramites</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id='dt_atrasados'>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <form action="reporte_tramites" method="POST">
                        {{csrf_field()}}
                        <table class="table" border="0" >
                            <tr>
                                <td></td>
                                <td>
                                    <label for="desde">Desde</label>
                                    <input type="date" id="desde" name="desde" class="form-control" value="{{old('desde',$fd)}}">
                                </td>
                                <td>
                                    <label for="hasta">Hasta</label>
                                    <input type="date" id="hasta" name="hasta" class="form-control" value="{{old('hasta',$fh)}}">
                                </td>
                                <td>
                                    <button style="margin-top:25px " class="btn btn-primary fa fa-search" name="btn_search" value="search"> Buscar</button>
                                </td>
                                <td>
                                    <!-- <button class="btn btn-primary fa fa-print" name="btn_print" value="print"> Imprimir</button> -->
                                </td>
                            </tr>
                            <tr style="background:#009EC0;color:white  ">
                                <th style="width:20px ">No</th>
                                <th style="width:200px ">Persona</th>
                                <th class="text-center" style="width:100px ">T.Recibido</th>
                                <th class="text-center" style="width:100px ">T.A tiempo</th>
                                <th class="text-center" style="width:100px ">T.Atrasados</th>
                                <th class="text-center" style="width:100px ">T.No Atendido</th>
                                <th class="text-center" style="width:100px" class="text-center">%Efectividad</th>
                            </tr>
                            {!!$tramites!!}

                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
