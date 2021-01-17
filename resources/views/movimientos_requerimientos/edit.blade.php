@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Movimientos Requerimiento
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($movimientosRequerimiento, ['route' => ['movimientosRequerimientos.update', $movimientosRequerimiento->id], 'method' => 'patch']) !!}

                        @include('movimientos_requerimientos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection