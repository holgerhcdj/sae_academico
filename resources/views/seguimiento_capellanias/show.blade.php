@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Seguimiento Capellania (Estudiantes)
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('seguimiento_capellanias.show_fields')
                    <a href="{!! route('seguimientoCapellanias.index') !!}" class="btn btn-default">Regresar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
