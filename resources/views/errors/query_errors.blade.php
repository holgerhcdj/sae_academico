@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">ERROR DE CONSULTA</h1>
    </section>
    <div class="content" style="margin-top:10px; ">
        <div class="box box-primary">
            <div class="box-body">
                    <h1 class="bg-danger text-danger">{!!$err['2']!!}</h1>
                    <h4 class="bg-primary text-info">Favor Comunicarce con soporte tecnico SAE(0999255331)</h4>
            </div>
        </div>
    </div>
@endsection



