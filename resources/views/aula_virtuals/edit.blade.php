@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Aula Virtual
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($aulaVirtual, ['route' => ['aulaVirtuals.update', $aulaVirtual->id], 'method' => 'patch']) !!}

                        @include('aula_virtuals.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection