@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            SUBIR ARCHIVO DE NOTAS
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <form action="{{route('subirNotas.store')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input  type="file" name="notas" />
                    <input type="submit" name="subir" value="Subir">
                </form>
            </div>
        </div>
    </div>
@endsection
