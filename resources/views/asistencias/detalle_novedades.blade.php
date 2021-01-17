@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            {{$nv}} DE {{$f}}
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <table class="table">
                        <?php $x=1;?>
                        @foreach($as as $a )
                               <tr>
                                <td>{{$x++}}</td>
                                   <td>{{$a->jor_descripcion}}</td>
                                   <td>{{$a->cur_descripcion}}</td>
                                   <td>{{$a->mat_paralelo}}</td>
                                   <td>{{$a->est_apellidos.' '.$a->est_nombres}}</td>
                               </tr> 
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
