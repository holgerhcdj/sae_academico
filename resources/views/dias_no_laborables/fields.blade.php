<?php
isset($diasNoLaborables)?$f=$diasNoLaborables->f_reg:$f=date('Y-m-d');
isset($diasNoLaborables)?$resp=$diasNoLaborables->responsable:$resp=Auth::user()->name." ".Auth::user()->usu_apellidos;
isset($diasNoLaborables)?$f_d=$diasNoLaborables->f_reg:$f_d=date('Y-m-d');
isset($diasNoLaborables)?$f_h=$diasNoLaborables->f_reg:$f_h=date('Y-m-d');
?>
<!-- F Reg Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('f_reg', 'F Reg:') !!}
    {!! Form::date('f_reg', $f, ['class' => 'form-control']) !!}
</div>
<!-- F Desde Field -->
<div class="form-group col-sm-3">
    {!! Form::label('f_desde', 'F Desde:') !!}
    {!! Form::date('f_desde',$f_d ,['class' => 'form-control']) !!}
</div>
<!-- F Hasta Field -->
<div class="form-group col-sm-3">
    {!! Form::label('f_hasta', 'F Hasta:') !!}
    {!! Form::date('f_hasta',$f_h,['class' => 'form-control']) !!}
</div>
<!-- Estado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado',['0'=>'Activo','1'=>'Inactivo'],null, ['class' => 'form-control']) !!}
</div>
<!-- Responsable Field -->
<div class="form-group col-sm-12 col-lg-12" hidden>
    {!! Form::label('responsable', 'Responsable:') !!}
    {!! Form::text('responsable', $resp, ['class' => 'form-control']) !!}
</div>
<!-- Descripcion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('diasNoLaborables.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
