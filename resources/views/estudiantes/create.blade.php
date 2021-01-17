@extends('layouts.app')

@section('content')
<script>
    $(function(){

// $("#save").click(function(){
//     if($("#facturar").val()==""){
//         alert("Elija Una Opcion de Facturar");
//         $("#frm_est").submit(function(e) {
//             e.preventDefault();
//         });
//     }
//     if($("#facturar").val()==1 && ($("#fac_razon_social").val().length==0 || $("#fac_ruc").val().length==0 || $("#fac_direccion").val().length==0 || $("#fac_telefono").val().length==0) ){
//         alert("Porfavor Ingrese los datos de Facturacion");
//         $("#fac_razon_social").css('border', 'solid 1px brown');
//         $("#fac_ruc").css('border', 'solid 1px brown');
//         $("#fac_direccion").css('border', 'solid 1px brown');
//         $("#fac_telefono").css('border', 'solid 1px brown');
//         $("#frm_est").submit(function(e) {
//             e.preventDefault();
//         });
//     }else if( $("#mat_paralelo").val()=='NINGUNO' ){
//         alert("Paralelo Cultural es Obligatorio");
//         $("#mat_paralelo").css('border', 'solid 1px brown');
//         $("#frm_est").submit(function(e) {
//             e.preventDefault();
//         });

//     }else{

//         if($("#enc_tipo").val().length==0){
//             alert("Elija una Encuesta");
//             $("#frm_est").submit(function(e) {
//                 e.preventDefault();
//             });

//         }else if($("#enc_tipo").val()=='3'){
//             alert("Especifique la encuesta");
//             $("#frm_est").submit(function(e) {
//                 e.preventDefault();
//             });
//         }else{
//             $("#frm_est").submit();
//         }

//     }

// });

        $("input").keypress(function () {
            if (this.id != 'est_email' && this.id != 'rep_mail') {
                $(this).val($(this).val().toUpperCase());
            } else {
                $(this).val($(this).val().toLowerCase());
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
    })

function validar(){

    if($("#facturar").val()==""){
        alert("Elija Una Opcion de Facturar");
        return false;
    }
    if($("#facturar").val()==1 && ($("#fac_razon_social").val().length==0 || $("#fac_ruc").val().length==0 || $("#fac_direccion").val().length==0 || $("#fac_telefono").val().length==0) ){
        alert("Porfavor Ingrese los datos de Facturacion");
        $("#fac_razon_social").css('border', 'solid 1px brown');
        $("#fac_ruc").css('border', 'solid 1px brown');
        $("#fac_direccion").css('border', 'solid 1px brown');
        $("#fac_telefono").css('border', 'solid 1px brown');
        return false;
    }else if( $("#mat_paralelo").val()=='NINGUNO' ){
        alert("Paralelo Cultural es Obligatorio");
        $("#mat_paralelo").css('border', 'solid 1px brown');
        return false;
    }else{
        if($("#enc_tipo").val().length==0){
            alert("Elija una Encuesta");
            return false;
        }else if($("#enc_tipo").val()=='3'){
            alert("Especifique la encuesta");
            return false;
        }
 }

}

</script>
    <section class="content-header">
        <h1>Estudiantes</h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
               @include('flash::message')
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'estudiantes.store','id'=>'frm_est', 'onsubmit'=>'return validar()']) !!}

                        @include('estudiantes.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
