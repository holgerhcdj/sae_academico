@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sancionados Seguimiento
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($sancionadosSeguimientos, ['route' => ['sancionadosSeguimientos.update', $sancionadosSeguimientos->sgsnc_id], 'method' => 'patch']) !!}

                        @include('sancionados_seguimientos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection