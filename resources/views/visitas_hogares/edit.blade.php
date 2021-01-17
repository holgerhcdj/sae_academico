@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Visitas Hogares
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($visitasHogares, ['route' => ['visitasHogares.update', $visitasHogares->vstid], 'method' => 'patch','enctype'=>'multipart/form-data','onsubmit'=>'return validar()']) !!}

                        @include('visitas_hogares.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection