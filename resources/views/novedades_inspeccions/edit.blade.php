@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Novedades de Inspección
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($novedadesInspeccion, ['route' => ['novedadesInspeccions.update', $novedadesInspeccion->inspid], 'method' => 'patch', 'onsubmit' => 'return validar()']) !!}

                        @include('novedades_inspeccions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection