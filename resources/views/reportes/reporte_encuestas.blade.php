@extends('layouts.app')

@section('content')
<?php

// if(isset($_POST['btn_search'])){
// $dir=$_POST['dir_cor'];
// }else{
// $dir='';    
// }

?>
    <section class="content-header">
        <h1 class="bg-primary text-center">
            REPORTE DE ENCUESTAS
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    <table class="table">
                        <tr>
                            <th>No</th>
                            <th>Numero</th>
                            <th>Descripcion</th>
                            <th>Estado</td>
                            <td></td>
                        </tr>
                        <?php $x=1;?>
                        @foreach($enc as $en)
                        <tr>
                            <td>{{$x}}</td>
                            <td>{{$en->enc_numero}}</td>
                            <td>{{$en->enc_descripcion}}</td>
                            <td>
                                @if($en->enc_estado==0)
                                {{'Activo'}}
                                @else
                                {{'Inactivo'}}
                                @endif
                            </td>
                            <td>
                                <a href="{!! route('encGrupos.show', [$en->enc_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>   
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>

@endsection
