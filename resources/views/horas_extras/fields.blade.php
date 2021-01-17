<?php
isset($horasExtras)?$f=$horasExtras->f_reg:$f=date('Y-m-d');
isset($horasExtras)?$al=$horasExtras->anlid:$al=$anl;
isset($horasExtras)?$h=$horasExtras->horas:$h=0;

?>

<script type="text/javascript">
$(document).ready(function() {
  $(".sel-status").select2();
});
</script>
<!-- Usuid Field -->
<div class="form-group col-sm-12 col-lg-12" hidden>
    {!! Form::label('anlid', 'Año Lect:') !!}
    {!! Form::select('anlid',$anios ,$al, ['class' => 'form-control']) !!}
</div>
<!-- F Reg Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('f_reg', 'F Reg:') !!}
    {!! Form::date('f_reg',$f, ['class' => 'form-control']) !!}
</div>
<!-- Usuid Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('usuid', 'Colaborador:') !!}
    {!! Form::select('usuid',$usuarios ,null, ['class' => 'form-control sel-status']) !!}
</div>
<!-- Mes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mes', 'Mes:') !!}
    {!! Form::select('mes',
    [
    '1'=>'Enero',
    '2'=>'Febrero',
    '3'=>'Marzo',
    '4'=>'Abril',
    '5'=>'Mayo',
    '6'=>'Junio',
    '7'=>'Julio',
    '8'=>'Agosto',
    '9'=>'Septiembre',
    '10'=>'Octubre',
    '11'=>'Noviembre',
    '12'=>'Diciembre',
    ]
    ,null, ['class' => 'form-control']) !!}
</div>

<!-- Horas Field -->
<div class="form-group col-sm-6">
    {!! Form::label('horas', 'Horas:') !!}
    {!! Form::number('horas', $h, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- Responsable Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('responsable', 'Responsable:') !!}
    {!! Form::text('responsable',Auth::user()->usu_apellidos.' '.Auth::user()->name , ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>
<!-- Descripcion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('descripcion', 'Descripcion de la Labor realizada:') !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado',['0'=>'Activo','1'=>'InActivo'],null, ['class' => 'form-control']) !!}
</div>



<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('horasExtras.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
