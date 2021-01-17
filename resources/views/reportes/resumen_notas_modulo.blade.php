                <table class="table" style="width:auto; ">
                  <tr>
                    <th colspan="7">Reporte estudiantes sin supletorio</th>
                  </tr>
                  <tr>
                    <th>#</th>
                    <th>Jornada</th>
                    <th>Especialidad</th>
                    <th>Curso</th>
                    <th>Paralelo</th>
                    <th>Estudiante</th>
                    <th>Nota</th>
                  </tr>
                  <?php $x=1?>
                  @foreach($dt as $d)
                  <tr>
                    <td>{{$x++}}</td>
                    <td>{{$d->jor_descripcion}}</td>
                    <td>{{$d->esp_descripcion}}</td>
                    <td>{{$d->cur_descripcion}}</td>
                    <td>{{$d->mat_paralelot}}</td>
                    <td>{{$d->est_apellidos.' '.$d->est_nombres}}</td>
                    <td>{{$d->nota}}</td>
                  </tr>
                  @endforeach
                </table>
