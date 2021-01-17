<?php
$dlu=false;
$dma=false;
$dmi=false;
$dju=false;
$dvi=false;
$dsa=false;
$ddo=false;   
 if(isset($jornadasLaborables)){
    $jornadasLaborables->jrl_lun==1?$dlu=true:'';
    $jornadasLaborables->jrl_mar==1?$dma=true:'';
    $jornadasLaborables->jrl_mie==1?$dmi=true:'';
    $jornadasLaborables->jrl_jue==1?$dju=true:'';
    $jornadasLaborables->jrl_vie==1?$dvi=true:'';
    $jornadasLaborables->jrl_sab==1?$dsa=true:'';
    $jornadasLaborables->jrl_dom==1?$ddo=true:'';
 }
?>
<style>
    #tbl_dias tr td{
        padding:10px; 
    }
</style>
<!-- Jrl Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('jrl_descripcion', 'Descripcion:') !!}
    {!! Form::text('jrl_descripcion', null, ['class' => 'form-control']) !!}
</div>
<!-- Jrl Desde Field -->
<div class="form-group col-sm-3">
    {!! Form::label('jrl_desde', 'H Inicio:') !!}
    {!! Form::time('jrl_desde', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('jrl_hasta', 'H Fin:') !!}
    {!! Form::time('jrl_hasta', null, ['class' => 'form-control']) !!}
</div>
<table id="tbl_dias">
    <tr>
        <td>
            {!! Form::label('jrl_lun', 'Lun:') !!}
            {!! Form::checkbox('jrl_lun',null,$dlu) !!}
        </td>
        <td>
            {!! Form::label('jrl_mar', 'Mar:') !!}
            {!! Form::checkbox('jrl_mar',null,$dma) !!}
        </td>
        <td>
            {!! Form::label('jrl_mie', 'Mie:') !!}
            {!! Form::checkbox('jrl_mie', null,$dmi) !!}
        </td>
        <td>
            {!! Form::label('jrl_jue', 'Jue:') !!}
            {!! Form::checkbox('jrl_jue',null,$dju) !!}
        </td>
        <td>
            {!! Form::label('jrl_vie', 'Vie:') !!}
            {!! Form::checkbox('jrl_vie', null,$dvi) !!}
        </td>
        <td>
            {!! Form::label('jrl_sab', 'Sab:') !!}
            {!! Form::checkbox('jrl_sab',null ,$dsa) !!}
        </td>
        <td>
            {!! Form::label('jrl_dom', 'Dom:') !!}
            {!! Form::checkbox('jrl_dom',null,$ddo) !!}
        </td>
    </tr>
</table>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('jornadasLaborables.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
