@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Permisos y Vacaciones
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'permisosVacaciones.store']) !!}

                        @include('permisos_vacaciones.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
