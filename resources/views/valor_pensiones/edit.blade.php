@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Valor Pensiones
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($valorPensiones, ['route' => ['valorPensiones.update', $valorPensiones->id], 'method' => 'patch']) !!}

                        @include('valor_pensiones.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection