@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Movimientos
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($movimientos, ['route' => ['movimientos.update', $movimientos->movid], 'method' => 'patch','onsubmit'=>'return validar()']) !!}

                        @include('movimientos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection