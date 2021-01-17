@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Registro Asistencia
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($registroAsistencia, ['route' => ['registroAsistencias.update', $registroAsistencia->tmbid], 'method' => 'patch']) !!}

                        @include('registro_asistencias.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection