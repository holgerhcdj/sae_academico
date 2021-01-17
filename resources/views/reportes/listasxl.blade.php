<style>
    table{
        border-collapse:collapse; 
    }
    #tabla tr td, .enc1 th{
        border: 1px solid #000000;

    }
    .enc1{
        text-align:center;  
    }
    .celda{
        width:5px; 
    }

</style>


<table id="tabla" >
    <thead>
        <tr>
            <th colspan="27" align="center" valign="middle">
                <img src="img/colegio.png" width="120px" height="70px" />
                UNIDAD EDUCATIVA TÉCNICA "VIDA NUEVA"
            </th>
        </tr>
        <tr><th colspan="27" align="center"><h2>LISTA DE ESTUDIANTES</h2></th></tr>
        <tr>
            <th colspan="7"><h3>Año Lectivo: {{$anl_select[0]['anl_descripcion']}}</h3></th>
            @if($busqueda['esp']>0)
            <th colspan="9"><h3>Sección: GUAMANI</h3></th>
            <th colspan="11"><h3>Especialidad: {{$especialidad['esp_descripcion']}}</h3></th>
            @else
            <th colspan="20"><h3>Sección: GUAMANI</h3></th>
            @endif
        </tr>
        <tr>
            <th colspan="7" align="left"><h3>Jornada: {{$jornada['jor_descripcion']}}</h3></th>
            <th colspan="9" align="left"><h3>Curso: {{$curso['cur_descripcion']}}</h3></th>
            @if($busqueda['esp']>0)
            <th colspan="11"><h3>Paralelo T: {{$busqueda['part']}}</h3></th>            
            @else
            <th colspan="11"><h3>Paralelo C: {{$busqueda['parc']}}</h3></th>
            @endif
        </tr>
        <tr class="enc1">
            <th width="5px">No</th>
            <th width="300px" >Estudiante</th>
            <th>L</th>
            <th>M</th>
            <th>M</th>
            <th>J</th>
            <th>V</th>
            <th>L</th>
            <th>M</th>
            <th>M</th>
            <th>J</th>
            <th>V</th>
            <th>L</th>
            <th>M</th>
            <th>M</th>
            <th>J</th>
            <th>V</th>
            <th>L</th>
            <th>M</th>
            <th>M</th>
            <th>J</th>
            <th>V</th>
            <th>L</th>
            <th>M</th>
            <th>M</th>
            <th>J</th>
            <th>V</th>
        </tr>
    </thead>
    <tbody>
        <?php $n = 1; ?>
        @foreach($estudiantes as $estudiante)
        <tr>
            <td >{{$n++}}</td>
            <td><?php echo $estudiante->est_apellidos . " " . $estudiante->est_nombres ?></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
            <td class="celda"></td>
        </tr>
        @endforeach        
    </tbody>
</table>
