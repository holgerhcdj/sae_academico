@extends('layouts.app')

@section('content')
<?php
if(isset($adminNotas)){
    $fini=$adminNotas->adm_finicio;
    $ffin=$adminNotas->adm_ffinal;
    $hini=$adminNotas->adm_finicio;
    $hfin=$adminNotas->adm_ffinal;
}else{
    $fini=date('Y-m-d');
    $ffin=date('Y-m-d');
    $hini=date('H:i');
    $hfin=date('H:i');
}
?>
    <section class="content-header">
        <h1>
            Administrar Notas
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($adminNotas, ['route' => ['adminNotas.update', $adminNotas->adm_id], 'method' => 'patch']) !!}

                        @include('admin_notas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection