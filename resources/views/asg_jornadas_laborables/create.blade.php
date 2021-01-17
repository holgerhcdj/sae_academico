@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Asg Jornadas Laborables
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'asgJornadasLaborables.store']) !!}

                        @include('asg_jornadas_laborables.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
