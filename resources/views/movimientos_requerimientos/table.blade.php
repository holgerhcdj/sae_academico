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
  <div>
        <div class="form-group col-sm-2" >
                <select name="estado" id="estado" class="form-control">
                    <option value="0">Activo</option>
                    <option value="1">Finalizado</option>
                    <option value="2">Anulado</option>
                </select>
        </div>    
        <div class="form-group col-sm-1" >
           <a class="btn btn-primary pull-right"  href="{{ route('mov_requerimiento/create',['id'=>$usu_id,'estado'=>0,'op'=>$op]) }}">Buscar</a>
        </div>

 </div>
<table class="table table-responsive" id="movimientosRequerimientos-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Fecha/Hora Reg</th>
            <th>Fecha/Hora Fin</th>
            <th>Tiempo</th>            
            <th>Emisor</th>
            <th>Receptor</th>
            <th>Tramite</th>
            <th>Descripcion</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody class="contenidobusqueda">
        @foreach($movimientosRequerimientos as $movimientosRequerimiento)
        <?php
        if ($movimientosRequerimiento->estado == 0) {
            $estado = 'ACTIVO';
        } else if ($movimientosRequerimiento->estado == 1) {
            $estado = 'FINALIZADO';
        } else {
            $estado = 'ANULADO';
        }
        $fr=$movimientosRequerimiento->fecha_registro;
        $hr=$movimientosRequerimiento->hora_registro;
        if(empty($movimientosRequerimiento->fecha_finalizacion)){
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

            $fa=$movimientosRequerimiento->fecha_finalizacion;
            $ha=$movimientosRequerimiento->hora_final;
            $tt= seg_a_dhms($fr." ".$hr,$fa." ".$ha);   
            $dt=explode("&",$tt);         
            $cls="text-muted";

        }

        ?>
        <tr  class="{{$cls}}">
            <td>{!! $movimientosRequerimiento->codigo !!}</td>
            <td>{!! $movimientosRequerimiento->fecha_registro." ".$movimientosRequerimiento->hora_registro !!}</td>
            <td>{!! $movimientosRequerimiento->fecha_finalizacion." ".$movimientosRequerimiento->hora_final !!}</td>
            <td>{!! $dt[0]." dia ".$dt[1]." hrs ".$dt[2]." mn" !!}</td>            
            <td>{!! $movimientosRequerimiento->usu_apellidos.' '. $movimientosRequerimiento->name !!}</td>
            <td>{!! $movimientosRequerimiento->personas !!}</td>
            <td>{!! $movimientosRequerimiento->nombre_tramite!!}</td>
            <td>{!! $movimientosRequerimiento->descripcion!!}</td>
            <td>{!! $estado!!}</td>
            <td>
                <div class='btn-group'>
                    <?php
                    if($movimientosRequerimiento->estado==0){
                        ?>
                        <a href="{!! route('requerimientos/edit', ['id'=>$movimientosRequerimiento->mvr_id,'usu_id'=>$usu_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    <?php
                    }
                    ?>
                    <a href="{!! route('requerimientos/show', ['id'=>$movimientosRequerimiento->req_id,'usu_id'=>$usu_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>