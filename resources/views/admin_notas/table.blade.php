<?php
    function diferenciaDias($fin)
    {
        $inicio = strtotime(date('Y-m-d'));
        $fin = strtotime($fin);
        $dif = $fin - $inicio;
        $diasFalt = (( ( $dif / 60 ) / 60 ) / 24);
        return ceil($diasFalt);
    }

    //$fin='2019-09-24';
    //print diferenciaDias($fin); //imprime 13

?>
<table class="table table-responsive" id="adminNotas-table">
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Responsable</th>
            <th>Inicio</th>
            <th>Final</th>
            <th style="min-width:80px ">Parcial</th>
            <th>Jornada</th>
            <th>Especialidad</th>
            <th>Curso</th>
            <th>Paralelo</th>
            <th>Materia</th>
            <th>Descripcion</th>
            <th>Insumo</th>
            <th>...</th>
        </tr>
    </thead>
    <tbody>
    @foreach($adminNotas as $ad)
    <?php 
    $df=diferenciaDias($ad->adm_ffinal);
        $cls="";
    if($df==0){
        $cls="bg-red";
    }elseif($df==1){
        $cls="bg-yellow";
    }else{
        $cls="bg-green";
    }
    ?>
        <tr  >
            <td>

                @if($ad->adm_tipo==1)
                {{'Culturales'}}
                @elseif($ad->adm_tipo==2)
                {{'Técnicos'}}
                @elseif($ad->adm_tipo==3)
                {{'Profesor'}}
                @endif
            </td>
            <td style="font-size:10px ">{!! $ad->usu_apellidos.' '.$ad->name !!}</td>
            <td>{!! $ad->adm_finicio !!}</td>
            <td class="{{$cls}}" >{!! $ad->adm_ffinal !!}</td>
            <td>{!! 'Parcial '.$ad->adm_parcial !!}</td>
            <td>
                @if($ad->jor_id==0){{'Todas'}}@else{{$ad->jor_descripcion}}@endif
            </td>
            <td>
                @if($ad->esp_id==0){{'Todas'}}@else{{$ad->esp_descripcion}}@endif
            </td>
            <td>
                @if($ad->cur_id==0){{'Todas'}}@else{{$ad->cur_descripcion}}@endif
            </td>
            <td>
                @if($ad->paralelo==0){{'Todas'}}@else{{$ad->paralelo}}@endif
            </td>
            <td>
                @if($ad->mtr_id==0){{'Todas'}}@else{{$ad->mtr_descripcion}}@endif
            </td>
            <td>{!! $ad->adm_obs !!}</td>
            <td>
                @if($ad->insumo==0){{'Todos'}}
                @elseif($ad->insumo==8)
                {{'5'}}
                @elseif($ad->insumo==12)
                {{'6'}}
                @else
                {{$ad->insumo}}
                @endif
            </td>
            <td>
                {!! Form::open(['route' => ['adminNotas.destroy', $ad->adm_id], 'method' => 'delete']) !!}
                <div class='btn-group'>
<!--                     <a href="{!! route('adminNotas.show', [$ad->adm_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> -->
                    <a href="{!! route('adminNotas.edit', [$ad->adm_id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil text-primary"></i></a>
                    {!! Form::button('<i class="fa fa-minus-circle"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Desea eliminar este registro?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>