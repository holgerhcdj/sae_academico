@extends('layouts.app')

@section('content')
<script>
          $(document).on("click","#btn_buscar",function(){
           var token=$("input[name=_token]").val();
           var jor=$("select[name=jor_id]").val(); 
           var esp=$("select[name=esp_id]").val(); 
           var mtr=$("select[name=mtr_id]").val(); 
           var parcial=$("select[name=parcial]").val(); 
           
           $.ajax({
            url: 'repingreso.reporte',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {jor:jor,esp:esp,mtr:mtr,parcial:parcial},
            beforeSend:function(){
              $(".bloqueo").css('visibility', 'visible'); 
              $("#cont_tot_reg").hide();
              $("#cont_graficos").hide();

            },
            success:function(dt){

              $("#tbody_datos").html(dt);

              $("#cont_tot_reg").show();
              $("#cont_graficos").show();

              var tcur=$('.cursos').length;//Toal Cursos
              var tfl=$('.faltantes').length;//Total Faltante
              var treg=parseInt(tcur-tfl);//Total registrados
              var preg=(treg*100/tcur);//Porcentaje Registrados
              $(".bloqueo").css('visibility', 'hidden');                            
              grafico_ingreso_notas(tcur,treg);
              //$("#tot_reg").text((preg.toFixed(2))+' %'+' / '+treg);
              $("#tot_reg").text(treg+' / '+tcur+'   ('+preg.toFixed(2)+' %)');
              var my7=$(".mayor7").length;//Tot Mayor a 7
              var my5=$(".mayor5").length;//Tot Mayor a 5 y Menor 7
              var men5=$(".menor5").length;//Tot Menor 5
              var por_my7=((my7*100)/treg).toFixed(1);//Porcentaje Mayor a 7
              $("#txt_mayor7").html('<b>'+my7+'</b>/'+treg+' ('+por_my7+' %)');
              $("#bar_mayor7").css('width',por_my7+'%');

              var por_my5=((my5*100)/treg).toFixed(1);//Porcentaje Mayor a 5
              $("#txt_mayor5").html('<b>'+my5+'</b>/'+treg+' ('+por_my5+' %)');
              $("#bar_mayor5").css('width',por_my5+'%');

              var por_men5=((men5*100)/treg).toFixed(1);//Porcentaje Menor 5
              $("#txt_menor5").html('<b>'+men5+'</b>/'+treg+' ('+por_men5+' %)');
              $("#bar_menor5").css('width',por_men5+'%');


            }
          })
         })
          $(document).on("change","select[name=esp_id]",function(){

           var token=$("input[name=_token]").val();
           var esp=$(this).val(); 

           $.ajax({
            url: 'busca_materia_especialidad',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {esp:esp},
            beforeSend:function(){

            },
            success:function(dt){
              $("select[name=mtr_id]").html(dt);
            }
          })   
         })
          $(document).on("click",".btn_ver_insumos",function(){
            var obj=$(this).parent();
            $(obj).submit()
          })

        function grafico_ingreso_notas(tcur,treg){
                var cnv_reg     = $('#graf_t_reg').get(0).getContext('2d');
                var grf_reg    = new Chart(cnv_reg);
                var dt       = [
                {value: tcur,color: '#eee',highlight: '#eee',label: 'Total de Cursos'},
                {value: treg,color: '#9ac18a',highlight: '#9ac18a',label: 'Total Registrados'}];
                var op     = {
                  percentageInnerCutout: 50, // This is 0 for Pie charts
                  animationSteps       : 20,
                  animationEasing      : 'linear',
                  animateRotate        : true,
                  animateScale         : true,
                  responsive           : true
               };
               grf_reg.Doughnut(dt,op);

        }      

$(document).on("click",".btn_rep",function(){
  var tp=$(this).attr('data');
  if(tp==0){
    ins=$(this).attr('ins');
  }else{
    ins=$('input[name=ins_general]:checked').val();
  }
      $('#tipo').val(tp);
      $('#jor').val($("select[name=jor_id]").val());
      $('#esp').val($("select[name=esp_id]").val());
      $('#cur').val($(this).attr('cur'));
      $('#par').val($(this).attr('par'));
      $('#blq').val($("select[name=parcial]").val());
      $('#ins').val(ins);
   $("#frm_rep_insumos").submit();
})

$(function(){
  $("select[name=esp_id]").val(10);
})
</script>
<style>
  #tbl_reporte tr th,#tbl_reporte tr td{
    border:solid 1px #ccc;
  }
  .bloqueo{
    background:rgba(245, 245, 245, 0.4);
    position:absolute;
    width:83%;
    height:85%;
    z-index:9999;
    text-align:center;
    visibility:hidden; 
  }
  .bloqueo img{
    width: 120px;
    margin-top:10%; 
  }  
  .btn_ver_insumos{
    cursor:pointer; 
  }
#tbl_reporte tr td{
  padding:1px 5px 1px 5px;
}
.rotate_tx{
/*    writing-mode: vertical-rl;*/
/*    transform: rotate(180deg);*/
}

.novedades label{
  border-bottom:3px solid #fada05; 
}
.mayor7{
  color:#026739;
}
.menor5{
  color:brown; 
}
.mayor5{
  color:#f39c12; 
}
.falantes{
  color:red;
/*  background:red !important; */
}
.btn_rep{
  cursor:pointer; 
}
.btn_rep:hover{
  background:black; 
  color:white;
}
.active{
  background:#055A96 !important; 
  color:white !important; 
}
</style>
{{csrf_field()}}
    <section class="content-header">
        <h1>
            Reporte general de ingreso de insumos (Notas)
        </h1>
   </section>
    <div class="bloqueo">
        <img src="{{asset('img/loading.gif')}}" class="user-image" alt="User Image"/>
    </div>

    <form action="reporte_insumos" method="POST" id="frm_rep_insumos" target="_blank" hidden  >
      {{csrf_field()}}
      <input type="text" name="tipo" id="tipo" value="">
      <input type="text" name="jor" id="jor" value="">
      <input type="text" name="esp" id="esp" value="">
      <input type="text" name="cur" id="cur" value="">
      <input type="text" name="par" id="par" value="">
      <input type="text" name="blq" id="blq" value="">
      <input type="text" name="ins" id="ins" value="">
    </form>

<div class="content">
   <div class="clearfix"></div>
    <div class="clearfix"></div>
          <table class="table ">
            <tr>
              <td>
               {!! Form::select('jor_id',$jor,null, ['class' => 'form-control']) !!}
              </td>
              <td>
               {!! Form::select('esp_id',$esp,null, ['class' => 'form-control']) !!}
             </td>
             <td>
              {!! Form::select('mtr_id',$materiac,null, ['class' => 'form-control','id'=>'mtr_id']) !!}
             </td>
             <td>
               {!! Form::select('parcial',[
               '1'=>'Parcial 1',
               '2'=>'Parcial 2',
               '3'=>'Parcial 3',
               '4'=>'Parcial 4',
               '5'=>'Parcial 5',
               '6'=>'Parcial 6',
               ],null, ['class' => 'form-control']) !!}
             </td>             
             <td>
               <button type="submit" class="btn btn-primary" id="btn_buscar">
                 Buscar
               </button>
             </td>
            </tr>
          </table>

        <div class="table-responsive" style="background:#fff ">
                    <?php $paralelo = "A";?>
                <table border="0" id="tbl_reporte" >

                  <tr>
                    <th colspan="51" class="text-center bg-info">TABLA GENERAL</th>
                  </tr>
                  <tr class="bg-info">
                    <th rowspan="2">Curso/Paralelo/Insumo</th>
                    <?php $paralelo = "A";?>
                    @for ($i =0; $i < 7; $i++)
                    <th colspan="6" class="text-center">{{$paralelo++}}</th>
                    @endfor
                  </tr>
                  <tr>
                    <?php $paralelo = "A";?>
                    @for ($i =0; $i < 7; $i++)
                      <td ><span class="rotate_tx">1</span></td>
                      <td ><span class="rotate_tx">2</span></td>
                      <td ><span class="rotate_tx">3</span></td>
                      <td ><span class="rotate_tx">4</span></td>
                      <td ><span class="rotate_tx">5</span></td>
                      <td class="text-danger"><span class="rotate_tx">6</span></td>
                    @endfor                    
                  </tr>
                  <tbody id="tbody_datos">
                    @foreach($cur as $c)
                    <tr>
                    <td>{{$c->cur_descripcion}}</td>
                    <?php $paralelo = "A";?>
                      @for ($j =0; $j < 7; $j++)
                        <td ><i class="btn-xs btn_rep btn-default" data='0' cur='{{$c->id}}' par='{{$paralelo}}' ins='1' title="{{$c->cur_descripcion.' '.$paralelo.' insumo 1'}} " >-</i></td>
                        <td ><i class="btn-xs btn_rep btn-default" data='0' cur='{{$c->id}}' par='{{$paralelo}}' ins='2' title="{{$c->cur_descripcion.' '.$paralelo.' insumo 2'}} " >-</i></td>
                        <td ><i class="btn-xs btn_rep btn-default" data='0' cur='{{$c->id}}' par='{{$paralelo}}' ins='3' title="{{$c->cur_descripcion.' '.$paralelo.' insumo 3'}} " >-</i></td>
                        <td ><i class="btn-xs btn_rep btn-default" data='0' cur='{{$c->id}}' par='{{$paralelo}}' ins='4' title="{{$c->cur_descripcion.' '.$paralelo.' insumo 4'}} " >-</i></td>
                        <td ><i class="btn-xs btn_rep btn-default" data='0' cur='{{$c->id}}' par='{{$paralelo}}' ins='8' title="{{$c->cur_descripcion.' '.$paralelo.' insumo 5'}} " >-</i></td>
                        <td ><i class="btn-xs btn_rep btn-default" data='0' cur='{{$c->id}}' par='{{$paralelo}}' ins='12' title="{{$c->cur_descripcion.' '.$paralelo.' insumo 6'}} " >-</i></td>
                        <?php $paralelo++?>
                      @endfor                    
                    </tr>
                    @endforeach                    
                  </tbody>
                </table>

<!-- GRAFICO ASISTENTES -->
        <div class="col-md-3" id="cont_tot_reg"  hidden>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registrados: 
                <span style="font-weight:bolder;" class="text-success" id="tot_reg" ></span>
              </h3>
              <br>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="graf_t_reg" style="height:250px"></canvas>
              </div>
            </div>
          </div>
        </div>
<!-- ********************* -->     


                <div class="col-md-4" id="cont_graficos" hidden>
                  <p class="text-center">
                    <strong>CONSOLIDADOS DE PROMEDIOS</strong>
                  </p>

                  <div class="progress-group">
                    <span class="progress-text">(>7)</span>
                    <span class="progress-number" id="txt_mayor7" ></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-green" id="bar_mayor7" ></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">(>=5 y <7)</span>
                    <span class="progress-number" id="txt_mayor5"></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-yellow" id="bar_mayor5" ></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                  <div class="progress-group">
                    <span class="progress-text">(<5)</span>
                    <span class="progress-number" id="txt_menor5"></span>
                    <div class="progress sm">
                      <div class="progress-bar progress-bar-red" id="bar_menor5"></div>
                    </div>
                  </div>
                  <!-- /.progress-group -->
                </div>

 </div>
<div class="row alert" style="border:solid 1px #ccc;margin-top:5px;width:90%;background:white;border-radius:5px;margin-left:1px;      ">
  <div class="col-sm-12 text-center" style="border-bottom:solid 1px #ccc;margin-bottom:10px;">
    <label class=''>REPORTES GENERALES</label>
  </div> 
  <div class="col-sm-8" >
    <i class="btn btn-primary fa fa-user btn_rep" data='1' cur='0' par='0' ins='0'  > Bajo Rendimiento General < 7</i>
    <i class="btn btn-warning fa fa-user btn_rep" data='2' cur='0' par='0' ins='0'> Bajo Rendimiento >=5 y < 7</i>
    <i class="btn btn-danger fa fa-user btn_rep" data='3' cur='0' par='0' ins='0'> Bajo Rendimiento < 5</i>
    <i class="btn btn-default fa fa-user btn_rep" data='4' cur='0' par='0' ins='0'> Sin Nota</i>
  </div>

  <div class="btn-group btn-group-toggle" data-toggle="buttons">
    <label class="btn btn-info active">
      <input type="radio" name="ins_general" value="1" autocomplete="off" checked> Ins-1
    </label>
    <label class="btn btn-info">
      <input type="radio" name="ins_general" value="2" autocomplete="off"> Ins-2
    </label>
    <label class="btn btn-info">
      <input type="radio" name="ins_general" value="3" autocomplete="off"> Ins-3
    </label>
    <label class="btn btn-info">
      <input type="radio" name="ins_general" value="4" autocomplete="off"> Ins-4
    </label>
    <label class="btn btn-info">
      <input type="radio" name="ins_general" value="5" autocomplete="off"> Ins-5
    </label>
    <label class="btn btn-info">
      <input type="radio" name="ins_general" value="6" autocomplete="off"> Ins-6
    </label>
  </div>

</div>  

</div>


   @endsection