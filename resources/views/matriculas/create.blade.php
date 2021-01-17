@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Matriculas
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
            <div class="box-body">
                    {!! Form::open(['route' => 'matriculas.store']) !!}

                        @include('matriculas.fields')

                    {!! Form::close() !!}
            </div>
    </div>
@endsection
