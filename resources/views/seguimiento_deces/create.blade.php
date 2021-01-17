@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Registro de casos especiales
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'seguimientoDeces.store', 'onsubmit'=>'return validar()']) !!}

                        @include('seguimiento_deces.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
