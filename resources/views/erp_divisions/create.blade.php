@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            BODEGA - LABORATORIO - DIVISION
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'erpDivisions.store','onsubmit'=>'return validar()']) !!}

                        @include('erp_divisions.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection