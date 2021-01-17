@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Anio Lectivo
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           @include('flash::message')
           <div class="box-body">
               <div class="row">
                   {!! Form::model($anioLectivo, ['route' => ['anioLectivos.update', $anioLectivo->id], 'method' => 'patch']) !!}

                        @include('anio_lectivos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection