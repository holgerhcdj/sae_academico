@extends('layouts.app')
@section('content')
<?php
  $prm=Auth::user()->AsignaPermisos->where('mod_id',7)->first();
  $pr=explode('&',$prm->permisos_especiales);

?>
    <section class="content-header">
        <h1>
            Usuarios
        </h1>
   </section>
<script>
    $(document).on("change","select[name=usu_perfil]",function(){
        $("#cambia_perfil").val(1);
    })

    function validar(){
      //alert($("#psw_n").val());
      if($("#password").val()!=undefined){
        if($("#password").val()!=$("#psw_n").val()){
          alert('Contraseñas no coinciden');
          return false;
        }
      }

      if($("#cambia_perfil").val()!=undefined){
         if($("#cambia_perfil").val()==1){
           if(!confirm("El perfil ha cambiado, Desea Actualizar los Permisos?")){
             $("#cambia_perfil").val(0);
           }
         }
         
       }
    } 
</script>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               @include('flash::message')
               <div class="row">
                   {!! Form::model($usuarios, ['route' => ['usuarios.update', $usuarios->id], 'method' => 'patch','onsubmit'=>'return validar()']) !!}

                       @if($op==1 || $op==3)
                       @include('usuarios.perfil')
                       @elseif($op==2)
                       @include('usuarios.pass')
                       @endif

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection