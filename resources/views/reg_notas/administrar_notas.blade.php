@extends('layouts.app')

@section('content')
<script>
</script>
<style>
</style>
{{csrf_field()}}
    <section class="content-header">
        <h1>
            Administrar Notas Generales
        </h1>
   </section>
 <script type="text/javascript">
 $(document).on('click','#btn_buscar',function(){

   var token=$("input[name=_token]").val();
   var mat_id=$("select[name=mat_id]").val(); 
   var mtr_id=$("select[name=mtr_id]").val(); 
   var parcial=$("select[name=parcial]").val(); 
   
   $.ajax({
    url: 'busca_notas_generales',
    headers:{'X-CSRF-TOKEN':token},
    type: 'POST',
    dataType: 'json',
    data: {matid:mat_id,mtrid:mtr_id,par:parcial},
    beforeSend:function(){
      //alert(mat_id);
    },
    success:function(dt){
      $("#tbl_reporte").html(dt);
    }
  })

 }) 

$(document).ready(function() {
  $(".estudiante").select2();
});
</script>
{{csrf_field()}}
<div class="content">
   <div class="clearfix"></div>
    <div class="clearfix"></div>
          <table class="">
            <tr>
              <td>
                {!! Form::select('mat_id',$estudiantes,null, ['class' => 'form-control estudiante']) !!}
              </td>
             <td>
              {!! Form::select('mtr_id',$materias,null, ['class' => 'form-control estudiante']) !!}
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
                <table border="0" class="table" id="tbl_reporte" >

                </table>
              </div>
            </div>
   @endsection