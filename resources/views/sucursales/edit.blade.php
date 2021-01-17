@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sucursales
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($sucursales, ['route' => ['sucursales.update', $sucursales->id], 'method' => 'patch']) !!}

                        @include('sucursales.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection