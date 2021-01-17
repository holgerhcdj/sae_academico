@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            SUBIR INVENTARIO
        </h1>
   </section>
   <div class="content">
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                  <form action="cargar_inventario" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group col-sm-3">
                      {!! Form::label('archivo', 'Archivo:') !!}
                      {!! Form::file('archivo', null, ['class' => 'form-control','accept'=>'application/msword, application/vnd.ms-excel','id'=>'archivo']) !!}
                    </div>
                    <button name="btn_subir_archivo" id="btn_subir_archivo">Subir</button>
                  </form>                    
              </div>
              <table class="table">
                <tr>
                  <th>#</th>
                  <th>Archivo</th>
                  <th>Fecha/Hora</th>
                  <th>...</th>
                </tr>
                <?php $x=1?>
                @foreach($archivo as $a)
                <tr>
                  <td>{{$x++}}</td>
                  <td>{{$a->ai_archivo}}</td>
                  <td>{{$a->ai_fecha.' / '.$a->ai_hora}}</td>
                  <td>
                    @if($a->ai_estado==0)
                    {{'Activo'}}
                    @else
                    {{'InActivo'}}
                    @endif
                  </td>
                </tr>
                @endforeach
                
              </table>
           </div>
       </div>
   </div>
@endsection