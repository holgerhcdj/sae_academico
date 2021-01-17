@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Productos Servicios
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'productosServicios.store']) !!}

                        @include('productos_servicios.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
