<link rel="stylesheet" type="text/css" href="{{asset('css/print_style.css')}}">
    <style>
body { width: 21.0cm;
     min-height: 14.8cm; 
     font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;   
     font-size:10px;           
    }

/* cuando vayamos a imprimir ... */
@media print{
    *{ -webkit-print-color-adjust: exact; }
    html{ background: none; padding: 0; }
    body{ box-shadow: none; margin: 0; }
}

@page { margin: 0;}
</style>  
@if($vl==1)  
        <div style="margin-top:-30px">
            <img src="{{asset('img/colegio.png')}}" width="50px"> 
            <h1 style="margin-top:-40px;font-size:14px ">REPORTE DE SEGUIMIENTOS A ESTUDIANTES</h1>
            <table class="table" style="margin-top:30px" >
                <caption style="font-size:12px;background:#ccc;padding:5px;   ">Desde: {{$desde}}   Hasta:{{$hasta}}</caption>
                <tr>
                    <th style="width:10px ">#</th>
                    <th>Capellan</th>
                    <th>Estudiante</th>
                    <th>Jornada</th>
                    <th>Curso</th>
                    <th>Fecha de Asistencia</th>
                </tr>
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
@elseif($vl==2)
<div style="margin-top:-30px">
            <img src="{{asset('img/colegio.png')}}" width="50px"> 
            <h1 style="margin-top:-40px;font-size:14px ">REPORTE DE SEGUIMIENTOS A DOCENTES</h1>
            <table class="table" style="margin-top:30px" >
                <caption style="font-size:12px;background:#ccc;padding:5px;   ">Desde: {{$desde}}   Hasta:{{$hasta}}</caption>
                <tr>
                    <th style="width:10px ">#</th>
                    <th>Capellan</th>
                    <th>Docente</th>
                    <th>Fecha de Asistencia</th>
                </tr>
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
@elseif($vl==3)
<div style="margin-top:-30px">
            <img src="{{asset('img/colegio.png')}}" width="50px"> 
            <h1 style="margin-top:-40px;font-size:14px ">REPORTE DE VISITA HOGARES</h1>
            <table class="table" style="margin-top:30px" >
                <caption style="font-size:12px;background:#ccc;padding:5px;   ">Desde: {{$desde}}   Hasta:{{$hasta}}</caption>
                <tr>
                    <th style="width:10px ">#</th>
                     <th>Capellan</th>
                    <th>Estudiante</th>
                    <th>Jornada</th>
                    <th>Curso</th>
                    <th>Tipo de Visita</th>
                    <th>Fecha de Asistencia</th>
                </tr>
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
@endif
