@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Parciales
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($parciales, ['route' => ['parciales.update', $parciales->par_id], 'method' => 'patch']) !!}

                        @include('parciales.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection