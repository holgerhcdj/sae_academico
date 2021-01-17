@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Seguimientos de sancion
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('sancionados_seguimientos.index')
                </div>
            </div>
        </div>
    </div>
@endsection
