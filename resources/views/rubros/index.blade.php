@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="bg-primary text-center" style="font-size:20px;margin-top:-10px;  ">
            Rubros
        </div>



        <div class="col-sm-12">
        <form action="rubros.index" method="POST" >
            {{csrf_field()}}
              <div class="input-group "> 
                    <div class="input-group-addon"  >
                        <select name="ger_id" id="ger_id" style="width:350px " class="form-control input-group-addon">
                            @foreach($ger as $g)
                            <option value="{{$g->ger_id}}">{{$g->ger_descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group-addon"  >
                        {!! Form::select('rub_estado',['0'=>'Activos','1'=>'Finalizado'],null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="input-group-addon" >
                        <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="input-group-addon" >
                        @if($permisos['new']==1)          
                        <a class="btn btn-primary pull-right"  href="{!! route('rubros.create') !!}">Nuevo</a>
                        @endif
                    </div>
            </div>
        </form>    

        </div>


    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('rubros.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

