@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Asigna Horarios
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($asignaHorarios, ['route' => ['asignaHorarios.update', $asignaHorarios->id], 'method' => 'patch']) !!}

                        @include('asigna_horarios.fields')
                        
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection