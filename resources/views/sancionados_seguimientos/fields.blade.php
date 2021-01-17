<?php
if(isset($dt)){
    $snc=$dt['snc_id'];
    $usuid=Auth::user()->id;
    $freg=date('Y-m-d');
    $fsig=date('Y-m-d');
    $hreg=date('H:s');
    $usu_new=Auth::user()->id;
    //dd($usu_new);
}else{
    $snc=$sancionadosSeguimientos->snc_id;
    $usuid=$sancionadosSeguimientos->usu_id;
    $freg=$sancionadosSeguimientos->sgsnc_fecha;
    $hreg=$sancionadosSeguimientos->sgsnc_hora;
    $fsig=$sancionadosSeguimientos->sgsnc_sig_hora;
    $usu_new=$sancionadosSeguimientos->usu_new_id;
}
?>
<!-- Snc Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('snc_id', 'Snc Id:') !!}
    {!! Form::number('snc_id',$snc, ['class' => 'form-control']) !!}
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id',$usuid, ['class' => 'form-control']) !!}
    {!! Form::label('sgsnc_hora', 'Sgsnc Hora:') !!}
    {!! Form::text('sgsnc_hora', $hreg, ['class' => 'form-control']) !!}
    {!! Form::label('sgsnc_sig_hora', 'Sgsnc Sig Hora:') !!}
    {!! Form::text('sgsnc_sig_hora', null, ['class' => 'form-control']) !!}
</div>

<!-- Sgsnc Fecha Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sgsnc_fecha', 'Fecha Registro:') !!}
    {!! Form::date('sgsnc_fecha',$freg, ['class' => 'form-control']) !!}
</div>
<!-- Sgsnc Accion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sgsnc_accion', 'Tipo de Seguimiento:') !!}
    {!! Form::select('sgsnc_accion',['Acompañamiento'=>'Acompañamiento','Revisión de resultados'=>'Revisión de resultados','Consejería'=>'Consejería'],null, ['class' => 'form-control']) !!}
</div>
<!-- Sgsnc Informe Field -->
<div class="col-sm-12"></div>
<div class="form-group col-sm-6">
    {!! Form::label('sgsnc_informe', 'Informe:') !!}
    {!! Form::textarea('sgsnc_informe', null, ['class' => 'form-control','rows'=>'2']) !!}
</div>
<div class="col-sm-12"></div>
<!-- Sgsnc Recomendacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sgsnc_recomendacion', 'Recomendacion:') !!}
    {!! Form::text('sgsnc_recomendacion', null, ['class' => 'form-control']) !!}
</div>
<div class="col-sm-12"></div>
<!-- Usu New Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('usu_new_id', ' Responsable de siguiente seguimiento') !!}
    {!! Form::select('usu_new_id',$usuarios,$usu_new,['class' => 'form-control']) !!}
</div>
<!-- Sgsnc Sig Fecha Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sgsnc_sig_fecha', 'Fecha siguiente seguimiento:') !!}
    {!! Form::date('sgsnc_sig_fecha', null, ['class' => 'form-control']) !!}
</div>

<!-- Sgsnc Estado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sgsnc_estado', 'Estado:') !!}
    {!! Form::select('sgsnc_estado',['0'=>'Activo','1'=>'Anulado','3'=>'Finalizado'],null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('sancionadosSeguimientos.show',$snc) !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
