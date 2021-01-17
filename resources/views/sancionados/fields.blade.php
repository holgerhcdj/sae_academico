<?php
if(isset($dt)){
    $matid=$dt['mat_id'];
    $usuid=Auth::user()->id;
    $usu_seg=Auth::user()->id;
    $freg=date('Y-m-d');
    $fi=date('Y-m-d');
    $ff=date('Y-m-d');
    $fd_susp=null;
    $fh_susp=null;
}else{
    $matid=$sancionados->mat_id;
    $usuid=$sancionados->usu_id;
    $freg=$sancionados->snc_fecha;
    $fd_susp=$sancionados->snc_desde;
    $fh_susp=$sancionados->snc_hasta;
    $usu_seg=$sancionados->usu_new_id;
    $fi=$sancionados->snc_finicio;
    $ff=$sancionados->snc_ffin;

}
?>
<!-- Mat Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('mat_id', 'Mat Id:') !!}
    {!! Form::number('mat_id',$matid, ['class' => 'form-control']) !!}
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id',$usuid, ['class' => 'form-control']) !!}
    {!! Form::label('snc_hora_reg', 'Snc Hora Reg:') !!}
    {!! Form::text('snc_hora_reg', null, ['class' => 'form-control']) !!}
    {!! Form::label('snc_fecha', 'Fecha:') !!}
    {!! Form::date('snc_fecha',$freg, ['class' => 'form-control']) !!}
</div>
<!-- Snc Motivo Field -->
<div class="form-group col-sm-4">
    {!! Form::label('snc_motivo', 'Motivo:') !!}
    {!! Form::select('snc_motivo',[
    ''=>'Elija una Opción',
    'MAL UNIFORMADO'=>'MAL UNIFORMADO',
    'FUGA INTERNA'=>'FUGA INTERNA',
    'FUGA EXTERNA'=>'FUGA EXTERNA',
    'MAL COMPORTAMIENTO DENTRO DEL AULA'=>'MAL COMPORTAMIENTO DENTRO DEL AULA',
    'MAL COMPORTAMIENTO FUERA DEL AULA'=>'MAL COMPORTAMIENTO FUERA DEL AULA',
    'MAL COMPORTAMIENTO ENTRE COMPANIEROS'=>'MAL COMPORTAMIENTO ENTRE COMPANIEROS',
    'MAL COMPORTAMIENTO CON EL DOCENTE'=>'MAL COMPORTAMIENTO CON EL DOCENTE',
    'MAL COMPORTAMIENTO CON LAS AUTORIDADES'=>'MAL COMPORTAMIENTO CON LAS AUTORIDADES',
    'DANIO A LA INFRAESTRUCTURA GRAFITIS'=>'DANIO A LA INFRAESTRUCTURA GRAFITIS',
    'DANIO A LA INFRAESTRUCTURA ROTURA DE VIDRIOS'=>'DANIO A LA INFRAESTRUCTURA ROTURA DE VIDRIOS',
    'DANIO A LA INFRAESTRUCTURA DE PUERTAS'=>'DANIO A LA INFRAESTRUCTURA DE PUERTAS',
    'DANIO A LA INFRAESTRUCTURA DE BATERIAS SANITARIAS'=>'DANIO A LA INFRAESTRUCTURA DE BATERIAS SANITARIAS',
    'DANIO A LA INFRAESTRUCTURA ROTURA DE BALDOSAS'=>'DANIO A LA INFRAESTRUCTURA ROTURA DE BALDOSAS',
    'DANIO A LA INFRAESTRUCTURA TACHOS DE BASURA EXTERNOS'=>'DANIO A LA INFRAESTRUCTURA TACHOS DE BASURA EXTERNOS',
    'DANIO A LA INFRAESTRUCTURA ROTURA DE CIELO RAZO'=>'DANIO A LA INFRAESTRUCTURA ROTURA DE CIELO RAZO',

    ] ,null, ['class' => 'form-control']) !!}
</div>
<!-- Snc Resolucion Field -->
<div class="form-group col-sm-4">
    {!! Form::label('snc_resolucion', 'Sanción:') !!}
    {!! Form::select('snc_resolucion',[
    ''=>'Elija una Opción',
    '0'=>'Suspención de clases',
    '1'=>'Cambio de Jornada',
    '2'=>'Trabajo Comunitario',
    '3'=>'Asistencia a Capellanía'],null, ['class' => 'form-control']) !!}
</div>
<!-- Snc Fecha Field -->
<div class="form-group col-sm-2">
    {!! Form::label('snc_finicio', 'Fecha Inicio:') !!}
    {!! Form::date('snc_finicio',$fi, ['class' => 'form-control']) !!}
</div>
<!-- Snc Fecha Field -->
<div class="form-group col-sm-2">
    {!! Form::label('snc_ffin', 'Fecha Fin:') !!}
    {!! Form::date('snc_ffin',$ff, ['class' => 'form-control']) !!}
</div>

<!-- Snc Asistencia Field -->
<div class="form-group col-sm-4">
    {!! Form::label('snc_asistencia', 'Suspende Asistencia a clases?:') !!}
    {!! Form::select('snc_asistencia',['0'=>'No','1'=>'Si'],null, ['class' => 'form-control']) !!}
</div>
<!-- Snc Desde Field -->
<div class="form-group col-sm-4">
    {!! Form::label('snc_desde', 'Desde:') !!}
    {!! Form::date('snc_desde',$fd_susp, ['class' => 'form-control']) !!}
</div>
<!-- Snc Hasta Field -->
<div class="form-group col-sm-4">
    {!! Form::label('snc_hasta', 'Hasta:') !!}
    {!! Form::date('snc_hasta',$fh_susp, ['class' => 'form-control']) !!}
</div>
<!-- Snc Resolucion Descripcion Field -->
<div class="form-group col-sm-12">
    {!! Form::label('snc_resolucion_descripcion', 'Informe de la sanción:') !!}
    {!! Form::textarea('snc_resolucion_descripcion', null, ['class' => 'form-control','rows'=>2]) !!}
</div>
<!-- Snc Frecuencia Seg Field -->
<div class="form-group col-sm-6">
    {!! Form::label('snc_frecuencia_seg', 'Hacer el seguimiento: (ej:Cada Semana/Al finalizar la sanción):') !!}
    {!! Form::text('snc_frecuencia_seg', null, ['class' => 'form-control']) !!}
</div>
<!-- Usu New Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_new_id', 'Responsable del seguimiento y cumplimiento:') !!}
    {!! Form::select('usu_new_id',$usuarios,$usu_seg, ['class' => 'form-control']) !!}
</div>
<!-- Snc Notificacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('snc_notificacion', 'Enviar Notificacion al representante?:',['class'=>'text-danger']) !!}
    {!! Form::select('snc_notificacion',['0'=>'No','1'=>'Si'],null, ['class' => 'form-control']) !!}
</div>
<!-- Snc Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('snc_estado', 'Estado:') !!}
    {!! Form::select('snc_estado',['0'=>'Registrado','1'=>'En ejecución','2'=>'Anulado','3'=>'Suspendido','4'=>'Finalizado'],null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('sancionados.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
