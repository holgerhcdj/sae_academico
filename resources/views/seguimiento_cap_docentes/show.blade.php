@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Seguimiento Cap Docentes
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('seguimiento_cap_docentes.show_fields')
                    <a href="{!! route('seguimientoCapDocentes.index') !!}" class="btn btn-default">Regresar</a>
                </div>
            </div>
        </div>
    </div>
@endsection
