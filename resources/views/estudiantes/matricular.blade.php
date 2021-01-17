@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Matricular
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">

                    {!! Form::open(['route' => 'estudiantes.store']) !!}

                    <div class="form-group col-sm-3">
                        {!! Form::label('est_cedula', 'No:') !!}
                        {!! Form::text('est_cedula', null, ['class' => 'form-control','maxlength'=>'10','required'=>'required']) !!}
                    </div>
                    <!-- Apellidos Field -->
                    <div class="form-group col-sm-3">
                        {!! Form::label('est_apellidos', 'Apellidos:') !!}
                        {!! Form::text('est_apellidos', null, ['class' => 'form-control','required'=>'required']) !!}
                    </div>
                    <!-- Nombres Field -->
                    <div class="form-group col-sm-3">
                        {!! Form::label('est_nombres', 'Nombres:') !!}
                        {!! Form::text('est_nombres', null, ['class' => 'form-control','required'=>'required']) !!}
                    </div>
                    <div class="form-group col-sm-10">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                    </div>


                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
