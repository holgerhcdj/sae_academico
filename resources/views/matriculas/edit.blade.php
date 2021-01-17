@extends('layouts.app')

@section('content')
<script>
  $(function() {

            if($("#facturar").val()==1){
                $("#fac_razon_social").attr('readonly',false);
                $("#fac_ruc").attr('readonly',false);
                $("#fac_direccion").attr('readonly',false);
                $("#fac_telefono").attr('readonly',false);
            }else{
                $("#fac_razon_social").attr('readonly',true);
                $("#fac_ruc").attr('readonly',true);
                $("#fac_direccion").attr('readonly',true);
                $("#fac_telefono").attr('readonly',true);
                $("#fac_razon_social").val('');
                $("#fac_ruc").val('');
                $("#fac_direccion").val('');
                $("#fac_telefono").val('');
            }


        $("#save").click(function(){


            if($("#facturar").val()==""){
              alert("Elija Una Opcion de Facturar");
              $("#frm_est").submit(function(e) {
                e.preventDefault();
              });
            }          

          if($("#mat_paralelo").val()=='NINGUNO'){
                  alert('Paralelo Cultural es obligatorio');
                  $("#frm_est").submit(function(e) {
                     e.preventDefault();
                  });

          }else{

             if($("#facturar").val()==1 ){
              if($("#fac_razon_social").val().length==0){
                    $("#fac_razon_social").css('border','solid 1px brown');
                    $("#frm_est").submit(function(e) {
                     e.preventDefault();
                   });
              }else if($("#fac_ruc").val().length==0){
                    $("#fac_ruc").css('border','solid 1px brown');
                    $("#frm_est").submit(function(e) {
                     e.preventDefault();
                   });

              }else if($("#fac_direccion").val().length==0){
                    $("#fac_direccion").css('border','solid 1px brown');
                    $("#frm_est").submit(function(e) {
                     e.preventDefault();
                   });

              }else if($("#fac_telefono").val().length==0){
                    $("#fac_telefono").css('border','solid 1px brown');
                    $("#frm_est").submit(function(e) {
                     e.preventDefault();
                   });

              }else{

                $("#frm_est").submit();
              }

            }else{
                $("#frm_est").submit();
            }

          }


        });
    
        $("#facturar").change(function(e) {
            if($(this).val()==1){
                $("#fac_razon_social").attr('readonly',false);
                $("#fac_ruc").attr('readonly',false);
                $("#fac_direccion").attr('readonly',false);
                $("#fac_telefono").attr('readonly',false);
            }else{
                $("#fac_razon_social").attr('readonly',true);
                $("#fac_ruc").attr('readonly',true);
                $("#fac_direccion").attr('readonly',true);
                $("#fac_telefono").attr('readonly',true);
                $("#fac_razon_social").val('');
                $("#fac_ruc").val('');
                $("#fac_direccion").val('');
                $("#fac_telefono").val('');
            }
        });

  });
</script>
    <section class="content-header">
        <h1>
            Matriculas
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($matriculas, ['route' => ['matriculas.update', $matriculas->id], 'method' => 'patch','id'=>'frm_est']) !!}

                        @include('matriculas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection