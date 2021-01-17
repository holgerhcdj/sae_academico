@extends('layouts.app')

@section('content')
<style>
    .bar_code{
        height:100px; 
    }
</style>
<script>
function validar(){
          if(prompt("Codigo de eliminación")=='1714028592'){
              $("#frm_buscar_productos").submit();
          }
  }


  
</script>
    <section class="content-header">
        <h1 class="text-center btn-primary">Productos</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top:2px;" href="{!! route('productos.create') !!}">Nuevo</a>
        </h1>

                    <form action="productos.index" method="POST" id="frm_buscar_productos" >
                        {{csrf_field()}}
                      <div class="input-group col-md-4" style="margin-top:5px;">
                        {!! Form::select('div_id',$div,null, ['class' => 'form-control']) !!}
                        <div class="input-group-btn">
                          <button class="btn btn-primary" name="btn_buscar" value="buscar" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                      </div>
                      @if(Auth::user()->id==1)
                        <div class="input-group-btn pull-right">
                          <button class="btn btn-danger" name="btn_limpiar" value="limpiar" onclick="validar()" type="submit" ><i class="fa fa-close"></i></button>
                      </div>
                      @endif
                  </div>
              </form> 

    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">

                    @include('productos.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

