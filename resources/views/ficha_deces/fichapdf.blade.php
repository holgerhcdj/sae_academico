<?php
function getAge($birthday) {
    $birth = strtotime($birthday);
    $now = strtotime('now');
    $age = ($now - $birth) / 31536000;
    return floor($age);
}
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{asset('css/print_style.css')}}">
    <style>
body { width: 8.25in;
     height: 110.75in 
    }
.head{
    text-align:center; 
    margin-top:-80px;
    font-size:11px;  
}
.h_font{
    margin-top:10px; 
}
#foto1{
    width:3.5cm; 
    height:3.5cm; 
    border:solid 1px #000;
}
/* cuando vayamos a imprimir ... */
@media print{
    *{ -webkit-print-color-adjust: exact; }
    html{ background: none; padding: 0; }
    body{ box-shadow: none; margin: 0; }
}
@page { margin: 0;}
</style>    
</head>
<body>
    <span><img width="50px" height="60px" src="{{ asset('img/colegio.png') }}"></span>
    <div class="head">
        <div class="h_font" >UNIDAD EDUCATIVA TÉCNICA "VIDA NUEVA"</div>
        <div class="h_font" >Educación de Calidad para un Mundo Competitivo "Telf.2692-206"</div>
        <div class="h_font" >DEPARTAMENTO DE CONCEJERÍA ESTUDIANTIL</div>
    </div>
<br>
    <h1 style="letter-spacing:0px; ">FICHA DE DATOS ACUMULATIVA</h1>
    <div id="foto1">
        
    </div>
    <div style="font-size:12px;margin-top:5px;">Fecha Matrícula:{{$ficha->created_at}}</div>
    <br>
    <div class="cont_table">
        <table>
            <caption style="text-align:left;font-weight:bolder;margin-bottom:10PX;   ">
                1.-DATOS INFORMATIVOS DEL ESTUDIANTE
            </caption>
        <tr>
            <td style="width:250PX">APELLIDOS Y NOMBRES</td>
            <td>{{$ficha->est_apellidos.' '.$ficha->est_nombres}}</td>
        </tr>   
        <tr>
            <td>LUGAR Y FECHA DE NACIMIENTO</td>
            <td>{{$ficha->proc_provincia.' / '.$ficha->est_fnac}}</td>
        </tr>   
        <tr>
            <td>DIRECCION DE DOMICILIO</td>
            <td>{{$ficha->est_direccion}}</td>
        </tr>   
        <tr>
            <td>CORREO</td>
            <td>{{$ficha->est_email}}</td>
        </tr>   
        <tr>
            <td>EDAD</td>
            <td>
                <?php echo getAge($ficha->est_fnac)." años" ?>
            </td>
        </tr>   
        <tr>
            <td>AÑO LECTIVO</td>
            <td>{{$ficha->anl_descripcion}}</td>
        </tr>
        <tr>
            <td>ESPECIALIDAD</td>
            <td>{{$ficha->esp_descripcion}}</td>
        </tr>   
        <tr>
            <td>REPRESENTANTE</td>
            <td>{{$ficha->rp_apellidos.' '.$ficha->rp_nombres}}</td>
        </tr>   
        <tr>
            <td>JORNADA</td>
            <td>{{$ficha->jor_descripcion}}</td>
        </tr>
        <tr>
            <td>CURSO</td>
            <td>{{$ficha->cur_descripcion.' '.$ficha->mat_paralelo}}</td>
        </tr>   
        </table><br>

        <table>
            <caption style="text-align:left;font-weight:bolder;margin-bottom:10PX;   ">
                2.-DATOS FAMILIARES
            </caption>

        <tr>
            <td style="width:250PX">NOMBRE DE LA MADRE</td>
            <td>{{$ficha->m_apellidos.' '.$ficha->m_nombres}}</td>
        </tr>
        <tr>
            <td>NÚMERO DE CÉDULA</td>
            <td>{{$ficha->m_num_doc}}</td>
        </tr>
        <tr>
            <td>EDAD</td>
            <td>{{$ficha->m_edad.' '.'años'}}</td>
        </tr>
        <tr>
            <td>ESTADO CIVÍL</td>
            <td>
                @if($ficha->m_est_civil==0)
                {{'Soltero'}}
                @elseif($ficha->m_est_civil==1)
                {{'Casado'}}
                @elseif($ficha->m_est_civil==2)
                {{'Divorciado'}}
                @elseif($ficha->m_est_civil==3)
                {{'Viudo'}}
                @elseif($ficha->m_est_civil==4)
                {{'Unión Libre'}}
                @endif

            </td>
        </tr>
        <tr>
            <td>INSTRUCCIÓN</td>
            <td>
                @if($ficha->m_instruccion==0)
                {{'Ninguno'}}
                @elseif($ficha->m_instruccion==1)
                {{'Básica Media'}}
                @elseif($ficha->m_instruccion==2)
                {{'Básica Superior'}}
                @elseif($ficha->m_instruccion==3)
                {{'Bachillerato'}}
                @elseif($ficha->m_instruccion==4)
                {{'Superior Tecnológo'}}
                @elseif($ficha->m_instruccion==5)
                {{'Superior 3cer Nivel'}}
                @elseif($ficha->m_instruccion==6)
                {{'Superior 4to Nivel'}}
                @elseif($ficha->m_instruccion==7)
                {{'Superior 5to Nivel'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>PROFESIÓN</td>
            <td>{{$ficha->m_profesion}}</td>
        </tr>
        <tr>
            <td>INGRESOS</td>
            <td>{{$ficha->m_ingresos}}</td>
        </tr>
        <tr>
            <td>TELÉFONO / No.CELULAR</td>
            <td>{{$ficha->m_telefono.' / '.$ficha->m_celular}}</td>
        </tr>

        </table><br>

        <table>
            <tr>
            <td style="width:250PX">NOMBRE DEL PADRE</td>
            <td>{{$ficha->p_apellidos.' '.$ficha->p_nombres}}</td>
        </tr>
        <tr>
            <td>NÚMERO DE CÉDULA</td>
            <td>{{$ficha->p_nup_doc}}</td>
        </tr>
        <tr>
            <td>EDAD</td>
            <td>{{$ficha->p_edad.' '.'años'}}</td>
        </tr>
        <tr>
            <td>ESTADO CIVÍL</td>
            <td>
                @if($ficha->p_est_civil==0)
                {{'Soltero'}}
                @elseif($ficha->p_est_civil==1)
                {{'Casado'}}
                @elseif($ficha->p_est_civil==2)
                {{'Divorciado'}}
                @elseif($ficha->p_est_civil==3)
                {{'Viudo'}}
                @elseif($ficha->p_est_civil==4)
                {{'Unión Libre'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>INSTRUCCIÓN</td>
            <td>
                @if($ficha->p_instruccion==0)
                {{'Ninguno'}}
                @elseif($ficha->p_instruccion==1)
                {{'Básica Media'}}
                @elseif($ficha->p_instruccion==2)
                {{'Básica Superior'}}
                @elseif($ficha->p_instruccion==3)
                {{'Bachillerato'}}
                @elseif($ficha->p_instruccion==4)
                {{'Superior Tecnológo'}}
                @elseif($ficha->p_instruccion==5)
                {{'Superior 3cer Nivel'}}
                @elseif($ficha->p_instruccion==6)
                {{'Superior 4to Nivel'}}
                @elseif($ficha->p_instruccion==7)
                {{'Superior 5to Nivel'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>PROFESIÓN</td>
            <td>{{$ficha->p_profesion}}</td>
        </tr>
        <tr>
            <td>INGRESOS</td>
            <td>{{$ficha->p_ingresos}}</td>
        </tr>
        <tr>
            <td>TELÉFONO / No.CELULAR</td>
            <td>{{$ficha->p_telefono.' / '.$ficha->p_celular}}</td>
        </tr>
        </table><br>

        <table>
            <caption style="text-align:left;font-weight:bolder;margin-bottom:10PX;   ">
                DATOS DEL REPRESENTANTE LEGAL (EN CASO DE NO SER PADRE NI MADRE)
            </caption>

        <tr>
            <td style="width:250PX">NOMBRE</td>
            <td>{{$ficha->rp_apellidos.' '.$ficha->rp_nombres}}</td>
        </tr>
        <tr>
            <td>NÚMERO DE CÉDULA</td>
            <td>{{$ficha->rp_nurp_doc}}</td>
        </tr>
        <tr>
            <td>EDAD</td>
            <td>{{$ficha->rp_edad.' '.'años'}}</td>
        </tr>
        <tr>
            <td>PARENTESCO</td>
            <td>{{$ficha->rp_parentezco}}</td>
        </tr>
        <tr>
            <td>ESTADO CIVÍL</td>
            <td>
                @if($ficha->rp_est_civil==0)
                {{'Soltero'}}
                @elseif($ficha->rp_est_civil==1)
                {{'Casado'}}
                @elseif($ficha->rp_est_civil==2)
                {{'Divorciado'}}
                @elseif($ficha->rp_est_civil==3)
                {{'Viudo'}}
                @elseif($ficha->rp_est_civil==4)
                {{'Unión Libre'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>INSTRUCCIÓN</td>
            <td>
                @if($ficha->rp_instruccion==0)
                {{'Ninguno'}}
                @elseif($ficha->rp_instruccion==1)
                {{'Básica Media'}}
                @elseif($ficha->rp_instruccion==2)
                {{'Básica Superior'}}
                @elseif($ficha->rp_instruccion==3)
                {{'Bachillerato'}}
                @elseif($ficha->rp_instruccion==4)
                {{'Superior Tecnológo'}}
                @elseif($ficha->rp_instruccion==5)
                {{'Superior 3cer Nivel'}}
                @elseif($ficha->rp_instruccion==6)
                {{'Superior 4to Nivel'}}
                @elseif($ficha->rp_instruccion==7)
                {{'Superior 5to Nivel'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>PROFESIÓN</td>
            <td>{{$ficha->rp_profesion}}</td>
        </tr>
        <tr>
            <td>INGRESOS</td>
            <td>{{$ficha->rp_ingresos}}</td>
        </tr>
        <tr>
            <td>TELÉFONO / No.CELULAR</td>
            <td>{{$ficha->rp_telefono.' / '.$ficha->rp_celular}}</td>
        </tr>

        </table><br>

        <table>
            <caption style="text-align:left;font-weight:bolder;margin-bottom:10PX;   ">
                ESTRUCTURA FAMILIAR
            </caption>
        <tr>
            <td style="width:250PX">RELACIÓN CON LOS PADRES</td>
            <td>{{$ficha->ef_relacion_familiar}}</td>
        </tr>
         <tr>
            <td>NÚMERO DE HERMANOS</td>
            <td>{{$ficha->n_her_8vo}}</td>
        </tr>
        <tr>
            <td>CASA PROPIA/ ARRENDADA, etc</td>
            <td>
                @if($ficha->sc_tipo_casa==0)
                {{'Propia'}}
                @elseif($ficha->sc_tipo_casa==1)
                {{'Arrendada'}}
                @elseif($ficha->sc_tipo_casa==2)
                {{'Otra'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>TIPO DE CASA Y NÚMERO DE HABITACIONES</td>
            <td>@if($ficha->sc_tipo_construccion==0)
                {{'Hormigón'}}
                @elseif($ficha->sc_tipo_construccion==1)
                {{'Bloque'}}
                @elseif($ficha->sc_tipo_construccion==2)
                {{'Ladrillo'}}
                @elseif($ficha->sc_tipo_construccion==3)
                {{'Mixta'}}
                @endif
                {{' / '.$ficha->sc_num_hab.' habitaciones'}}</td>
        </tr>
        <tr>
            <td>RESPONSABILIDAD ECONÓMICA DE LA FAMILIA</td>
            <td>{{$ficha->sc_resp_economica}}</td>
        </tr>
        <tr>
            <td>NIVEL SOCIOECONÓMICO (MB-B-R-M)</td>
            <td>{{$ficha->sc_nivel}}</td>
        </tr>
        </table><br>

        <table>
            <caption style="text-align:left;font-weight:bolder;margin-bottom:10PX;   ">
                SERVICIOS BÁSICOS
            </caption>
        <tr>
            <td style="width:250PX">AGUA POTABLE</td>
            <td>
                @if($ficha->sb_agua==0)
                {{'Si'}}
                @elseif($ficha->sb_agua==1)
                {{'No'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>ELECTRICIDAD</td>
            <td>
                @if($ficha->sb_electricidad==0)
                {{'Si'}}
                @elseif($ficha->sb_electricidad==1)
                {{'No'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>ALCANTARILLADO</td>
            <td>
                @if($ficha->sb_alcantarillado==0)
                {{'Si'}}
                @elseif($ficha->sb_alcantarillado==1)
                {{'No'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>TELÉFONO</td>
            <td>
                @if($ficha->sb_telefono==0)
                {{'Si'}}
                @elseif($ficha->sb_telefono==1)
                {{'No'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>INTERNET</td>
            <td>
                @if($ficha->sb_internet==0)
                {{'Si'}}
                @elseif($ficha->sb_internet==1)
                {{'No'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>AZFALTADO</td>
            <td>
                @if($ficha->sb_azfaltado==0)
                {{'Si'}}
                @elseif($ficha->sb_azfaltado==1)
                {{'No'}}
                @endif
            </td>
        </tr>    
        </table><br>

        <table>
            <caption style="text-align:left;font-weight:bolder;margin-bottom:10PX;   ">
                4.-ANTECEDENTES ESCOLARES
            </caption>
        <tr>
            <td style="width:250PX">ESCUELA EN LA CUÁL TERMINÓ PRIMARIA</td>
            <td>{{$ficha->ae_primaria}}</td>
        </tr>
         <tr>
            <td>GRADOS O CURSOS REPETIDOS</td>
            <td>{{$ficha->ae_repetidos}}</td>
        </tr>
         <tr>
            <td>CAUSA</td>
            <td>{{$ficha->ae_causa_rep}}</td>
        </tr>
         <tr>
            <td>INSTITUCIÓN DE LA CUÁL PROVIENE</td>
            <td>{{$ficha->ae_inst_procedencia}}</td>
        </tr>
        <tr>
            <td>MOTIVO DEL CAMBIO</td>
            <td>{{$ficha->ae_motivo_cambio}}</td>
        </tr>
        <tr>
            <td>HA PRESENTADO O PRESENTA DIFILCULTADES EN ALGUNA MATERIA</td>
            <td>{{$ficha->ae_dificultades}}</td>
        </tr>
        <tr>
            <td>HA PRESENTADO DIFILCULTADES EN LECTURA</td>
            <td>
                @if($ficha->ae_dif_lectura==0)
                {{'Si'}}
                @elseif($ficha->ae_dif_lectura==1)
                {{'No'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>HA PRESENTADO DIFILCULTADES EN ESCRITURA</td>
            <td>
                @if($ficha->ae_dif_escritura==0)
                {{'Si'}}
                @elseif($ficha->ae_dif_escritura==1)
                {{'No'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>HA PRESENTADO DIFILCULTADES EN CÁLCULO</td>
            <td>
                @if($ficha->ae_dif_matematica==0)
                {{'Si'}}
                @elseif($ficha->ae_dif_matematica==1)
                {{'No'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>HA PRESENTADO DIFILCULTADES EN EXTACCIÓN DE IDEAS EN TEXTOS</td>
            <td>
                @if($ficha->ae_dif_ideas==0)
                {{'Si'}}
                @elseif($ficha->ae_dif_ideas==1)
                {{'No'}}
                @endif
            </td>
        </tr>         
        </table><br>

        <table>
            <caption style="text-align:left;font-weight:bolder;margin-bottom:10PX;   ">
                5.-ASPECTO PEDAGÓGICO
            </caption>
        <tr>
            <td style="width:250PX">¿TIENE EL ESTUDIANTE UN LUGAR DE ESTUDIO?</td>
            <td>{{$ficha->ap_tipo_lugar_estudio}}</td>
        </tr>
        <tr>
            <td>¿EL ESTUDIANTE TIENE APOYO ACADÉMICO EN SU HOGAR?</td>
            <td>{{$ficha->ap_apoyo_nombre}}</td>
        </tr>
        <tr>
            <td>DISPONE DE RECURSOS ECONÓMICOS Y MATERIALES NECESARIOS PARA EL ESTUDIO</td>
            <td>
                @if($ficha->ap_recursos==0)
                {{'Si'}}
                @elseif($ficha->ap_recursos==1)
                {{'No'}}
                @endif
            </td>
        </tr>
        <tr>
            <td>HORAS DIARIAS DESTINADAS PARA EL ESTUDIO</td>
            <td>{{$ficha->ap_horas_estudio.' horas'}}</td>
        </tr>      
        </table><br>

        <table>
            <caption style="text-align:left;font-weight:bolder;margin-bottom:10PX;   ">
                6.-ESTADO DE SALUD
            </caption>
        <tr>
            <td style="width:250PX">ENFERMEDADES</td>
            <td>{{$ficha->es_enfermedad1}}</td>
        </tr>
        <tr>
            <td>TRATAMINETO</td>
            <td>{{$ficha->es_tratamiento1}}</td>
        </tr>
        <tr>
            <td>ALERGÍAS/OPERACIONES</td>
            <td>{{$ficha->es_alergias1.' / '.$ficha->es_operaciones1}}</td>
        </tr>
        <tr>
            <td>ANTECEDENTES MÉDICOS FAMILIARES GRAVES</td>
            <td>{{$ficha->es_ant_graves_fmla1}}</td>
        </tr>
        <tr>
            <td>EL ESTUDIANTE POSEE DISCAPACIDAD</td>
            <td>{{$ficha->es_tipo_discapacidad.' '.$ficha->es_porcentage_disc.'%'}}</td>
        </tr>
        <tr>
            <td>EL ESTUDIANTE VIVE CON PERSONAS QUE POSEA DISCAPACIDAD</td>
            <td>{{$ficha->es_vive_persona_discapacidad}}</td>
        </tr>
        <tr>
            <td>SEGURO PRIVADO O IESS</td>
            <td>{{$ficha->es_seguro}}</td>
        </tr>      
        </table><br>

        <table>
            <caption style="text-align:left;font-weight:bolder;margin-bottom:10PX;   ">
                7.-CROQUIS DE LA VIVIENDA
            </caption>
        </table>
        <div style="width:18cm; 
    height:12cm; 
    border:solid 1px #000;">   
        </div>

        <p style="font-size: 12px; margin-top: 10px">REFERENCIAS DEL SECTOR:</p>
            <p style="margin-top: 10px">...........................................................................................................................................................
            ...........................................................................................................................................................
            ...........................................................................................................................................................</p>

            <table style="margin-top: 60px">
                <tr>
                    <td><p style="font-size: 12px">Firma del representante</p>
            <p style="margin-top: 30px">_____________________</p></td>
     
                    <td><p style="font-size: 12px">Firma del estudiante</p>
            <p style="margin-top: 30px">_____________________</p></td>
                </tr>
            </table>

            

    </div>
</body>
</html>
