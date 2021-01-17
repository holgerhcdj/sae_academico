@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Novedades
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <?php $x=1?>
                    @foreach($sms as $s)
                      <div class="col-sm-1" >{{$x++}}</div>
                      <div class="col-sm-2" >{{$s->modulo}}</div>
                      <div class="col-sm-9" >{{$s->novedad}}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
