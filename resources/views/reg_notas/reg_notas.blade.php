@extends('layouts.app')
<?php
$cont_esp="hidden";
$us=Auth::user()->id;
if($us==22 || $us==86){//Lic Alejandro y Lic Javier
    $cont_esp="";
}
?>
@section('content')
<section class="content-header" style="height:30px; ">
    <h1 class="pull-left">
        REGISTRO DE NOTAS 
    </h1>
</section>
<div class="content">

    @foreach($horarios as $h)
    <?php
    $style_matutina="bg-light-blue";
    if($h->jor_descripcion=='MATUTINA'){
    $style_matutina="bg-aqua";

    }

    ?>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box {{$style_matutina}}">
            <div class="inner" >
              <p style="font-size:14px ">{{ ' '.$h->jor_descripcion.' / '.$h->esp_descripcion.' / '.$h->cur_descripcion.' / '.$h->paralelo}}</p>
            </div>
            <a href="#" class="small-box-footer"><i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
<!--             <div class="card col-md-6" style="margin-top:5px;padding:5px  ">
                <i class="btn btn-primary fa fa-user">{{ ' '.$h->jor_descripcion.' / '.$h->esp_descripcion}}</i>
            </div>
 -->    
 @endforeach

</div>
@endsection
