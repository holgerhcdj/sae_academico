@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Solicitud Matricula
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($solicitudMatricula, ['route' => ['solicitudMatriculas.update', $solicitudMatricula->id], 'method' => 'patch']) !!}

                        @include('solicitud_matriculas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection