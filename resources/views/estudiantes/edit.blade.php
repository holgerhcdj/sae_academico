@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Estudiantes
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
               @include('flash::message')
           <div class="box-body">
               <div class="row">
                   {!! Form::model($estudiantes, ['route' => ['estudiantes.update', $estudiantes->id], 'method' => 'patch', 'onsubmit'=>'return validar()']) !!}

                        @include('estudiantes.fields_edit')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection