@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="">
            Asignar Personal a Jornada: {{$jornadasLaborables->jrl_descripcion}} 
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left:0px">
                    @include('jornadas_laborables.show_fields')
                    <a href="{!! route('jornadasLaborables.index') !!}" class="btn btn-default">Desde</a>
                </div>
            </div>
        </div>
    </div>
@endsection
