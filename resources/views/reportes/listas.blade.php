@extends('layouts.app')
@section('content')
<style>
    table tr th, table tr td{
        padding:5px; 
        border:solid 1px burlywood; 
    }
    .total{
        font-family:Arial;
        font-size:25px;
        font-weight:bolder;
        background:#fc7700;
        color:white;
        padding:5px;
        border-radius:5px; 
        text-align:center; 
    }
    .lista{
        font-family:Arial;
        font-size:25px;        
        text-align:center; 
    }
    .form-group{
        text-align:center; 
    }
</style>
<script>
    function reset() {
        var r = prompt("Codigo de Seguridad de Reseteo de Votaciones", "");
        if (r == 780107) {
            return true;
        } else {
            alert("Codigo Incorrecto");
        return false;            
        }

    }
</script>
<section class="content-header">
    <section class="content-header">
        <h1 style="text-align:center; background:tan; border-radius:2px;">
            ESCRUTIÑO ELECCIONES VIDA NUEVA AÑO LECTIVO {{$anl->anl_descripcion}} 
        </h1>
        <h2>{{"Fecha ".$fecha}}</h2>
    </section>
</section>
@include('flash::message')
<div class="content">
    <div class="box box-primary">
        <a class="btn btn-success" href="rpt_votacion">REPORTE TOTAL</a>
        @if($permisos['new']==1)
        <a class="btn btn-danger  pull-right" href="reset_v" onclick="return reset()">RESETEAR VOTACIÓN</a>
        @endif
        
        <div class="box-body">
            <div class="form-group col-sm-3">
                <b class="lista" style="color:gold;text-shadow: 1px 2px #000; " >LISTA A</b>
                <p class="total">{{$votos['a'][0]->cant}}</p>
            </div>
            <div class="form-group col-sm-3">
                <b class="lista" style="color:royalblue  ;text-shadow: 1px 2px #000; ">LISTA B</b>
                <p class="total">{{$votos['b'][0]->cant}}</p>
            </div>
            <div class="form-group col-sm-3" hidden>
                <b class="lista" style="color:brown;text-shadow: 1px 2px #000; ">LISTA C</b>
                <p class="total">{{$votos['c'][0]->cant}}</p>
            </div>
            <div class="form-group col-sm-3">
                <b class="lista" style="text-shadow: 1px 2px #ccc; " >NINGUNO</b>
                <p class="total">{{$votos['n'][0]->cant}}</p>
            </div>

        </div>
    </div>
</div>
@endsection
