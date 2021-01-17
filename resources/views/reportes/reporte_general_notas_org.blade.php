@extends('layouts.app')

@section('content')
<style>
.rotar {
    writing-mode: vertical-lr;
    transform: rotate(180deg);
    margin-left:40%; 
}   
</style>
<script>
  $(function(){
      var prm_gen=0; var c=0;
    $(".promedio").each(function(){
      var mtr='m'+$(this).attr('id');
      var t=0;
      c++;
          $("td[mtr_id="+mtr+"]").each(function(){
            t+=parseFloat($(this).text());
          });
      var prm=(t/$("#tot_est").val());
      $(this).text((prm).toFixed(2));    
      prm_gen+=parseFloat(prm);
    });
    $("#prom_final").text((prm_gen/c).toFixed(2));
  })
  $(document).on("submit","#frm_datos",function(){
    if($("#opcion").val()==1){
       $("#datos_excel").val( $("#tbl_datos").html() );
    }
  })
</script>
<style>
  .active{
    color:brown !important;  
    font-weight:bolder; 
  }
</style>
    <section class="content-header">
        <h1 class="bg-primary text-center" >Reporte General de Notas</h1>
<form action="reporte_general_notas" method="POST" id="frm_datos" >
  {{csrf_field()}}
            <div class="btn-group" data-toggle="buttons">
              <label class="btn btn-default active ">
                <input type="radio" name="options" id="parciales" value="0" autocomplete="off" checked="">Promedio Parciales
              </label>
              <label class="btn btn-default ">
                <input type="radio" name="options" id="insumos" value="1" autocomplete="off"> Mostrar Insumos
              </label>
<!--               <label class="btn btn-default ">
                <input type="radio" name="options" id="option3" autocomplete="off"> Radio 3
              </label>
 -->            </div>

        <div class="input-group">
          <span class="input-group-addon">
            <input type="hidden" id="datos_excel" name="datos_excel"  >
            <input type="hidden" id="opcion" name="opcion" >
            {!! Form::select('jor_id',$jor,null, ['class' => 'form-control']) !!}
          </span>  
          <span class="input-group-addon">
            {!! Form::select('esp_id',$esp,null, ['class' => 'form-control']) !!}
          </span>
          <span class="input-group-addon">
            {!! Form::select('cur_id',$cur,null, ['class' => 'form-control']) !!}
          </span>  
          <span class="input-group-addon">
            {!! Form::select('paralelo',[
            'A'=>'A',
            'B'=>'B',
            'C'=>'C',
            'D'=>'D',
            'E'=>'E',
            'F'=>'F',
            'G'=>'G',
            'H'=>'H',
            'I'=>'I',
            'J'=>'J',
            ],null, ['class' => 'form-control']) !!}
          </span>  
          <span class="input-group-addon">
            {!! Form::select('periodo',[
            '1'=>'Parcial 1',
            '2'=>'Parcial 2',
            '3'=>'Parcial 3',
            'Q1'=>'Primer Quimestre',
            '4'=>'Parcial 4',
            '5'=>'Parcial 5',
            '6'=>'Parcial 6',
            'Q2'=>'Segundo Quimestre',

            ],null, ['class' => 'form-control']) !!}
          </span>          
          <span class="input-group-addon">
            <button class="btn btn-primary" name="btn_buscar" onclick="opcion.value=0" value="btn_buscar">Buscar</button>
            <button class="btn btn-success" name="btn_buscar" onclick="opcion.value=1" value="btn_excel">Excel</button>
          </span>
        </div>
</form>        
   </section>
   <div class="content">
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                <table class="table table-hover" id="tbl_datos" style="width:auto; ">
                  <tr>
                    <th>#</th>
                    <th>Estudiante</th>
                  @foreach($materias as $m)
                  <th class="rotar text-right">{{$m->mtr_descripcion}}</th>
                  @endforeach
                  <th class="rotar text-right bg-info">Prom</th>
                  </tr>
                  <?php $x=1?>
                  @foreach($datos as $d)
                  <tr>
                    <td>{{$x++}}</td>
                    <td>{{$d->estudiante}}</td>
                    <?php $c=1;$prm=0;$prm_m=0;?>
                    @foreach($materias as $m)
                    <?php 
                      $tx='m'.$c++;
                      $nota=number_format($d->$tx,2);
                      $prm+=$nota;
                      $cls='';
                      if($nota<7 && $nota>=5){
                        $cls='bg-yellow';
                      }
                      if($nota<5){
                        $cls='bg-red';
                      }
                    ?>
                      <td class="text-right {{$cls}}" mtr_id="{{'m'.$m->mtr_id}}">
                        {!! $nota !!}
                      </td>
                    @endforeach
                    <?php
                        if(($c-1)>0){
                          $prm_m=number_format(($prm/($c-1)),2);
                        }
                    ?>
                    <td class="bg-info">{{$prm_m}}</td>
                  </tr>
                  @endforeach
                  <tr>
                    <th colspan="2" class="text-right">
                      <input type="hidden" id="tot_est" value="{{$x-1}}">
                      Promedio:
                    </th>
                      @foreach($materias as $m)
                            <th class="promedio" id="{{$m->mtr_id}}" ></th>
                      @endforeach
                            <th id="prom_final"></th>
                  </tr>
                </table>
               </div>
           </div>
       </div>
   </div>
@endsection