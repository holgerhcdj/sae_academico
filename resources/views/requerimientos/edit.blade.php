@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            De: {{ $emisor->name.' '.$emisor->usu_apellidos }}
            <button class="btn btn-warning btn-sm" title="Responder" id='btn_reply' data="{{$emisor->id.'&'.$emisor->name.' '.$emisor->usu_apellidos }}" >
                  <i class="fa fa-reply " aria-hidden="true"></i>
            </button>
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <!--<div class="row">-->
                   {!! Form::model($requerimientos, ['route' => ['requerimientos.update', $requerimientos->mvr_id],'enctype'=>'multipart/form-data','method' => 'patch']) !!}

                        @include('requerimientos.fields')

                   {!! Form::close() !!}
               <!--</div>-->
           </div>
       </div>
   </div>
@endsection