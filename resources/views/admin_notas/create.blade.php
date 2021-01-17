@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Administrar Notas
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                  
                    {!! Form::open(['route' => 'adminNotas.store','onsubmit'=>'return validar()']) !!}

                        @include('admin_notas.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
