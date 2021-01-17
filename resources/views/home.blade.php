@extends('layouts.app')

@section('content')
    <div class="content">
            <div class="box-body">
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">

 
        <div class="col-md-3">
          <a href="{!! route('aulaVirtuals.index') !!}">
          <div class="box box-widget widget-user">
            <div class="widget-user-header bg-gray" style="background: url({{asset('img/aula.png')}}) center center no-repeat;background-size:100px;">
              <h5 class="text-left" style='color:#2980b9;margin-left:-10px '>AULA VIRTUAL </h5>
            </div>

            <div class="box-footer">
              <div class="row">
                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{count($cursos)}}</h5>
                    <span class="description-text">Cursos</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{$nest}}</h5>
                    <span class="description-text">Estudiantes</span>
                  </div>
                  <!-- /.description-block -->
                </div>

                <!-- /.col -->
<!--                 <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">35</h5>
                    <span class="description-text">PRODUCTS</span>
                  </div>
                </div>
 -->                
                <!-- /.col -->
                
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.widget-user -->
        </div>
      </a>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{Session::get('msj')}}</h3>
              <p>Nuevos Mensajes</p>
            </div>
            <div class="icon">
              <i class="glyphicon glyphicon-envelope"></i>
            </div>
            <a href="#" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-md-12">

          <iframe width="869" height="542" src="https://www.youtube.com/embed/d-yel-rdtww" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

        </div>

<?php
$pr=Auth::user()->AsignaPermisos->where("mod_id",53)->first();
?>        
@if(isset($pr))
        <div class="col-lg-3 col-xs-6" hidden>
          <div class="small-box bg-red">
            <div class="inner">
              <h3>
              <a class="btn btn-app" href="{!! route('encRegistros.index') !!}">
                <i class="fa fa-play"></i> Realizar Encuesta
              </a>                
              </h3>
              <p>ENCUESTA LABORAL</p>
            </div>
            <div class="icon">
              <i class="fa fa-list-ul"></i>
            </div>
          </div>
        </div>
@endif
      </div>
      <!-- /.row -->
      <!-- Main row -->
    </section>
  </div>
</div>
@endsection
