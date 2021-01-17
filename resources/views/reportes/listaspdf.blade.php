<style>
    @page {
        margin-top: 1.5em;
        margin-left: 2em;
        font-family:"Arial"; 
        font-size:12px;
    }
    table{
        border-collapse:collapse; 
    }
    #tabla tr td, .enc1 th{
        border: 1px solid #000000;

    }
    .enc1{
        text-align:center;  
    }
    h1{
        font-size:15px; 
    }
    img{
        position:fixed; 
        top:0px; 
    }
</style>

<img src="img/colegio.png" width="70px" />
<table id="tabla" style="width:100%; " >
    <thead>
        <tr><th colspan="27" align="center"><h1>UNIDAD EDUCATIVA TÉCNICA "VIDA NUEVA"</h1></th></tr>
        <tr><th colspan="27" align="center"><h1>LISTA DE ESTUDIANTES</h1></th></tr>
        <tr><th colspan="27"><hr></th></tr>
        <tr>
            <th colspan="27" >
                <span style="margin-left:0px;">Año Lectivo: {{$anl_select[0]['anl_descripcion']}}</span>
                @if($busqueda['esp']>0)
                <span style="margin-left:15%;">Sección: GUAMANI</span>
                <span style="margin-left:15%;">Especialidad: {{$especialidad['esp_descripcion']}}</span>
                @else
                <span style="margin-left:15%;">Sección: GUAMANI</span>
                @endif
            </th>
        </tr>
        <tr>
            <th colspan="27">
                <span style="margin-left:0px;">Jornada: {{$jornada['jor_descripcion']}}</span>
                <span style="margin-left:15%;">Curso: {{$curso['cur_descripcion']}}</span>
                @if($busqueda['esp']>0)
                <span style="margin-left:15%;">Paralelo T: {{$busqueda['part']}}</span>
                @else
                <span style="margin-left:15%;">Paralelo C: {{$busqueda['parc']}}</span>
                @endif
            </th>
        </tr>        
        <tr><th colspan="27">&nbsp;</th></tr>

        <tr class="enc1">
            <th>No</th>
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
<script type="text/php">
    if (isset($pdf)) {
        $x = 290;
        $y = 770;
        $text = "{PAGE_NUM}/{PAGE_COUNT}";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>