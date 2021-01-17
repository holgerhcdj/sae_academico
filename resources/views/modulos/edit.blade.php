@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Modulos
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($modulos, ['route' => ['modulos.update', $modulos->id], 'method' => 'patch']) !!}

                        @include('modulos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection