@extends('layouts.app')

@section('content')
<script>
    function imprimir(){
        window.print();
    } 

  $(function () {

    $('#tabla').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })

</script>
<style>
    table tr td, table .enc1 th{
        border: solid 1px;
        font-size:11px; 
        padding:3px; 
    }                
    .enc1 th{
        background:#046496;
        color:white;
        font-weight:bolder;  
        text-align:center; 
        padding:2px; 

    }
</style>
<section class="content-header">

  <ul class="nav nav-tabs" style="margin-top:-10px ">
    <li class="active"><a data-toggle="tab" href="#home">RETIRADOS</a></li>
    <li><a data-toggle="tab" href="#menu1">INSCRITOS</a></li>
    <form action="retirados" method="POST">
        {{csrf_field()}}
        <button name="btn_xls" class="btn btn-success pull-right" value="btn_xls"><span class="fa fa-file-excel-o"></span> Exportar</button>
    </form>
  </ul>


</section>
<div class="content" style="margin-top:-15px ">
    <div class="box box-primary">
        <div class="box-body">

  <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <table id="tabla" >
            <thead>
                <tr>
                    <th colspan="2" align="center" valign="middle">
                        <img src="img/colegio.png" width="40px" />
                    </th>
                    <th colspan="10">
                        <h3>LISTA DE ESTUDIANTES RETIRADOS</h3>
                    </th>
                </tr>
                <tr>
                    <th colspan="7"><h3>Año Lectivo: {{$anl_select[0]['anl_descripcion']}}</h3></th>
                    <th colspan="9"><h3>Sección: GUAMANI</h3></th>
                </tr>
                <tr class="enc1">
                    <th width="5px">No</th>
                    <th>Cedula</th>
                    <th>Estudiante</th>
                    <th>Jornada</th>
                    <th>Especialidad</th>
                    <th>Curso</th>                        
                    <th>Par.Cultural</th>
                    <th>Par.Técnico</th>
                    <th>Fecha Asist</th>
                    <th>Fecha de Retiro</th>
                    <th>Motivo</th>
                    <th>Responsable</th>
                    <th>Estado</th>                        
                </tr>
            </thead>
            <tbody>
                <?php $n = 1; ?>
                @foreach($estudiantes as $estudiante)
                <tr>
                    <td >{{$n++}}</td>
                    <td><?php echo $estudiante->est_cedula ?></td>
                    <td><?php echo $estudiante->est_apellidos . " " . $estudiante->est_nombres ?></td>
                    <td><?php echo $estudiante->jor_descripcion ?></td>
                    <td><?php echo $estudiante->esp_descripcion ?></td>
                    <td><?php echo $estudiante->cur_descripcion ?></td>
                    <td><?php echo $estudiante->mat_paralelo ?></td>
                    <td><?php echo $estudiante->mat_paralelot ?></td>
                    <td><?php echo $estudiante->fecha_asistencia ?></td>
                    <td><?php echo $estudiante->fecha_accion ?></td>
                    <td><?php echo $estudiante->motivo ?></td>
                    <td><?php echo $estudiante->responsable ?></td>
                    <td>
                        @if ($estudiante->mat_estado == 0)
                        {{'Inscrito'}}
                        @elseif($estudiante->mat_estado == 1)
                        {{'Matriculado'}}
                        @elseif($estudiante->mat_estado == 2)
                        {{'Retirado'}}
                        @elseif($estudiante->mat_estado == 3)
                        {{'Anulado'}}
                        @elseif($estudiante->mat_estado == 4)                
                        {{'Otro'}}
                        @endif                
                    </td>
                </tr>
                @endforeach        
            </tbody>
          </table>
        </div>

        <div id="menu1" class="tab-pane fade in">
          <table id="tabla2" >
            <thead>
                <tr>
                    <th colspan="2" align="center" valign="middle">
                        <img src="img/colegio.png" width="40px" />
                    </th>
                    <th colspan="10">
                        <h3>LISTA DE ESTUDIANTES INSCRITOS</h3>

                    </th>
                </tr>
                <tr>
                    <th colspan="7"><h3>Año Lectivo: {{$anl_select[0]['anl_descripcion']}}</h3></th>
                    <th colspan="9"><h3>Sección: GUAMANI</h3></th>
                </tr>
                <tr class="enc1">
                    <th width="5px">No</th>
                    <th>Cedula</th>
                    <th>Estudiante</th>
                    <th>Jornada</th>
                    <th>Especialidad</th>
                    <th>Curso</th>                        
                    <th>Par.Cultural</th>
                    <th>Par.Técnico</th>
                    <th>Fecha Asist</th>
                    <th>Fecha de Retiro</th>
                    <th>Motivo</th>
                    <th>Responsable</th>
                    <th>Estado</th>                        
                </tr>
            </thead>
            <tbody>
                <?php $n = 1; ?>
                @foreach($inscritos as $estudiante)
                <tr>
                    <td >{{$n++}}</td>
                    <td><?php echo $estudiante->est_cedula ?></td>
                    <td><?php echo $estudiante->est_apellidos . " " . $estudiante->est_nombres ?></td>
                    <td><?php echo $estudiante->jor_descripcion ?></td>
                    <td><?php echo $estudiante->esp_descripcion ?></td>
                    <td><?php echo $estudiante->cur_descripcion ?></td>
                    <td><?php echo $estudiante->mat_paralelo ?></td>
                    <td><?php echo $estudiante->mat_paralelot ?></td>
                    <td><?php echo $estudiante->fecha_asistencia ?></td>
                    <td><?php echo $estudiante->fecha_accion ?></td>
                    <td><?php echo $estudiante->motivo ?></td>
                    <td><?php echo $estudiante->responsable ?></td>
                    <td>
                        @if ($estudiante->mat_estado == 0)
                        {{'Inscrito'}}
                        @elseif($estudiante->mat_estado == 1)
                        {{'Matriculado'}}
                        @elseif($estudiante->mat_estado == 2)
                        {{'Retirado'}}
                        @elseif($estudiante->mat_estado == 3)
                        {{'Anulado'}}
                        @elseif($estudiante->mat_estado == 4)                
                        {{'Otro'}}
                        @endif                
                    </td>
                </tr>
                @endforeach        
            </tbody>
          </table>
        </div>

  </div>




        </div>
    </div>
</div>
@endsection
