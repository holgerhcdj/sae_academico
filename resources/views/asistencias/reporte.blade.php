@extends('layouts.app')

@section('content')
<?php
$f=date('Y-m-d');
?>

    <section class="content-header">
        <h1>
            Reporte de Asistencias
        </h1>
    </section>
    <script>
      $(function(){
        jor=$('select[name=esp_id]').val(10);
      })
        $(document).on('click','#btn_buscar_excel',function (){
          $("#datos").val($("#tbl_reporte").html());
          $("#dt_est").val($("#test").html());
          $("#dt_ast").val($("#ast").html());
          $("#dt_flt").val($("#flt").html());
          $("#dt_atr").val($("#atr").html());
          $("#datos_tbl").val($("#tbl_datos").html());

          $("#frm_asistencia_reporte").submit();
             

        })
        $(document).on('click','#btn_buscar',function (){
            token=$('input[name=_token]').val(); 
            var jor=$('select[name=jor_id]').val();
            var esp=$('select[name=esp_id]').val();
            var f=$('input[name=fecha]').val();

           $.ajax({
            url: 'busca_asistencias',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {esp:esp,jor:jor,fecha:f},
            beforeSend:function(){
             Swal.showLoading()

            },
            success:function(dt){
              Swal.close();

                $("#tbody_datos").html(dt);
                    var ne=0;
                    var na=0;
                    var nf=0;
                    var nat=0;
                    $(".tx_asistencias").each(function(){
                        ne+=parseInt($(this).attr('ne'));
                        na+=parseInt($(this).attr('na'));
                        nf+=parseInt($(this).attr('fl'));
                        nat+=parseInt($(this).attr('at'));
                    });

                    $("#tot_estudiantes").text(ne);

                    grafico_asistencia(ne,na,nf,nat);

                    por_na=(na*100/ne).toFixed(2);
                    $("#tot_asistentes").text(na+" => "+por_na+"%");

                    por_nf=(nf*100/ne).toFixed(2);
                    $("#tot_faltantes").text(nf+" => "+por_nf+"%");

                    por_nat=(nat*100/ne).toFixed(2);
                    $("#tot_atrasados").text(nat+" => "+por_nat+"%");


                }
            })

        })

        function grafico_asistencia(ne,as,fl,at){

                var cnv_ast     = $('#graf_ast').get(0).getContext('2d');
                var grf_ast    = new Chart(cnv_ast);
                var dt       = [
                {value: ne,color: '#ccc',highlight: '#ccc',label: 'Total de estudiantes'},
                {value: as,color: '#00a65a',highlight: '#00a65a',label: 'Asistentes'}];
                var op     = {
                  percentageInnerCutout: 50, // This is 0 for Pie charts
                  animationSteps       : 20,
                  animationEasing      : 'linear',
                  animateRotate        : true,
                  animateScale         : true,
                  responsive           : true
               };
               grf_ast.Doughnut(dt,op);
///////*********************************////////////////////
                var cnv_flt     = $('#graf_faltantes').get(0).getContext('2d');
                var grf_flt    = new Chart(cnv_flt);
                var dt       = [
                {value: ne,color: '#ccc',highlight: '#ccc',label: 'Total de estudiantes'},
                {value: fl,color: '#f39c12',highlight: '#f39c12',label: 'Faltantes'}];
                var op     = {
                  percentageInnerCutout: 50, // This is 0 for Pie charts
                  animationSteps       : 20,
                  animationEasing      : 'linear',
                  animateRotate        : true,
                  animateScale         : true,
                  responsive           : true
               };
               grf_flt.Doughnut(dt,op);
///////*********************************////////////////////
                var cnv_flt     = $('#graf_atrasados').get(0).getContext('2d');
                var grf_flt    = new Chart(cnv_flt);
                var dt       = [
                {value: ne,color: '#ccc',highlight: '#ccc',label: 'Total de estudiantes'},
                {value: at,color: '#6fdada',highlight: '#6fdada',label: 'Atrasados'}];
                var op     = {
                  percentageInnerCutout: 50, // This is 0 for Pie charts
                  animationSteps       : 20,
                  animationEasing      : 'linear',
                  animateRotate        : true,
                  animateScale         : true,
                  responsive           : true
               };
               grf_flt.Doughnut(dt,op);
        }

        $(document).on("click",".btn_busca_novedad",function(){
          $("input[name=jornada]").val($("select[name=jor_id]").val());
          $("input[name=especialidad]").val($("select[name=esp_id]").val());
          $("input[name=materia]").val($("select[name=mtr_id]").val());
          $("input[name=fch]").val($("input[name=fecha]").val());
          $("input[name=tipo]").val($(this).attr('data'));
          $("#frm_busca_novedades").submit();

        })
    </script>

                <form action="busca_asistencias_novedades" hidden target="_blank" method="POST" id="frm_busca_novedades" >
                  {{csrf_field()}}                  
                  <input type="" name="jornada">
                  <input type="" name="especialidad">
                  <input type="" name="materia">
                  <input type="" name="fch">
                  <input type="" name="tipo" >
                </form>                
                <form action="busca_asistencias_reporte" hidden target="_blank" method="POST" id="frm_asistencia_reporte" >
                  {{csrf_field()}}                  
                  <input type="" name="datos" id="datos">
                  <input type="" name="datos_tbl" id="datos_tbl">
                  <input type="" name="dt_est" id="dt_est">
                  <input type="" name="dt_ast" id="dt_ast">
                  <input type="" name="dt_flt" id="dt_flt">
                  <input type="" name="dt_atr" id="dt_atr">
                </form>

    <div class="content">
       <div class="box box-primary">
            <div class="box-body">
                    {{csrf_field()}}
                      <table class="table" id="tbl_datos">
                        <tr>
                          <td>
                           {!! Form::select('jor_id',$jor,null, ['class' => 'form-control']) !!}
                          </td>
                          <td>
                           {!! Form::select('esp_id',$esp,null, ['class' => 'form-control']) !!}
                         </td>
                         <td hidden="">
                           <select name="mtr_id" id="mtr_id" class="form-control">
                             <option value="0">Materia/Modulo</option>   
                           </select>
                         </td>
                         <td>
                             {!! Form::date('fecha',$f,['class' => 'form-control']) !!}
                         </td>
                         <td>
                           <button type="submit" class="btn btn-primary" id="btn_buscar" ><i class="fa fa-search"></i> Buscar</button>
                           <button type="submit" class="btn btn-success" id="btn_buscar_excel" ><i class="fa fa-file-excel-o"></i> Reporte</button>
                         </td>
                        </tr>
                      </table>
                      <div class="table-responsive" style="background:#fff ">

                        <table border="0" id="tbl_reporte" class="table" >
                          <tr class="bg-info">
                            <th rowspan="2">Curso/Paralelo</th>
                            <?php $paralelo = "A";?>
                            @for ($i =0; $i < 7; $i++)
                            <th class="text-center">{{$paralelo++}}</th>
                            @endfor
                          </tr>
                          <tbody id="tbody_datos">

                          </tbody>
                    </table>
<div id="grf_estadisticas">
<!-- CAJA DE INFORMACION -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content" id="test">
              <span class="info-box-text">Total Estudiantes</span>
              <span class="info-box-number" style="font-size:35px " id="tot_estudiantes" ></span>
            </div>
          </div>
        </div>
<!-- ********************* -->
<!-- GRAFICO ASISTENTES -->
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-header with-border" id="ast">
              <h3 class="box-title">Asistentes <span style="font-weight:bolder;" class="text-success" id="tot_asistentes" ></span></h3>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="graf_ast" style="height:250px"></canvas>
              </div>
            </div>
          </div>
        </div>
<!-- ********************* -->
<!-- GRAFICO FALTANTES -->
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-header with-border" id="flt">
              <h3 class="box-title">Faltantes 
                <span style="font-weight:bolder;" class="text-warning" id="tot_faltantes" ></span> 
                                                  <i class="btn btn-primary btn-xs btn_busca_novedad fa fa-share" data='1'></i>
              </h3>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="graf_faltantes" style="height:250px"></canvas>
              </div>
            </div>
          </div>
        </div>
<!-- ********************* -->
<!-- GRAFICO ATRASADOS -->
        <div class="col-md-3">
          <div class="box box-primary">
            <div class="box-header with-border" id="atr">
              <h3 class="box-title">Atrasados 
                <span style="font-weight:bolder;" class="text-success" id="tot_atrasados" ></span>
                <i class="btn btn-primary btn-xs btn_busca_novedad fa fa-share" data='2'></i>
              </h3>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="graf_atrasados" style="height:250px"></canvas>
              </div>
            </div>
          </div>
        </div>
<!-- ********************* -->
 </div>
                </div>
            </div>
        </div>
    </div>
@endsection
