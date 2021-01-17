<script type="text/javascript">
    $(document).on("click","input[name=m_si]",function(){
        if($(this).prop('checked')==true){
            vl=false;
        }else{
            vl=true;
        }
        $('.madre').each(function(){
            $(this).attr('disabled',vl);
        });

    });

    $(document).on("click","input[name=p_si]",function(){
        if($(this).prop('checked')==true){
            vl=false;
        }else{
            vl=true;
        }
        $('.padre').each(function(){
            $(this).attr('disabled',vl);
        });

    });


    $(document).on("click","input[name=sa_si]",function(){
        if($(this).prop('checked')==true){
            vl=false;
        }else{
            vl=true;
        }
        $('.enfermedad').each(function(){
            $(this).attr('disabled',vl);
        });

    });


    $(document).on("click","input[name=es_discapacidad]",function(){
        if($(this).prop('checked')==true){
            vl=false;
        }else{
            vl=true;
        }
        $('.discapacidad').each(function(){
            $(this).attr('disabled',vl);
        });

    });
    
    
    
</script>
<style type="text/css">
    .form-group{
        margin:0px;
        border:0px solid;  
    }
    .divisor{
        background-color:#eee; 
        border:solid 1px #ccc; 
        text-align:center;
        margin-top:5px; 
        font-weight:bolder;   
    }
</style>

<!-- Mat Id Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('mat_id', 'Mat Id:') !!}
    {!! Form::number('mat_id', null, ['class' => 'form-control ']) !!}
</div>

<!-- M Si Field -->
<span class="divisor col-sm-12">
DATOS DE LA MADRE
{!! Form::checkbox('m_si',null, ['class' => 'form-control']) !!}
</span>
<!-- M Apellidos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_apellidos', 'Apellidos:') !!}
    {!! Form::text('m_apellidos', null, ['class' => 'form-control madre']) !!}
</div>

<!-- M Nombres Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_nombres', 'Nombres:') !!}
    {!! Form::text('m_nombres', null, ['class' => 'form-control madre']) !!}
</div>

<!-- M Tipo Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_tipo_doc', 'Tipo_doc:') !!}
    {!! Form::select('m_tipo_doc',['0'=>'Cedula','1'=>'Pasaporte'],null, ['class' => 'form-control madre']) !!}
</div>

<!-- M Num Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_num_doc', 'Num Doc:') !!}
    {!! Form::text('m_num_doc', null, ['class' => 'form-control madre']) !!}
</div>

<!-- M Edad Field -->
<div class="form-group col-sm-3" >
    {!! Form::label('m_edad', 'Edad:') !!}
    {!! Form::text('m_edad', null, ['class' => 'form-control madre','maxlength'=>'2']) !!}
</div>

<!-- M Est Civil Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_est_civil', 'Est Civil:') !!}
    {!! Form::select('m_est_civil',
    ['0'=>'Soltero',
    '1'=>'Casado',
    '2'=>'Divorciado',
    '3'=>'Viudo',
    '4'=>'Union Libre',
    ],
    null, ['class' => 'form-control madre']) !!}
</div>

<!-- M Instruccion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_instruccion', 'Instruccion:') !!}
    {!! Form::select('m_instruccion',[
    '0'=>'Ninguno',
    '1'=>'Básica Media',
    '2'=>'Básica Superior',
    '3'=>'Bachillerato',
    '4'=>'Superior Técnologo',
    '5'=>'Superior 3er Nivel',
    '6'=>'Superior 4to Nivel',
    '7'=>'Superior 5to Nivel',
    ],null, ['class' => 'form-control madre']) !!}
</div>

<!-- M Profesion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_profesion', 'Profesion:') !!}
    {!! Form::text('m_profesion', null, ['class' => 'form-control madre']) !!}
</div>

<!-- M Ingresos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_ingresos', 'Ingresos:') !!}
    {!! Form::number('m_ingresos', null, ['class' => 'form-control madre']) !!}
</div>

<!-- M Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_telefono', 'Telefono:') !!}
    {!! Form::text('m_telefono', null, ['class' => 'form-control madre','pattern'=>'^02\d{7}$']) !!}
</div>

<!-- M Celular Field -->
<div class="form-group col-sm-3">
    {!! Form::label('m_celular', 'Celular:') !!}
    {!! Form::text('m_celular', null, ['class' => 'form-control madre','pattern'=>'^09\d{8}$']) !!}
</div>

<!-- ///DATOS DEL PADRE/////////////////// -->
<span class="divisor col-sm-12">
DATOS DEL PADRE
{!! Form::checkbox('p_si',null, ['class' => 'form-control']) !!}
</span>

<!-- P Apellidos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_apellidos', 'Apellidos:') !!}
    {!! Form::text('p_apellidos', null, ['class' => 'form-control padre']) !!}
</div>

<!-- P Nombres Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_nombres', 'Nombres:') !!}
    {!! Form::text('p_nombres', null, ['class' => 'form-control padre']) !!}
</div>

<!-- P Tipo Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_tipo_doc', 'Tipo_Doc:') !!}
    {!! Form::select('p_tipo_doc',['0'=>'Cedula','1'=>'Pasaporte'],null, ['class' => 'form-control padre']) !!}
</div>

<!-- P Nup Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_nup_doc', 'Num_Doc:') !!}
    {!! Form::text('p_nup_doc', null, ['class' => 'form-control padre']) !!}
</div>

<!-- P Edad Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_edad', 'Edad:') !!}
    {!! Form::number('p_edad', null, ['class' => 'form-control padre','maxlength'=>'2']) !!}
</div>

<!-- P Est Civil Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_est_civil', 'Estado Civil:') !!}
    {!! Form::select('p_est_civil',
    ['0'=>'Soltero',
    '1'=>'Casado',
    '2'=>'Divorciado',
    '3'=>'Viudo',
    '4'=>'Union Libre',
    ],null, ['class' => 'form-control padre']) !!}
</div>

<!-- P Instruccion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_instruccion', 'Instruccion:') !!}
    {!! Form::select('p_instruccion',[
    '0'=>'Ninguno',
    '1'=>'Básica Media',
    '2'=>'Básica Superior',
    '3'=>'Bachillerato',
    '4'=>'Superior Técnologo',
    '5'=>'Superior 3er Nivel',
    '6'=>'Superior 4to Nivel',
    '7'=>'Superior 5to Nivel',
    ],null, ['class' => 'form-control padre']) !!}
</div>

<!-- P Profesion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_profesion', 'Profesion:') !!}
    {!! Form::text('p_profesion', null, ['class' => 'form-control padre']) !!}
</div>

<!-- P Ingresos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_ingresos', 'Ingresos:') !!}
    {!! Form::number('p_ingresos', null, ['class' => 'form-control padre']) !!}
</div>

<!-- P Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_telefono', 'Telefono:') !!}
    {!! Form::text('p_telefono', null, ['class' => 'form-control padre','pattern'=>'^02\d{7}$']) !!}
</div>

<!-- P Celular Field -->
<div class="form-group col-sm-3">
    {!! Form::label('p_celular', 'Celular:') !!}
    {!! Form::text('p_celular', null, ['class' => 'form-control padre','pattern'=>'^09\d{8}$']) !!}
</div>

<!-- ///DATOS DEL REPRESENTANTE/////////////////// -->
<span class="divisor col-sm-12">
DATOS DEL REPRESENTANTE
{!! Form::checkbox('rp_si',null, ['class' => 'form-control']) !!}
</span>
<!-- Rp Parentezco Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_parentezco', 'Parentezco:') !!}
    {!! Form::text('rp_parentezco', null, ['class' => 'form-control']) !!}
</div>

<!-- Rp Apellidos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_apellidos', 'Apellidos:') !!}
    {!! Form::text('rp_apellidos', null, ['class' => 'form-control']) !!}
</div>

<!-- Rp Nombres Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_nombres', 'Nombres:') !!}
    {!! Form::text('rp_nombres', null, ['class' => 'form-control']) !!}
</div>

<!-- Rp Tipo Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_tipo_doc', 'Tipo Doc:') !!}
    {!! Form::select('rp_tipo_doc',['0'=>'Cedula','1'=>'Pasaporte'],null, ['class' => 'form-control']) !!}
</div>

<!-- Rp Nurp Doc Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_nurp_doc', 'Num Doc:') !!}
    {!! Form::text('rp_nurp_doc', null, ['class' => 'form-control']) !!}
</div>

<!-- Rp Edad Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_edad', 'Edad:') !!}
    {!! Form::text('rp_edad', null, ['class' => 'form-control','maxlength'=>'2']) !!}
</div>

<!-- Rp Est Civil Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_est_civil', 'Est Civil:') !!}
    {!! Form::select('rp_est_civil',
['0'=>'Soltero',
    '1'=>'Casado',
    '2'=>'Divorciado',
    '3'=>'Viudo',
    '4'=>'Union Libre',
    ]    
    ,null, ['class' => 'form-control']) !!}
</div>

<!-- Rp Instruccion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_instruccion', 'Instruccion:') !!}
    {!! Form::select('rp_instruccion',[
    '0'=>'Ninguno',
    '1'=>'Básica Media',
    '2'=>'Básica Superior',
    '3'=>'Bachillerato',
    '4'=>'Superior Técnologo',
    '5'=>'Superior 3er Nivel',
    '6'=>'Superior 4to Nivel',
    '7'=>'Superior 5to Nivel',
    ],null, ['class' => 'form-control']) !!}
</div>

<!-- Rp Profesion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_profesion', 'Profesion:') !!}
    {!! Form::text('rp_profesion', null, ['class' => 'form-control']) !!}
</div>

<!-- Rp Ingresos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_ingresos', 'Ingresos:') !!}
    {!! Form::number('rp_ingresos', null, ['class' => 'form-control']) !!}
</div>

<!-- Rp Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_telefono', 'Telefono:') !!}
    {!! Form::text('rp_telefono', null, ['class' => 'form-control','pattern'=>'^02\d{7}$']) !!}
</div>
<!-- Rp Celular Field -->
<div class="form-group col-sm-3">
    {!! Form::label('rp_celular', 'Celular:') !!}
    {!! Form::text('rp_celular', null, ['class' => 'form-control','pattern'=>'^09\d{8}$']) !!}
</div>

<span class="divisor col-sm-12">
ESTRUCTURA FAMILIAR
</span>

<div class="form-group col-sm-3">
    {!! Form::label('', 'Relación con los Padres:') !!}
</div>

<!-- N Her 8Vo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('n_her_8vo', 'N° Hermanos en 8vo:') !!}
    {!! Form::number('n_her_8vo', null, ['class' => 'form-control']) !!}
</div>

<!-- N Her 9Vo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('n_her_9vo', 'N° Hermanos en 9no') !!}
    {!! Form::number('n_her_9vo', null, ['class' => 'form-control']) !!}
</div>

<!-- N Her 10Vo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('n_her_10vo', 'N° Hermanos en 10mo:') !!}
    {!! Form::number('n_her_10vo', null, ['class' => 'form-control']) !!}
</div>

<!-- N Her 1Vo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('n_her_1vo', 'N° Hermanos en 1ro:') !!}
    {!! Form::number('n_her_1vo', null, ['class' => 'form-control']) !!}
</div>

<!-- N Her 2Vo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('n_her_2vo', 'N° Hermanos en 2do:') !!}
    {!! Form::number('n_her_2vo', null, ['class' => 'form-control']) !!}
</div>

<!-- N Her 3Vo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('n_her_3vo', 'N° Hermanos en 3ero:') !!}
    {!! Form::number('n_her_3vo', null, ['class' => 'form-control']) !!}
</div>
<!-- Ae Primaria Field -->
<span class="divisor col-sm-12">
ANTECEDENTES SOCIOECONOMICOS
</span>
<!-- Sc Tipo Casa Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sc_tipo_casa', 'Tipo Casa:') !!}
    {!! Form::select('sc_tipo_casa',['0'=>'Propia','1'=>'Arrendada','2'=>'Otra'],null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('sc_tipo_construccion', 'Tipo de Construccion:') !!}
    {!! Form::select('sc_tipo_construccion',['0'=>'Hormigón','1'=>'Bloque','2'=>'Ladrillo','3'=>'Mixta'],null, ['class' => 'form-control']) !!}
</div>
<!-- Sc Num Hab Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sc_num_hab', 'Num.Habitaciones:') !!}
    {!! Form::number('sc_num_hab', null, ['class' => 'form-control']) !!}
</div>
<!-- Sc Resp Economica Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sc_resp_economica', 'Responsable de la Economía:') !!}
    {!! Form::select('sc_resp_economica',['Madre'=>'Madre','Padre'=>'Padre','Representante'=>'Representante'], ['class' => 'form-control']) !!}
</div>

<!-- Sc Nivel Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sc_nivel', 'Nivel Economico:') !!}
    {!! Form::select('sc_nivel',['MB'=>'MB','B'=>'B','R'=>'R','M'=>'M'], ['class' => 'form-control']) !!}
</div>
<span class="divisor col-sm-12">
SERVICIOS BÁSICOS
</span>
<!-- Sb Agua Field -->
<div class="form-group col-sm-12">

    {!! Form::label('sb_agua', 'Agua:') !!}
    {!! Form::checkbox('sb_agua', null, ['class' => 'form-control']) !!}
    {!! Form::label('sb_electricidad', 'Luz:') !!}
    {!! Form::checkbox('sb_electricidad', null, ['class' => 'form-control']) !!}    
    {!! Form::label('sb_alcantarillado', 'Alcantarillado:') !!}
    {!! Form::checkbox('sb_alcantarillado', null, ['class' => 'form-control']) !!}
    {!! Form::label('sb_telefono', 'Telefono:') !!}
    {!! Form::checkbox('sb_telefono', null, ['class' => 'form-control']) !!}
    {!! Form::label('sb_internet', 'Internet:') !!}
    {!! Form::checkbox('sb_internet', null, ['class' => 'form-control']) !!}
    {!! Form::label('sb_azfaltado', 'Azfaltado:') !!}
    {!! Form::checkbox('sb_azfaltado', null, ['class' => 'form-control']) !!}

</div>

<span class="divisor col-sm-12">
ANTECEDENTES ESCOLARES
</span>
<div class="form-group col-sm-3">
    {!! Form::label('ae_primaria', 'Primaria:') !!}
    {!! Form::text('ae_primaria', null, ['class' => 'form-control']) !!}
</div>
<!-- Ae Repetidos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_repetidos', 'Años Repetidos:') !!}
    {!! Form::text('ae_repetidos', null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Causa Rep Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_causa_rep', 'Causa de Repetición:') !!}
    {!! Form::text('ae_causa_rep', null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Inst Procedencia Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_inst_procedencia', 'Intitucion de Procedencia:') !!}
    {!! Form::text('ae_inst_procedencia', null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Motivo Cambio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_motivo_cambio', 'Motivo Cambio:') !!}
    {!! Form::text('ae_motivo_cambio', null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Dificultades Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_dificultades', 'Dificultades en alguna materia?:') !!}
    {!! Form::text('ae_dificultades', null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Dif Lectura Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_dif_lectura', 'Presenta Dificultad de Lectura?:') !!}
    {!! Form::select('ae_dif_lectura',['1'=>'NO','0'=>'SI'],null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Dif Escritura Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_dif_escritura', 'Presenta Dificultad de Escritura?:') !!}
    {!! Form::select('ae_dif_escritura',['1'=>'NO','0'=>'SI'],null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Dif Matematica Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_dif_matematica', 'Presenta Dificultad Matematica?:') !!}
    {!! Form::select('ae_dif_matematica',['1'=>'NO','0'=>'SI'],null, ['class' => 'form-control']) !!}
</div>

<!-- Ae Dif Ideas Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ae_dif_ideas', 'Presenta Dificultad de extracción de Ideas?:') !!}
    {!! Form::select('ae_dif_ideas',['1'=>'NO','0'=>'SI'],null, ['class' => 'form-control']) !!}
</div>

<span class="divisor col-sm-12">
ASPECTO PEDAGÓGICO
</span>
<!-- Ap Lugar Estudio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_lugar_estudio', 'Tiene un lugar de estudio:') !!}
    {!! Form::select('ap_lugar_estudio',['0'=>'SI','1'=>'NO'],null, ['class' => 'form-control']) !!}
</div>
<!-- Ap Tipo Lugar Estudio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_tipo_lugar_estudio', 'Lugar Estudio:') !!}
    {!! Form::select('ap_tipo_lugar_estudio',['ESTUDIO'=>'ESTUDIO','HABITACIÓN'=>'HABITACIÓN','COMPARTIDO'=>'COMPARTIDO','NO TIENE'=>'NO TIENE'],null, ['class' => 'form-control']) !!}
</div>
<!-- Ap Apoyo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_apoyo', 'Tiene apoyo académico:') !!}
    {!! Form::select('ap_apoyo',['0'=>'SI','1'=>'NO'],null, ['class' => 'form-control']) !!}
</div>
<!-- Ap Apoyo Nombre Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_apoyo_nombre', 'Persona que Apoya:') !!}
    {!! Form::text('ap_apoyo_nombre', null, ['class' => 'form-control']) !!}
</div>
<!-- Ap Recursos Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_recursos', 'Posee recursos necesarios para el estudio?:') !!}
    {!! Form::select('ap_recursos',['0'=>'SI','1'=>'NO'],null, ['class' => 'form-control']) !!}
</div>

<!-- Ap Horas Estudio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ap_horas_estudio', 'Horas destinadas para el estudio:') !!}
    {!! Form::number('ap_horas_estudio', null, ['class' => 'form-control']) !!}
</div>

<span class="divisor col-sm-12">
ANTECEDENTES DE SALUD
</span>

<div class="form-group col-sm-3">
    {!! Form::label('es_enfermedad1', 'Enfermedad:') !!}
    {!! Form::text('es_enfermedad1', null, ['class' => 'form-control enfermedad']) !!}
</div>

<!-- Es Enfermedad2 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_enfermedad2', 'Enfermedad:') !!}
    {!! Form::text('es_enfermedad2', null, ['class' => 'form-control enfermedad']) !!}
</div>

<!-- Es Enfermedad3 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_enfermedad3', 'Enfermedad:') !!}
    {!! Form::text('es_enfermedad3', null, ['class' => 'form-control enfermedad']) !!}
</div>
<!-- Es Enfermedad4 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_enfermedad4', 'Enfermedad:') !!}
    {!! Form::text('es_enfermedad4', null, ['class' => 'form-control enfermedad']) !!}
</div>

<!-- Es Tratamiento1 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_tratamiento1', 'Tratamiento:') !!}
    {!! Form::textarea('es_tratamiento1', null, ['class' => 'form-control enfermedad','rows'=>'3']) !!}
</div>

<!-- Es Tratamiento2 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_tratamiento2', 'Tratamiento:') !!}
    {!! Form::textarea('es_tratamiento2', null, ['class' => 'form-control enfermedad','rows'=>'3']) !!}
</div>

<!-- Es Tratamiento3 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_tratamiento3', 'Tratamiento:') !!}
    {!! Form::textarea('es_tratamiento3', null, ['class' => 'form-control enfermedad','rows'=>'3']) !!}
</div>

<!-- Es Tratamiento4 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_tratamiento4', 'Tratamiento:') !!}
    {!! Form::textarea('es_tratamiento4', null, ['class' => 'form-control enfermedad','rows'=>'3']) !!}
</div>

<!-- Es Alergias1 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_alergias1', 'Alergias:') !!}
    {!! Form::textarea('es_alergias1', null, ['class' => 'form-control enfermedad','rows'=>'4']) !!}
</div>
<!-- Es Operaciones1 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_operaciones1', 'Operaciones:') !!}
    {!! Form::textarea('es_operaciones1', null, ['class' => 'form-control enfermedad','rows'=>'4']) !!}
</div>
<!-- Es Ant Graves Fmla1 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_ant_graves_fmla1', 'Antecedentes Familiares Graves:') !!}
    {!! Form::textarea('es_ant_graves_fmla1', null, ['class' => 'form-control enfermedad','rows'=>'4']) !!}
</div>

<span class="divisor col-sm-12">
    DISCAPACIDAD
    {!! Form::checkbox('es_discapacidad',null, ['class' => 'form-control discapacidad']) !!}
</span>
<div class="form-group col-sm-2">
    {!! Form::label('es_porcentage_disc', 'Porcentage %:') !!}
    {!! Form::text('es_porcentage_disc',null, ['class' => 'form-control discapacidad']) !!}
</div>
<div class="form-group col-sm-4">
    {!! Form::label('es_tipo_discapacidad', 'Tipo de Discapacidad:') !!}
    {!! Form::text('es_tipo_discapacidad',null, ['class' => 'form-control discapacidad']) !!}
</div>
<div class="form-group col-sm-2">
    {!! Form::label('es_carnet_conadis', 'Carnet del CONADIS:') !!}
    {!! Form::select('es_carnet_conadis',['0'=>'Si','1'=>'No','2'=>'Trámite'],null, ['class' => 'form-control discapacidad']) !!}
</div>
<!-- Es Vive Persona Discapacidad Field -->
<div class="form-group col-sm-4">
    {!! Form::label('es_vive_persona_discapacidad', 'Vive con persona con discapacidad:') !!}
    {!! Form::text('es_vive_persona_discapacidad', null, ['class' => 'form-control discapacidad','placeholder'=>'Madre/Padre/Hermano/Otro']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('es_tratamiento_disc', 'Tratamiento:') !!}
    {!! Form::textarea('es_tratamiento_disc',null,['class' => 'form-control discapacidad','rows'=>'1']) !!}
</div>



<span class="divisor col-sm-12">
    SEGURO
</span>
<!-- Es Tipo Seguro Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_tipo_seguro', 'Tiene Seguro?:') !!}
    {!! Form::select('es_tipo_seguro',['0'=>'NO','1'=>'IESS','2'=>'OTRO'],null, ['class' => 'form-control']) !!}
</div>
<!-- Es Seguro Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_seguro', 'Nombre del Seguro:') !!}
    {!! Form::text('es_seguro', null, ['class' => 'form-control']) !!}
</div>

<!-- Es Observaciones Field -->
<div class="form-group col-sm-6">
    {!! Form::label('es_observaciones', 'Observaciones:') !!}
    {!! Form::textarea('es_observaciones', null, ['class' => 'form-control','rows'=>'1']) !!}
</div>
<!-- Es Maps Field -->
<div class="form-group col-sm-3">
    {!! Form::label('es_maps', 'Croquis:') !!}
    {!! Form::text('es_maps', null, ['class' => 'form-control']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('fichaDeces.index') !!}" class="btn btn-default">Cancel</a>
</div>
