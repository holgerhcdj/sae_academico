@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            CLIENTES
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($clientes, ['route' => ['clientes.update', $clientes->cli_id], 'method' => 'patch']) !!}

                        @include('clientes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection