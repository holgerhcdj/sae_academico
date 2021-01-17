@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="bg-primary text-center">
            Expediente del Estudiante: {{$fexp->est_apellidos.' '.$fexp->est_nombres}}
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('ficha_deces.show_fields')
                   
                </div>
            </div>
        </div>
    </div>
@endsection
