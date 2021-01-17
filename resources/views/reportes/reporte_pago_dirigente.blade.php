@extends('layouts.app')

@section('content')
<?php
if(isset($_POST['btn_search'])){
    $dir=$_POST['dir_cor'];
}else{
    $dir=0;
}

?>
    <section class="content-header">
        <h1 class="bg-primary text-center">
            REPORTE DE PAGOS POR DIRIGENTE/COORDINADOR
        </h1>
        <br>
        <form action="buscar_pagos_por_dirigente" method="POST">
            {{csrf_field()}}
            <table>
                <tr>
                    <th style="display:none">
                        Desde:
                    </th>
                    <th style="display:none">
                        <select name="desde" id="desde" class="form-control">
                            <option value="0">Total</option>
                            <option value="1">Matricula</option>
                            <option value="2">Septiembre</option>
                            <option value="3">Octubre</option>
                            <option value="4">Noviembre</option>
                            <option value="5">Diciembre</option>
                            <option value="6">Enero</option>
                            <option value="7">Febrero</option>
                            <option value="8">Marzo</option>
                            <option value="9">Abril</option>
                            <option value="10">Mayo</option>
                            <option value="11">Junio</option>
                        </select>
                    </th>
                    <th>
                        Hasta:
                    </th>
                    <th>
                        <select name="hasta" id="hasta" class="form-control">
                            <!-- <option value="100">Total</option> -->
                            <option value="1">Matricula</option>
                            <option value="2">Septiembre</option>
                            <option value="3">Octubre</option>
                            <option value="4">Noviembre</option>
                            <option value="5">Diciembre</option>
                            <option value="6">Enero</option>
                            <option value="7">Febrero</option>
                            <option value="8">Marzo</option>
                            <option value="9">Abril</option>
                            <option value="10">Mayo</option>
                            <option value="11">Junio</option>
                        </select>
                    </th>
                    <th>
                        <select class="form-control" name="dir_cor" id="dir_cor">
                            <option value="0">Dirigente</option>
                            <option value="1">Coordinador</option>
                            <option value="2">Inspector</option>
                            <option value="3">DECE</option>
                            <option value="4">Secrcetaría</option>
                            <option value="5">Técnico</option>
                        </select>
                    </th>
                    <th>
                        <button class="fa fa-search btn btn-primary" name="btn_search">Buscar</button>
                    </th>
                </tr>
            </table>
        </form>
    </section>

<script>
    $(function(){
        var dir='<?php echo $dir?>';
        $("#dir_cor").val(dir);
    })
    $(document).on("click",".btn_cursos",function(){
        $("#cursos").text($(this).attr("title"));
    })
</script>

<!-- Modal -->
<div class="modal fade cursos_modal"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cursos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id='cursos'>
        
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>



    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <table class="table">
                        <tr>
                            <th colspan="2"></th>
                            <th colspan="4" class="">Jornadas</th>
                        </tr>
                        <tr>
                            <th class="">No</th>
                            <th class="">Tipo</th>
                            <th class="">Docente</th>
                            <th class="">Matutina</th>
                            <th class="">Vespertina</th>
                            <th class="">Noctura</th>
                            <th class="">Semi Pre</th>
                            <th class="">%</th>
                        </tr>
                        {!! $resp !!}
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
