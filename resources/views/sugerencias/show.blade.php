@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sugerencias
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <form action="sugerencias.contestacion" method="POST">
                            @include('sugerencias.show_fields')
                       <button class="btn btn-primary">Contestar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
