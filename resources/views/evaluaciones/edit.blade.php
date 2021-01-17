@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Evaluaciones
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($evaluaciones, ['route' => ['evaluaciones.update', $evaluaciones->evl_id], 'method' => 'patch']) !!}

                        @include('evaluaciones.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection