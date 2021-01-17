@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Enc Encabezado
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($encEncabezado, ['route' => ['encEncabezados.update', $encEncabezado->enc_id], 'method' => 'patch']) !!}

                        @include('enc_encabezados.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection