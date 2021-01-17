@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Pro Tipo
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'proTipos.store','onsubmit'=>'return validar()']) !!}

                        @include('pro_tipos.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
