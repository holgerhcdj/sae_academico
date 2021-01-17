<?php
if(isset($novedadesInspeccion)){
    $aut=$novedadesInspeccion->usu_id;
    $fecha=$novedadesInspeccion->fecha;
}else{
    $aut=Auth::User()->id;
    $fecha=date('Y-m-d');
}

?>
<script type="text/javascript">

$(document).ready(function() {
  $(".sel-status").select2();

  if($("#derivado_a").val()==0 || $("#derivado_a").val()==1 || $("#derivado_a").val()==2){
        $("#departamento").attr('disabled',true);        
        $("#departamento").val(null);        
    }else{
        $("#departamento").attr('disabled',false);        
        }
});

$(document).on("change","#derivado_a",function(){

    if($("#derivado_a").val()==0 || $("#derivado_a").val()==1 || $("#derivado_a").val()==2){
        $("#departamento").attr('disabled',true);        
        $("#departamento").val(null);        
    }else{
        $("#departamento").attr('disabled',false);        
        }

});

function validar(){

     if($("#derivado_a").val()==3 && $("#departamento").val().length==0 ){
        alert('Campo Requerido');
        $("#departamento").select();
        $("#departamento").css('border','solid 1px brown');
        return false;
    }
    
}

</script>

<!-- Mat Id Field -->
<div class="form-group col-sm-5">
    {!! Form::label('mat_id', 'Estudiante:') !!}
    {!! Form::select('mat_id',$estud, null, ['class' => 'form-control sel-status']) !!}
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::date('fecha', $fecha, ['class' => 'form-control']) !!}
</div>

<!-- Usu Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id',$aut, ['class' => 'form-control']) !!}
</div>


<!-- Novedad Field -->
<div class="form-group col-sm-4">
    <label for="novedad">Novedad<span class="text-danger"> (Max 35 Caracteres)</span></label>

    {!! Form::select('novedad',[
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

    ],null, ['class' => 'form-control','maxlength'=>35,'required', 'rows' => '4']) !!}




</div>

<div class="col-sm-12">
    
</div>

<!-- Acciones Field -->
<div class="form-group col-sm-5">
    {!! Form::label('acciones', 'Acciones:') !!}
    {!! Form::select('acciones',[
    'NOTIFICAR AL REPRESENTANTE'=>'NOTIFICAR AL REPRESENTANTE',
    'ACTA DE COMPROMISO'=>'ACTA DE COMPROMISO',
    'LLAMADO DE ATENCION VERBAL AL ESTUDIANTE'=>'LLAMADO DE ATENCION VERBAL AL ESTUDIANTE',
    ],null, ['class' => 'form-control', 'required', 'rows' => '4']) !!}
</div>

<!-- Recomendaciones Field -->
<div class="form-group col-sm-4" hidden>
    {!! Form::label('recomendaciones', 'Recomendaciones:') !!}
    {!! Form::textarea('recomendaciones','NA', ['class' => 'form-control', 'required', 'rows' => '4']) !!}
</div>

<!-- Reportada A Field -->
<div class="form-group col-sm-4">
    {!! Form::label('reportada_a', 'Reportada A:') !!}
    {!! Form::select('reportada_a',['NINGUNO'=>'NINGUNO','INSPECCIÓN GENERAL'=>'INSPECCIÓN GENERAL'],null, ['class' => 'form-control', 'required']) !!}
</div>
<div class="col-sm-12">
    
</div>
<!-- Derivado A Field -->
<div class="form-group col-sm-5">
    {!! Form::label('derivado_a', 'Derivado A:') !!}
    {!! Form::select('derivado_a',[
        '0' => 'DECE',
        '1' => 'CAPELLANÍA',
        '2' => 'REPRESENTANTE',
        '3' => 'SIN DERIVACIÓN',
        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Departamento Field (Verificar)-->
<div class="form-group col-sm-4">
    {!! Form::label('departamento', 'Departamento Externo:') !!}
    {!! Form::text('departamento', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado',[

        '0' => 'Activo',
        '1' => 'Inactivo',

        ] ,null, ['class' => 'form-control']) !!}
</div>

<!-- Envio Sms Field -->
<div class="form-group col-sm-5">
    {!! Form::label('envio_sms', 'Envío Sms:',['class'=>'text-danger']) !!}
    {!! Form::select('envio_sms',[

        '0' => 'No Enviar',
        '1' => 'Enviar',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Envio Detalle Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('envio_detalle', 'Envío Detalle:') !!}
    {!! Form::text('envio_detalle', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Sms Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('estado_sms', 'Estado Sms:') !!}
    {!! Form::select('estado_sms',[

        '0' => 'Enviado',
        '1' => 'No Enviado',

        ],null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('novedadesInspeccions.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
