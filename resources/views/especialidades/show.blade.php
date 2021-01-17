@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Especialidades
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    {!! Form::open(['route' => 'materias.store']) !!}

                    @include('especialidades.show_fields')

                    {!! Form::close() !!}
                    
                </div>
            </div>
        </div>
    </div>
@endsection
