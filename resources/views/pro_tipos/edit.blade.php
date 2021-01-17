@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Pro Tipo
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($proTipo, ['route' => ['proTipos.update', $proTipo->tpid], 'method' => 'patch', 'onsubmit'=>'return validar()']) !!}
                        @include('pro_tipos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection