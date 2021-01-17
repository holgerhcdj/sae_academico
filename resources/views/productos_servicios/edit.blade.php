@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Productos Servicios
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($productosServicios, ['route' => ['productosServicios.update', $productosServicios->pro_id], 'method' => 'patch']) !!}

                        @include('productos_servicios.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection