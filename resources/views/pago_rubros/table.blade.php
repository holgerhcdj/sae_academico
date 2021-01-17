<table class="table table-responsive" id="pagoRubros-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Jornada</th>
            <th>Curso</th>
            <th>Estudiante</th>
            <th>Pagado</th>
            <th>Saldo</th>
            <th>Excluir</th>
        </tr>
    </thead>
    <tbody>
        <?php $t=0;$c=1;$rb="";?>
    @foreach($pagoRubros as $pagoRubros)
        <?php 
            $t+=$pagoRubros->pago;
            if($pagoRubros->pgr_tipo==1 || strlen($pagoRubros->pgr_tipo)==0){
                $rb="";
            }else{
                $rb="disabled";
            }

            if($pagoRubros->pgr_tipo==1){
                $chk="checked";
            }else{
                $chk="";
            }

            if($rubro[0]->rub_id==4 && ($pagoRubros->jor_id==2 || $pagoRubros->jor_id==3 ) ){
                $rubro[0]->rub_valor=20;
            }
            
        ?>
        <tr>
            <td>{{$c++ }}</td>
            <td>{!! $pagoRubros->jor_descripcion !!}</td>
            <td>{!! $pagoRubros->cur_descripcion ." (".$pagoRubros->mat_paralelo.")" !!}</td>
            <td>{!! $pagoRubros->est_apellidos ." ".$pagoRubros->est_nombres !!}</td>
            <td>{!! number_format($pagoRubros->pago,2) !!}</td>
            <td>{!! number_format($rubro[0]->rub_valor-$pagoRubros->pago,2) !!}</td>
            <th>
                <input {{$rb}}  {{$chk}} type="checkbox" class="chk_excluir"  id="{{$pagoRubros->id}}">
            </th>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3"></th>
            <th class="text-right text-danger">Total Recaudado</th>
            <th id="th_total" class="text-danger">{{ number_format($t,2) }}</th>
        </tr>
    </tfoot>
</table>