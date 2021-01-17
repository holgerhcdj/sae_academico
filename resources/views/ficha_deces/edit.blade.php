@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            <?php
            if($est->mat_estado==0){
                $est->mat_estado='Inscrito';
            }elseif($est->mat_estado==1){
                $est->mat_estado='Matriculado';
            }
            ?>
            Ficha : {{ $est->est_apellidos .' '.$est->est_nombres.' -> '.$est->jor_descripcion.' -> '.$est->cur_descripcion.' -> '.$est->mat_paralelo.' -> '.$est->mat_estado}}
        </h1>
        <a href="{{url('fichaDeces.fichapdf/1')}}" target="_blank">Imprimir</a>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($fichaDece, ['route' => ['fichaDeces.update', $fichaDece->fc_id], 'method' => 'patch', 'onsubmit'=>'return validar()']) !!}

                        @include('ficha_deces.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection