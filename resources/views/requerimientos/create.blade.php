@extends('layouts.app')

@section('content')
<div class="panel panel-info">
    <div class="panel-heading" style="font-size:20px;">
        Nuevo Requerimiento
    </div>
</div>
<div class="content" style="margin-top:-25px; ">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <!--<div class="row">-->
                    {!! Form::open(['route' => 'requerimientos.store', 'enctype'=>'multipart/form-data']) !!}

                        @include('requerimientos.fields')

                    {!! Form::close() !!}
                <!--</div>-->
            </div>
        </div>
    </div>
@endsection
