@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Editar Sugerencias
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($sugerencias, ['route' => ['sugerencias.update', $sugerencias->id], 'method' => 'patch']) !!}
                        @include('sugerencias.fields')
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection