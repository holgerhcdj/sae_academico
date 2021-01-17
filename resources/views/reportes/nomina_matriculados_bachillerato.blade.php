<style>
  #tbl_datos td ,#tbl_datos th{
      border:solid 1px #000;
  }
</style>
  <div id="header_principal">
  <img src="http://181.211.10.10/img/logo_mineduc.png" width="250px" alt="logo mineduc" id="logo_mineduc" >
    <h4 style="text-align:center;margin-top:-12px ">COORDINACIÓN ZONAL 9</h4>
    <h4 style="text-align:center;margin-top:-12px ">{{$conf['distrito']}}</h4>
    <h4 style="text-align:center;margin-top:-12px ">{{$conf['institucion']}} - {{$conf['amie']}}</h4>
    <h4 style="text-align:center;margin-top:-12px ">AÑO LECTIVO {{$conf['anio_lectivo']}}</h4>

    <h5 style="text-align:left;">NIVEL: {{$conf['curso'].' '.$conf['titulo'].' EN '.$conf['esp_descripcion_general']}} Paralelo: '{{$conf['paralelo']}}'  </h5>
    <h5 style="text-align:left;margin-top:-12px ">JORNADA: {{$conf['jornada']}} </h5>

  </div>
    <table id="tbl_datos" >
      <tr>
        <th>N°</th>
        <th>APELLIDOS Y NOMBRES</th>
        <th>MATRÍCULA</th>
        <th>FOLIO</th>
        <th>OBSERVACIONES</th>
      </tr>
      <?php $c=1?>
      @foreach($lista as $l)
      <tr>
        <td>{{$c++}}</td>
        <td>{{$l->est_apellidos.' '.$l->est_nombres}}</td>
        <td style="text-align:right; ">{{$l->mat_id}}</td>
        <td style="text-align:right; ">{{$l->mat_folio}}</td>
        <td></td>
      </tr>
      @endforeach
    </table>
    <br>
<div id="footer">
    <br>
    <br>
    <span >{{$conf['rector']}}</span> <span style="margin-left:15%;">{{$conf['secretaria']}}</span>
    <br>
    <span style="font-weight:bolder; ">RECTOR</span> <span style="margin-left:35%;font-weight:bolder; ">SECRETARIA</span>
 </div>
