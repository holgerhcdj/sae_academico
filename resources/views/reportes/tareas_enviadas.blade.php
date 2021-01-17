                <table class="table" style="width:auto; ">
                  <tr>
                    <th colspan="7">REPORTE DE TAREAS DE TAREAS ENVIADAS POR DOCENTE</th>
                  </tr>
                  <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Fecha Registro</th>
                    <th>Departamento</th>
                    <th>Especilidad</th>
                    <th>Docente</th>
                    <th>Materia/Módulo</th>
                    <th>Jornada/Especialidad/Curso</th>
                    <th>Rango Fecha</th>
                  </tr>
                  <?php $x=1?>
                  @foreach($tar as $t)
                  <tr>
                    <td>{{$x++}}</td>
                    <td>{{$t->tar_codigo}}</td>
                    <td>{{$t->tru_date}}</td>
                    <td>{{$t->esp_descripcion}}</td>
                    <td>{{$t->descripcion}}</td>
                    <td>{{$t->usu_apellidos.' '.$t->name}}</td>
                    <td>{{$t->mtr_descripcion}}</td>
                    <td>{{$t->tar_cursos}}</td>
                    <td>{{'Del '.$t->tar_finicio.' al '.$t->tar_ffin}}</td>
                    
                  </tr>
                  @endforeach
                </table>
