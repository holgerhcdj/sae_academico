@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Asigna Permisos
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($asignaPermisos, ['route' => ['asignaPermisos.update', $asignaPermisos->id], 'method' => 'patch']) !!}

                        @include('asigna_permisos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection