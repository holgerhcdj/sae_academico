  <div id="header_principal">
  <img src="http://181.211.10.10/img/logo_mineduc.png" width="250px" alt="logo mineduc" id="logo_mineduc" >
    <h4 style="text-align:center;">{{$conf['distrito']}}</h4>
    <h4 style="text-align:center;">NÓMINA DE MATRICULADOS DE {{$conf['curso']}}</h4>
    <h3>1.-DATOS DE IDENTIFICACIÓN</h3>
  </div>
  <div id="header_secondary">
    <table >
      <tr><th class="th_head">NOMBRE DEL COLEGIO:</th><td>{{$conf['institucion']}}</td></tr>
      <tr><th class="th_head">AÑO LECTIVO:</th><td>{{$conf['anio_lectivo']}}</td></tr>
      <tr><th class="th_head">JORNADA:</th><td>{{$conf['jornada']}}</td></tr>
      <tr><th class="th_head">AMIE:</th><td>{{$conf['amie']}}</td></tr>
      <tr><th class="th_head">TÍTULO:</th><td>{{$conf['titulo']}}</td></tr>
      <tr><th class="th_head">TIPO DE TÍTULO:</th><td>BACHILLER</td></tr>
      <tr><th class="th_head">ESPECIALIDAD:</th><td>{{$conf['esp_descripcion_general']}}</td></tr>
      <tr><th class="th_head">PARALELO:</th><td>{{$conf['paralelo']}}</td></tr>
    </table>
    <h3>2.-REGISTRO DE ESTUDIANTES</h3>
  </div>
    <table id="tbl_datos" >
      <tr>
        <th>N°</th>
        <th>NÓMINA DE ESTUDIANTES</th>
        <th>N° DE MATRÍCULA</th>
        <th>OBSERVACIONES</th>
        <th>N° DE CELULAR</th>
        <th>CORREO ELECTRÓNICO</th>
      </tr>
      <?php $c=1?>
      @foreach($lista as $l)
      <tr>
        <td>{{$c++}}</td>
        <td>{{$l->est_apellidos.' '.$l->est_nombres}}</td>
        <td style="text-align:right; ">{{$l->mat_id}}</td>
        @if($l->mat_estado==2)
        <td style="text-align:right;">{{'RETIRADO '.$l->fecha_asistencia}}</td>
        @else
        <td style="text-align:right;"></td>
        @endif
        <td>{{$l->est_celular}}</td>
        <td>{{$l->est_email}}</td>
      </tr>
      @endforeach
    </table>
    <br>
    <br>
    <br>
    <div id="footer">
    <span >ELABORADO POR:</span> <span style="margin-left:30%">AVALADO POR:</span>
    <br>
    <br>
    <br>
    <span >{{$conf['secretaria']}}</span> <span style="margin-left:15%;">{{$conf['rector']}}</span>
    <br>
    <span style="font-weight:bolder; ">SECRETARIA</span> <span style="margin-left:35%;font-weight:bolder; ">RECTOR:</span>
  </div>