@extends('layouts.app')

@section('content')
<?php
$d=date('Y-m-d');
$h=date('Y-m-d');
if(isset($_POST['btn_buscar'])){
    $d=$_POST['desde'];
    $h=$_POST['hasta'];
}
?>
<style>
    .title{
        font-weight:bolder;
        background:#109CCA;
        color:white;
        font-size:18px;
    }
</style>
    <section class="content-header">
        <div class="row bg-primary" >
            <div class="col-sm-11 text-center">
                <span style="font-size:16px;" >Envío de Notifcaciones SMS/Mail</span>
            </div>
            <div class="col-sm-1 bg-info">
                <a class="btn btn-primary pull-right"  href="{!! route('smsMails.create') !!}">Nuevo</a>
            </div>
        </div>
        <form action="buscar_comunicaciones" method="POST">
            {{csrf_field()}}
            <div class="input-group col-sm-6" style="margin-top:5px; ">
                <span class="input-group-addon bg-gray" style="font-weight:bolder; ">Desde:</span>    
                {!! Form::date('desde',$d,['class'=>'form-control']) !!}
                <span class="input-group-addon bg-gray" style="font-weight:bolder; ">Hasta:</span>    
                {!! Form::date('hasta',$h,['class'=>'form-control']) !!}
                <span class="input-group-btn">
                    <button type="submit" name="btn_buscar" value="btn_buscar" class="btn btn-primary">Buscar</button>
                </span>    
            </div>
        </form>        
    </section>
    <div class="content">
        <div class="box box-primary">
                    @include('sms_mails.table')
        </div>
    </div>
@endsection

