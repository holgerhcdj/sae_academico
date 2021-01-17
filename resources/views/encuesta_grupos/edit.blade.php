@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Encuesta Grupos
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($encuestaGrupos, ['route' => ['encuestaGrupos.update', $encuestaGrupos->id], 'method' => 'patch']) !!}

                        @include('encuesta_grupos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection