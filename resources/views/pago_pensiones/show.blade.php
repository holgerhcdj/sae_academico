@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Pago Pensiones
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('pago_pensiones.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
