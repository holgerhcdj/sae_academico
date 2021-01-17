@extends('layouts.app')

@section('content')
    <section class="content-header">
           <h1 class="bg-primary text-center" >Reportes Generales</h1>
    </section>
    <script>
        function validar(op) {
            if(op==1){
                $('#frm_reporte').attr('target','_blank');
            }

            $('input[name=op]').val(op);
            $('#frm_reporte').submit();
        }
    </script>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body"> 
                <form action="segSemanalDocentes.index" method="POST" id="frm_reporte" >
                    {{csrf_field()}}
                <table>
                    <thead class="bg-primary">
                    <tr>
                        <th>Tipo</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tr>
                        <td>
                        {!! Form::select('tipo',['0'=>'Estudiantes','1'=>'Docentes','2'=>'Visita Hogares',],null, ['class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::date('desde',date('Y-m-d'), ['class' => 'form-control']) !!}                            
                        </td>
                        <td>
                            {!! Form::date('hasta',date('Y-m-d'), ['class' => 'form-control']) !!}                            
                            {!! Form::hidden('op',null, ['class' => 'form-control']) !!}                            
                        </td>
                </form>
                        <td>
                            <button name="btn_buscar" class="btn btn-primary" onclick="validar(0)" value="btn_buscar">Ver</button>
                            <button name="btn_imprimir" class="btn btn-primary" onclick="validar(1)" value="btn_imprimir">Imprimir</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

@if($vl==1)

        <div class="col-sm-9">
            <table class="table table-hover table-striped">
                <thead class="bg-primary">
                <tr>
                    <th style="width:10px ">#</th>
                    <th>Capellan</th>
                    <th>Estudiante</th>
                    <th>Jornada</th>
                    <th>Curso</th>
                    <th>Fecha</th>
                </tr>
                </thead>
                <?php $x=1?>
                @foreach($reporte as $r)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$r->usu_apellidos.' '.$r->name}}</td>
                    <td>{{$r->est_apellidos.' '.$r->est_nombres}}</td>
                    <td>{{$r->jor_descripcion}}</td>
                    <td>{{$r->cur_descripcion.' '.$r->mat_paralelo}}</td>
                    <td>{{$r->f_asist}}</td>
                </tr>
                @endforeach
            </table>
        </div>

        @foreach($cap as $c)
                <div class="col-sm-3">
                  <div class="small-box bg-aqua" style="">
                    <div class="inner">
                      <h4 class="bg-primary">Atendidos: {{$c->count}}</h4>
                      <p class="bg-info text-black">{{$c->usu_apellidos.' '.$c->name}}</p>
                  </div>
                  <div class="icon"><i class="ion ion-person"></i></div>
                  <!--             <a href="#" class="small-box-footer">Ver<i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
              </div>
        @endforeach

@elseif($vl==2)

                 <div class="col-sm-9">
            <table class="table table-hover table-striped">
                <thead class="bg-primary">
                <tr>
                    <th style="width:10px ">#</th>
                    <th>Capellan</th>
                    <th>Docente</th>
                    <th>Fecha</th>
                </tr>
                </thead>
                <?php $x=1?>
                @foreach($reporte as $r)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$r->capellan}}</td>
                    <td>{{$r->docente}}</td>
                    <td>{{$r->fecha}}</td>
                </tr>
                @endforeach
            </table>
        </div>

        @foreach($cap as $c)
                <div class="col-sm-3">
                  <div class="small-box bg-aqua" style="">
                    <div class="inner">
                      <h4 class="bg-primary">Atendidos: {{$c->count}}</h4>
                      <p class="bg-info text-black">{{$c->capellan}}</p>
                  </div>
                  <div class="icon"><i class="ion ion-person"></i></div>
                  <!--             <a href="#" class="small-box-footer">Ver<i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
              </div>
        @endforeach

@elseif($vl==3)

        <div class="col-sm-9">
            <table class="table table-hover table-striped">
                <thead class="bg-primary">
                <tr>
                    <th style="width:10px ">#</th>
                    <th>Capellan</th>
                    <th>Estudiante</th>
                    <th>Jornada</th>
                    <th>Curso</th>
                    <th>Tp_Visita</th>
                    <th>Fecha</th>
                </tr>
                </thead>
                <?php $x=1?>
                @foreach($reporte as $r)
                <tr>
                    <td>{{$x++}}</td>
                    <td>{{$r->capellan}}</td>
                    <td>{{$r->estudiante}}</td>
                    <td>{{$r->jor_descripcion}}</td>
                    <td>{{$r->cur_descripcion.' '.$r->mat_paralelo}}</td>
                    <td>@if($r->tipo==0)
                        {{'Regular'}}
                        @elseif($r->tipo==1)
                        {{'Especial'}}   
                @endif</td>
                    <td>{{$r->f_asist}}</td>
                </tr>
                @endforeach
            </table>
        </div>

        @foreach($cap as $c)
                <div class="col-sm-3">
                  <div class="small-box bg-aqua" style="">
                    <div class="inner">
                      <h4 class="bg-primary">Atendidos: {{$c->count}}</h4>
                      <p class="bg-info text-black">{{$c->capellan}}</p>
                  </div>
                  <div class="icon"><i class="ion ion-person"></i></div>
                  <!--             <a href="#" class="small-box-footer">Ver<i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
              </div>
        @endforeach
  

@endif            



    </div>
@endsection

