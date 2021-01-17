@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Materias
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($materias, ['route' => ['materias.update', $materias->id], 'method' => 'patch']) !!}

                        @include('materias.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection