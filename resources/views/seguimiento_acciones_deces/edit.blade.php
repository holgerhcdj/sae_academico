@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Seguimiento Acciones Dece
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($seguimientoAccionesDece, ['route' => ['seguimientoAccionesDeces.update', $seguimientoAccionesDece->id], 'method' => 'patch']) !!}
                        @include('seguimiento_acciones_deces.fields')
                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection