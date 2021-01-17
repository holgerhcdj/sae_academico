@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Pago Rubros
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'pagoRubros.store']) !!}

                        @include('pago_rubros.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
