@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="bg-primary text-center" style="margin-top:-25px; " >
        <h3>
            PERMISOS AL DEPARTAMENTO <span class="text-yellow">{{$departamentos->descripcion}}</span>
        </h3>
        </div>
    </section>
    <div class="content">
        <div class="box box-primary container-fluid" >
                    @include('departamentos.show_fields')
                    <a href="{!! route('departamentos.index') !!}" class="btn btn-danger pull-right">SALIR</a>
        </div>
    </div>
@endsection
