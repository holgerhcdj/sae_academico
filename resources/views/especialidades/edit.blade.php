@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Especialidades
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($especialidades, ['route' => ['especialidades.update', $especialidades->id], 'method' => 'patch']) !!}

                        @include('especialidades.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection