@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="col-sm-12 text-center bg-primary" >
            Administrar Notas <span style="font-size:18px;margin-top:3px;" class="text-white font-weight-bold">(Se muestran solo las activas)</span>
        </h1>
        <h6 class="col-sm-12 text-center">
           <span class="bg-red" style="padding:5px;border-radius:3px  ">FINALIZA HOY 23:59</span> 
           <span class="bg-yellow" style="padding:5px;border-radius:3px  ">FINALIZA EN 1 DÍA</span> 
           <span class="bg-green" style="padding:5px;border-radius:3px  ">FINALIZA EN > 1 DÍA</span> 
           <a class="btn btn-primary pull-right"  href="{!! route('adminNotas.create') !!}">Nueva</a>
        </h6>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('admin_notas.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

