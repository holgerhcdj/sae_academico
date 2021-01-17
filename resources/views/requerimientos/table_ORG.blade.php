<?php
function seg_a_dhms($fechaInicial,$fechaFinal) { 
$seg = strtotime($fechaFinal) - strtotime($fechaInicial);

    $d = floor($seg / 86400);
    $h = floor(($seg - ($d * 86400)) / 3600);
    $m = floor(($seg - ($d * 86400) - ($h * 3600)) / 60);
    $s = $seg % 60; 
return $d."&".$h."&".$m; 
}
?>
@section('scripts')
<script>
$(document).ready(function () {
   $('#entradafilter').keyup(function () {
      var rex = new RegExp($(this).val(), 'i');
        $('.contenidobusqueda tr').hide();
        $('.contenidobusqueda tr').filter(function () {
            return rex.test($(this).text());
        }).show();
        })
});    
</script>
@endsection
<div class="input-group"> <span class="input-group-addon">BUSCAR</span>
    <input id="entradafilter" type="text" class="form-control">
</div>
<table class="table table-responsive" id="requerimientos-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Emisor</th>  
            <th>Tramite</th>
            <th>Descripcion</th>
            <th>Fecha/Hora/Reg</th>
            <th>Tiempo</th>
            <th>Fecha Finalizacion</th>
            <th>Estado</th>
            <th>Mov</th>
        </tr>
    </thead>
    <tbody class="contenidobusqueda">
        @foreach($requerimientos as $requerimientos)
        <?php
        if ($requerimientos->estado == 0) {
            $estado = 'ACTIVO';
        } else if ($requerimientos->estado == 1) {
            $estado = 'FINALIZADO';
        } else {
            $estado = 'ANULADO';
        }
        $fr=$requerimientos->fecha_registro;
        $hr=$requerimientos->hora_registro;
        if(empty($requerimientos->fecha_finalizacion)){
            $fa=date('Y-m-d');
            $ha=date('H:i:s');
            $tt= seg_a_dhms($fr." ".$hr,$fa." ".$ha);
            $dt=explode("&",$tt);
            if($dt[0]==0){
                $cls="text-success";
            }elseif($dt[0]==1 && $dt[1]<=8){
                $cls="text-success";
            }elseif($dt[0]==1 && $dt[1]>8){
                $cls="text-warning";
            }elseif($dt[0]>=2){
                $cls="text-red";
            }
        }else{

            $fa=$requerimientos->fecha_finalizacion;
            $ha=$requerimientos->hora_final;
            $tt= seg_a_dhms($fr." ".$hr,$fa." ".$ha);   
            $dt=explode("&",$tt);         
            $cls="text-muted";

        }
        ?>
        <tr>
            <td>{!! $requerimientos->codigo !!}</td>
            <td>{!! $requerimientos->usu_apellidos." ".$requerimientos->name !!}</td>
            <td>{!! $requerimientos->nombre_tramite !!}</td>
            <td>{!! $requerimientos->descripcion !!}</td>
            <td>{!! $requerimientos->fecha_registro." ".$requerimientos->hora_registro !!}</td>
            <td>{{ $dt[0].' d '.$dt[1].' h '.$dt[2].' mn ' }}</td>
            <td>{!! $requerimientos->fecha_finalizacion." ".$requerimientos->hora_final !!}</td>
            <td class="{{$cls}}" >{!! $estado !!}</td>
            <td class="text-center">{!! $requerimientos->mv !!}</td>
            <td>
                {!! Form::open(['route' => ['requerimientos.destroy', $requerimientos->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('requerimientos.show', [$requerimientos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach

    </tbody>
</table>