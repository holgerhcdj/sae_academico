@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Tramites
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($tramites, ['route' => ['tramites.update', $tramites->id], 'method' => 'patch']) !!}

                        @include('tramites.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection