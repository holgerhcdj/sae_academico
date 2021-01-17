@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="row bg-primary" style="font-size:15px;height:30px;  ">
            <div class="col-sm-3">
            Rubro: {{ $rubros->rub_descripcion}}    
            </div>
            <div class="col-sm-6" id="tx_rub_valor" >
                @if($rubros->rub_id==4)
                    Valor: (30$) Matutina y Vespertina (20$) Nocturna y SemiPresencial
                @else
                    Valor: {{ $rubros->rub_valor .'$'}}    
                @endif
            </div>
            <div class="col-sm-3">
            Fecha Maxima Pago: {{ $rubros->rub_fecha_max }}    
            </div>
        </div>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('rubros.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
