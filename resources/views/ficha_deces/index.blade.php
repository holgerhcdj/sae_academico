@extends('layouts.app')

@section('content')
    <section class="content-header">

<table class="table" border="0">
    <tr>
        <th class="text-center btn-primary" colspan="2">
            Control de Fichas de Estudiantes
        </th>
    </tr>
    <tr>
        <td>
            <form action="fichaDeces.index" method="POST" >
                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                <div class="form-group col-sm-4">
                  {!! Form::text('buscar', null, ['class' => 'form-control','size'=>'80','placeholder'=>'Cedula/Apellidos/Nombres']) !!}
              </div>
              <div class="input-group col-sm-2">
                  <button style="margin-top:0px" class="btn btn-warning" value="search" type="submit" name="search" >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
        </td>
        <td>
<!--         <a class="btn btn-primary pull-right" style="margin-top:0px;margin-bottom: 5px" href="{!! route('fichaDeces.create') !!}">Nuevo</a> -->
        </td>
    </tr>

</table>


    </section>
    <div class="content" style="margin-top:-50px; ">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('ficha_deces.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

