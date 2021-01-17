@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Ordenes Pension
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('ordenes_pensions.show_fields')
                    <a href="{!! route('ordenesPensions.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
