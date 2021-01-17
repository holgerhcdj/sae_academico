@extends('layouts.app')

@section('content')
    <section class="content-header">
              <h1 class="pull-left">Registro de Comportamiento / Inspección</h1>
    </section>
    <div class="content" style="margin-top:20px ">
        <div class="box box-primary">
            <div class="box-body">

        <div class="col-lg-3 col-xs-6">
            <a style="color:white"  href="{!! route('regDisciplinas.create',['p'=>'1']) !!}">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3 class="text-center" >1</h3>
                  <p class="text-center" style="font-weight:bolder; " >PARCIAL</p>
                </div>
                <div class="icon">
                  <i class="fa fa-circle"></i>
                </div>
            </a>
            <span class="small-box-footer">COMPORTAMIENTO</span>  
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <a style="color:white"  href="{!! route('regDisciplinas.create',['p'=>'2']) !!}">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3 class="text-center" >2</h3>
                  <p class="text-center" style="font-weight:bolder; " >PARCIAL</p>
                </div>
                <div class="icon">
                  <i class="fa fa-circle"></i>
                </div>
            </a>
            <span class="small-box-footer">COMPORTAMIENTO</span>  
          </div>
        </div>              
         <div class="col-lg-3 col-xs-6">
            <a style="color:white"  href="{!! route('regDisciplinas.create',['p'=>'3']) !!}">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3 class="text-center" >3</h3>
                  <p class="text-center" style="font-weight:bolder; " >PARCIAL</p>
                </div>
                <div class="icon">
                  <i class="fa fa-circle"></i>
                </div>
            </a>
            <span class="small-box-footer">COMPORTAMIENTO</span>  
          </div>
        </div>              
         <div class="col-lg-3 col-xs-6">
            <a style="color:white"  href="{!! route('regDisciplinas.create',['p'=>'4']) !!}">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3 class="text-center" >4</h3>
                  <p class="text-center" style="font-weight:bolder; " >PARCIAL</p>
                </div>
                <div class="icon">
                  <i class="fa fa-circle"></i>
                </div>
            </a>
            <span class="small-box-footer">COMPORTAMIENTO</span>  
          </div>
        </div>              
         <div class="col-lg-3 col-xs-6">
            <a style="color:white"  href="{!! route('regDisciplinas.create',['p'=>'5']) !!}">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3 class="text-center" >5</h3>
                  <p class="text-center" style="font-weight:bolder; " >PARCIAL</p>
                </div>
                <div class="icon">
                  <i class="fa fa-circle"></i>
                </div>
            </a>
            <span class="small-box-footer">COMPORTAMIENTO</span>  
          </div>
        </div>              
         <div class="col-lg-3 col-xs-6">
            <a style="color:white"  href="{!! route('regDisciplinas.create',['p'=>'6']) !!}">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3 class="text-center" >6</h3>
                  <p class="text-center" style="font-weight:bolder; " >PARCIAL</p>
                </div>
                <div class="icon">
                  <i class="fa fa-circle"></i>
                </div>
            </a>
            <span class="small-box-footer">COMPORTAMIENTO</span>  
          </div>
        </div>              
 
<!--               <h1 class="pull-right"> -->
<!--                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-left:10px;  margin-bottom: 5px" href="{!! route('regDisciplinas.create',['p'=>'6']) !!}">PARCIAL 6</a>
               <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-left:10px;  margin-bottom: 5px" href="{!! route('regDisciplinas.create',['p'=>'5']) !!}">PARCIAL 5</a>
               <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-left:10px;  margin-bottom: 5px" href="{!! route('regDisciplinas.create',['p'=>'4']) !!}">PARCIAL 4</a>
               <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-left:10px;  margin-bottom: 5px" href="{!! route('regDisciplinas.create',['p'=>'3']) !!}">PARCIAL 3</a>
               <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-left:10px;  margin-bottom: 5px" href="{!! route('regDisciplinas.create',['p'=>'2']) !!}">PARCIAL 2</a>
               <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-left:10px;  margin-bottom: 5px" href="{!! route('regDisciplinas.create',['p'=>'1']) !!}">PARCIAL 1</a>
 --> <!--             </h1> --> <!--              <div class="col-md-3">
              {!! Form::select('jor',$jor,null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3">
              {!! Form::select('esp',$esp,null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3">
              {!! Form::select('cur',$cur,null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3">
              {!! Form::select('paralelo',$jor,null, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-3">
            </div>
 -->


            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

