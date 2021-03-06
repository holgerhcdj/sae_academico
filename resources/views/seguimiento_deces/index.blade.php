@extends('layouts.app')

@section('content')
<?php

if (isset($_POST['btn_buscar'])){
    $d=$_POST['desde'];
    $h=$_POST['hasta'];
}else{
    $d=date('Y-m-d');
    $h=date('Y-m-d');
}
$prm=Auth::user()->AsignaPermisos->where('mod_id',39)->first();//Obtengo los permisos del modulo de Capellania
//dd($prm);
 ?>
    <section class="content-header">
        <h1 class="text-center btn-primary">Seguimiento Casos Especiales</h1>
        <h1 class="pull-right">
          @if($prm->new==1)
           <a class="btn btn-primary pull-right" style="margin-top: 10px;margin-bottom: 5px" href="{!! route('seguimientoDeces.create') !!}">Nuevo</a>
           @endif
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
         <table>
            <tr>
                <td>
        <form action="seguimientoDece_buscar" method="POST" >
                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <div class="form-group col-sm-4">
                 Nombre del Estudiante: {!! Form::text('n_estudiante', null, ['class' => 'form-control','size'=>'80','placeholder'=>'Nombre del Estudiante']) !!}
              </div>
              <div class="form-group col-sm-2">
                  Desde: {!! Form::date('desde', $d, ['class' => 'form-control']) !!}
              </div>
              <div class="form-group col-sm-2">
                   Hasta {!! Form::date('hasta', $h, ['class' => 'form-control']) !!}
              </div>
              <div class="input-group col-sm-2">
                  <button style="margin-top:20px" class="btn btn-warning" value="search" type="submit" name="btn_buscar" >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
                </td>
            </tr>
        </table>
        <div class="box box-primary">
            <div class="box-body">
                    @include('seguimiento_deces.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

