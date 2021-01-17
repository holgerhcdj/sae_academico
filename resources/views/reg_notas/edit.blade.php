@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Reg Notas
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($regNotas, ['route' => ['regNotas.update', $regNotas->id], 'method' => 'patch']) !!}

                        @include('reg_notas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection