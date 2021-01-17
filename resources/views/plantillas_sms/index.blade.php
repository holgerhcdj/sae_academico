@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="row bg-primary" >
            <div class="col-sm-11 text-center">
                <span style="font-size:16px;" >Plantillas Sms</span>
            </div>
            <div class="col-sm-1 bg-info">
               <a class="btn btn-primary pull-right" href="{!! route('plantillasSms.create') !!}">Nuevo</a>
            </div>
        </div>

    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('plantillas_sms.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

