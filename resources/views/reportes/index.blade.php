@extends('layouts.app')
@section('content')
<style>
    .fecha{
        float:right; 
        font-size:18px; 
       
    }
</style>
<section class="content-header">
    <section class="content-header">
        <h1 style="text-align:center; background:tan; border-radius:2px;  ">
            Estadisticas Año Lectivo {{Session::get('anio')}} <?php echo "<span class='fecha'>AL: $date</span>" ?>
        </h1>
    </section>
    @include('flash::message')
    <div class="col-sm-12" style="border:solid 0px;">
    <form action="estadistica.preview" method="POST">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-primary" name="preview" value="preview" ><i class="fa fa-eye">  Vista Previa</i></button>
                    <button class="btn btn-success pull-right" name="preview_excel" value="preview_excel" ><i class="fa fa-file-excel-o">  Exportar a Excel</i></button>
                </span>
            </div>
    </form>    
    </div>
</section>
<div class="content">
    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            @include('reportes.table')
        </div>
    </div>
</div>
@endsection

