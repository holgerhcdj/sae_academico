<script type="text/javascript">
$(document).ready(function() {
  $(".sel-status").select2();
});
</script>

<?php
isset($permisosVacaciones)?$f=$permisosVacaciones->f_reg:$f=date('Y-m-d');
isset($permisosVacaciones)?$f_d=$permisosVacaciones->f_reg:$f_d=date('Y-m-d');
isset($permisosVacaciones)?$f_h=$permisosVacaciones->f_reg:$f_h=date('Y-m-d');
?>
<!-- F Reg Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('f_reg', 'FReg:') !!}
    {!! Form::date('f_reg',$f, ['class' => 'form-control']) !!}
</div>
<!-- Usuid Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usuid', 'Usuario:') !!}
    {!! Form::select('usuid', $usuarios , null, ['class' => 'form-control sel-status']) !!}    
</div>
<!-- Tipo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('tipo', 'Tipo:') !!}
    <!-- {!! Form::number('tipo', null, ['class' => 'form-control']) !!} -->
    {!! Form::select('tipo',[
    '0'=>'Permisos',
    '1'=>'Vacaciones',
    ],null, ['class' => 'form-control']) !!}
</div>
<!-- Pagado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pagado', 'Pagado:') !!}
    {!! Form::select('pagado',
    ['0'=>'Si',
    '1'=>'No',
    ],null, ['class' => 'form-control']) !!}
</div>

<!-- F Desde Field -->
<div class="form-group col-sm-3">
    {!! Form::label('f_desde', 'Desde:') !!}
    {!! Form::date('f_desde', $f_d, ['class' => 'form-control']) !!}
</div>
<!-- H Desde Field -->
<div class="form-group col-sm-3">
    {!! Form::label('h_desde', 'Hora:') !!}
    {!! Form::time('h_desde', null, ['class' => 'form-control']) !!}
</div>
<!-- F Hasta Field -->
<div class="form-group col-sm-3">
    {!! Form::label('f_hasta', 'Hasta:') !!}
    {!! Form::date('f_hasta', $f_h, ['class' => 'form-control']) !!}
</div>
<!-- H Hasta Field -->
<div class="form-group col-sm-3">
    {!! Form::label('h_hasta', 'Hora:') !!}
    {!! Form::time('h_hasta', null, ['class' => 'form-control']) !!}
</div>

<!-- Reemplazo Field -->
<div class="form-group col-sm-6 col-lg-6">
    {{ Form::label('reemplazo',"Reemplazo:" ) }}
    {!! Form::text('reemplazo', null, ['class' => 'form-control']) !!}
</div>

<!-- Motivo Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('motivo', 'Motivo:') !!}
    {!! Form::text('motivo', null, ['class' => 'form-control']) !!}
</div>

<!-- Obs Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('obs', 'Obs:') !!}
    {!! Form::text('obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado',
    ['0'=>'Activo',
    '1'=>'Inactivo',
     ],null, ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('permisosVacaciones.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
