@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sancionados
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($sancionados, ['route' => ['sancionados.update', $sancionados->snc_id], 'method' => 'patch']) !!}

                        @include('sancionados.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection