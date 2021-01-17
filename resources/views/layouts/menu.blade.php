<?php
$per_menu = Auth::user()->AsignaPermisos;
//CONFIGURACIONES
$gm_conf="hidden";
$m_anio="hidden";
$m_curso="hidden";
$m_esp="hidden";
$m_insumo="hidden";
$m_jornada="hidden";
$m_usuarios="hidden";
$m_admnotas="hidden";
$m_config_gen="hidden";
$m_modulos="hidden";
$m_sucursales="hidden";
$m_departamentos="hidden";
//MATERIAS
$gm_mat="hidden";
$m_materias="hidden";
$m_asgmat_t="hidden";
//MATRICULAS
$gm_matricula="hidden";
$m_estudiantes="hidden";
$m_cedula="hidden";
//REPORTES
$gm_reportes="hidden";
$m_estadisticas="hidden";
$m_asgmat="hidden";
$m_horarios="hidden";
$m_votaciones="hidden";
$m_retirados="hidden";
//REQUERIMIENTOS
$gm_requerimientos = "hidden";
$m_reg_requerimientos = "hidden";
$m_tramites="hidden";
$m_seguimientos="hidden";
$m_rep_requerimientos="hidden";
//NOTAS
$gm_notas="hidden";
$m_reg_notas="hidden";
$m_notas3ro="hidden";
$m_rep_ingresos_notas="hidden";
$m_subir_notas="hidden";
$m_rpt_notas="hidden";
$m_rpt_adicionales="hidden";
$m_rpt_generales="hidden";
$m_rpt_finales="hidden";



//INSPECCION
$gm_asist="hidden";
$m_asist_gen="hidden";
$m_novedades_insp="hidden";
$m_rep_asistencias="hidden";
$m_reporte_gen_asistencias="hidden";
$m_reg_asistencias="hidden";

//Pensiones
$gm_pensiones="hidden";
$m_vpension="hidden";
$m_ord_pension="hidden";
$m_rep_pagos="hidden";
$m_facturacion="hidden";
$m_reg_pagos="hidden";
$m_rep_pagos_dirigente="hidden";
//Rubros
$gm_rubros="hidden";
$m_rubros="hidden";
//Sistemas
$gm_sistema="hidden";
$m_auditoria="hidden";
$m_avances="hidden";
//RRHH
$gm_rrhh="hidden";
$m_pv="hidden";
$m_he="hidden";
$m_nl="hidden";
$m_ra="hidden";
$m_jornadas_lab="hidden";
//DECE
$gm_dece='hidden';
$m_ficha_dece='hidden';
$m_seguimientos='hidden';
$m_expediente='hidden';
//CAPELLANIA
$gm_capellania='hidden';
$m_seguimiento_est='hidden';
$m_seguimiento_doc='hidden';
$m_visita_hogares='hidden';
$m_reportes_capellania='hidden';
//BODEGAS
$gm_bodegas='hidden';
$m_pro_tipos='hidden';
$m_productos='hidden';
$m_movimientos='hidden';
$m_bodegas='hidden';
//COMUNICACIONES
$gm_comunicaciones='hidden';
$m_sms_mail='hidden';
$m_plantillas='hidden';
//ENCUESTAS
$gm_encuestas='hidden';
$m_reg_encuestas='hidden';
$m_grupos_valoracion='hidden';
$m_ejecutar_encuesta='hidden';
$m_ev_docente='hidden';

foreach ($per_menu as $p){
    $usu=$p->usu_id;
    if($p->grupo==1){
        $gm_conf="";
        if($p->mod_id==1){$m_anio="";}
        if($p->mod_id==2){$m_curso="";}
        if($p->mod_id==3){$m_esp="";}
        if($p->mod_id==4){$m_insumo="";}
        if($p->mod_id==5){$m_jornada="";}
        if($p->mod_id==6){$m_sucursales="";}
        if($p->mod_id==7){$m_usuarios="";}
        if($p->mod_id==8){$m_modulos="";}    
        if($p->mod_id==24){$m_departamentos="";}    
        if($p->mod_id==33){$m_admnotas="";}    
        if($p->mod_id==54){$m_config_gen="";}    
    }
    if($p->grupo==2){
        $gm_mat="";
        if($p->mod_id==9){$m_materias="";}
        if($p->mod_id==15){$m_asgmat="";}
        if($p->mod_id==16){$m_asgmat_t="";}
    }
    if($p->grupo==3){
        $gm_matricula="";
        if($p->mod_id==10){$m_estudiantes="";}
        if($p->mod_id==11){$m_cedula="";}
    }
    if($p->grupo==4){
        $gm_reportes="";
        if($p->mod_id==12){$m_estadisticas="";}
        if($p->mod_id==13){$m_horarios="";}
        if($p->mod_id==14){$m_votaciones="";}
        if($p->mod_id==17){$m_retirados="";}
    }
    if($p->grupo==5){
        $gm_notas="";
        if($p->mod_id==18){$m_rpt_notas="";}        
        if($p->mod_id==21){$m_reg_notas="";}
        if($p->mod_id==22){$m_notas3ro="";}        
        if($p->mod_id==55){$m_subir_notas="";}        
        if($p->mod_id==56){$m_rep_ingresos_notas="";}   

        if($p->mod_id==65){$m_rpt_adicionales="";}        
        if($p->mod_id==66){$m_rpt_generales="";}        
        if($p->mod_id==67){$m_rpt_finales="";}        
        //dd($m_reg_notas);
    }
    if ($p->grupo == 6) {
        $gm_requerimientos = "";
        if ($p->mod_id == 23) {$m_reg_requerimientos= "";}
        if ($p->mod_id == 25) {$m_tramites= "";}
        if ($p->mod_id == 26) {$m_seguimientos= "";}
        if ($p->mod_id == 57) {$m_rep_requerimientos= "";}
    }
    if ($p->grupo == 7) {
        $gm_asist="";
        if ($p->mod_id == 27) {$m_asist_gen= "";}
        if ($p->mod_id == 58) {$m_novedades_insp= "";}
        if ($p->mod_id == 59) {$m_rep_asistencias= "";}
        if ($p->mod_id == 60) {$m_reporte_gen_asistencias= "";}
        if ($p->mod_id == 63) {$m_reg_asistencias= "";}
    }    
    if ($p->grupo == 8) {
        $gm_pensiones="";
        if($p->mod_id==19){$m_vpension="";}
        if($p->mod_id==20){$m_ord_pension="";}    
        if($p->mod_id==30){$m_rep_pagos="";}    
        if($p->mod_id==31){$m_facturacion="";}    
        if($p->mod_id==32){$m_reg_pagos="";}    
        if($p->mod_id==61){$m_rep_pagos_dirigente="";}    

    }    

    if ($p->grupo == 9) {
        $gm_rubros="";
        if($p->mod_id==28){$m_rubros="";}
    }    
    if ($p->grupo == 10) {
        $gm_sistema="";
        if($p->mod_id==29){$m_auditoria="";}
        if($p->mod_id==68){$m_avances="";}
    }    

    if ($p->grupo == 11) {
        $gm_rrhh="";
        if($p->mod_id==34){$m_pv="";}
        if($p->mod_id==35){$m_he="";}
        if($p->mod_id==36){$m_nl="";}
        if($p->mod_id==37){$m_ra="";}
        if($p->mod_id==62){$m_jornadas_lab="";}
    }    
    
    if ($p->grupo == 12) {
        $gm_dece="";
        if($p->mod_id==38){$m_ficha_dece="";}
        if($p->mod_id==39){$m_seguimientos="";}
        if($p->mod_id==40){$m_expediente="";}
    }    

    if ($p->grupo == 13) {
        $gm_capellania="";
        if($p->mod_id==41){$m_seguimiento_est="";}
        if($p->mod_id==42){$m_seguimiento_doc="";}
        if($p->mod_id==43){$m_visita_hogares="";}
        if($p->mod_id==44){$m_reportes_capellania="";}
    }    

    if ($p->grupo == 14) {
        $gm_bodegas="";
        if($p->mod_id==45){$m_pro_tipos="";}
        if($p->mod_id==46){$m_productos="";}
        if($p->mod_id==47){$m_movimientos="";}
        if($p->mod_id==48){$m_bodegas="";}
    }    

    if ($p->grupo == 15) {
        $gm_comunicaciones="";
        if($p->mod_id==49){$m_sms_mail="";}
        if($p->mod_id==50){$m_plantillas="";}
    }    

    if ($p->grupo == 16) {
        $gm_encuestas="";
        if($p->mod_id==51){$m_reg_encuestas="";}
        if($p->mod_id==52){$m_grupos_valoracion="";}
        if($p->mod_id==53){$m_ejecutar_encuesta="";}
        if($p->mod_id==64){$m_ev_docente="";}
    }    



    
}
?>  

<style>
    .treeview-menu .active a{
        /*background:#4F4E4E;*/
    }
</style>

<li class="treeview 
{{ Request::is('anioLectivos*') ? 'active' : 
   Request::is('cursos*') ? 'active': 
   Request::is('insumos*') ? 'active': 
   Request::is('jornadas*') ? 'active': 
   Request::is('sucursales*') ? 'active': 
   Request::is('usuarios*') ? 'active': 
   Request::is('modulos*') ? 'active': 
   Request::is('departamentos*') ? 'active':
   Request::is('adminNotas*') ? 'active':
    
   '' }}" <?PHP echo $gm_conf ?> >
    <a href="#">
        <i class="glyphicon glyphicon-cog "></i> <span>Configuraciones</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li <?PHP echo $m_anio ?> class="{{ Request::is('anioLectivos*') ? 'active' : '' }}">
            <a href="{!! route('anioLectivos.index') !!}"><i class="fa fa-circle"></i><span>Año Lectivo</span></a>
        </li>
        <li <?PHP echo $m_curso ?> class="{{ Request::is('cursos*') ? 'active' : '' }}">
            <a href="{!! route('cursos.index') !!}"><i class="fa fa-circle"></i><span>Cursos</span></a>
        </li>
        <li <?PHP echo $m_esp  ?> class="{{ Request::is('especialidades*') ? 'active' : '' }}">
            <a href="{!! route('especialidades.index',['op'=>0]) !!}"><i class="fa fa-circle"></i><span>Especialidades</span></a>
        </li>
        <li <?PHP echo $m_insumo  ?> class="{{ Request::is('insumos*') ? 'active' : '' }}">
            <a href="{!! route('insumos.index') !!}"><i class="fa fa-circle"></i><span>Insumos</span></a>
        </li>
        <li <?PHP echo $m_jornada ?> class="{{ Request::is('jornadas*') ? 'active' : '' }}">
            <a href="{!! route('jornadas.index') !!}"><i class="fa fa-circle"></i><span>Jornadas</span></a>
        </li>
        <li <?PHP echo $m_sucursales  ?> class="{{ Request::is('sucursales*') ? 'active' : '' }}">
            <a href="{!! route('sucursales.index') !!}"><i class="fa fa-circle"></i><span>Sucursales</span></a>
        </li>
        <li <?PHP echo $m_usuarios ?> class="{{ Request::is('usuarios*') ? 'active' : '' }}">
            <a href="{!! route('usuarios.index') !!}"><i class="fa fa-circle"></i><span>Usuarios</span></a>
        </li>
        <li <?PHP echo $m_modulos ?> class="{{ Request::is('modulos*') ? 'active' : '' }}">
            <a href="{!! route('modulos.index') !!}"><i class="fa fa-circle"></i><span>Modulos</span></a>
        </li>
        <li <?php echo $m_departamentos;?> class="{{ Request::is('departamentos*') ? 'active' : '' }}">
            <a href="{!! route('departamentos.index') !!}"><i class="fa fa-circle"></i><span>Departamentos</span></a>
        </li>

        <li <?php echo $m_admnotas;?> class="{{ Request::is('adminNotas*') ? 'active' : '' }}">
            <a href="{!! route('adminNotas.index') !!}"><i class="fa fa-circle"></i><span>Admin Notas</span></a>
        </li>

        <li <?php echo $m_config_gen;?> class="{{ Request::is('configuraciones*') ? 'active' : '' }}">
            <a href="{!! route('configuraciones.index') !!}"><i class="glyphicon glyphicon-cog"></i><span>Configuraciones</span></a>
        </li>

        <li class="{{ Request::is('parciales*') ? 'active' : '' }}">
            <a href="{!! route('parciales.index') !!}"><i class="fa fa-edit"></i><span>Parciales</span></a>
        </li>

        <li class="{{ Request::is('gerencias*') ? 'active' : '' }}">
            <a href="{!! route('gerencias.index') !!}"><i class="fa fa-edit"></i><span>Gerencias</span></a>
        </li>


    </ul>
</li>  

<li class="treeview  
{{ Request::is('materias*') ? 'active' : 
    Request::is('especialidades*') ? 'active' : 
'' }}" <?PHP echo $gm_mat ?>  >
    <a href="#">
        <i class="fa fa-book "></i> <span>Materias</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li <?PHP echo $m_materias ?> class="{{ Request::is('materias*') ? 'active' : '' }}">
            <a href="{!! route('materias.index') !!}"><i class="fa fa-circle"></i><span>Materias Culturales</span></a>
        </li>
        <li <?PHP echo $m_asgmat_t ?> class="{{ Request::is('especialidades*') ? 'active' :
            Request::is('materiasCursos*') ? 'active' :'' }}">
            <a href="{!! route('especialidades.index',['op'=>1]) !!}"><i class="fa fa-circle"></i><span>Materias Técnicas</span></a>
        </li>
        
    </ul>
</li>  

<li class="treeview {{ Request::is('estudiantes*') ? 'active' : 
                       Request::is('ValidarCedula*') ? 'active' : 
                       Request::is('solicitudMatriculas*') ? 'active' : 
                    '' }}" <?PHP echo $gm_matricula ?> >
    <a href="#">
        <i class="glyphicon glyphicon-user "></i> <span>Matriculas</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li <?PHP echo $m_estudiantes ?> class="{{ Request::is('estudiantes*') ? 'active' : '' }}">
            <a href="{!! route('estudiantes.index') !!}"><i class="fa fa-circle"></i><span>Estudiantes</span></a>
        </li>
        <li <?PHP echo $m_cedula ?> class="{{ Request::is('ValidarCedula*') ? 'active' : '' }}">
            <a href="{{ URL::to('estudiantes/cedula') }}"><i class="fa fa-circle"></i><span>ValidarCedula</span></a>
        </li>


        <li class="{{ Request::is('solicitudMatriculas*') ? 'active' : '' }}">
            <a href="{!! route('solicitudMatriculas.index') !!}"><i class="fa fa-edit"></i><span>Solicitud Matriculas</span></a>
        </li>


    </ul>

</li>  

<li class="treeview {{ Request::is('reportes*') ? 'active' : 
                       Request::is('rep_horarios*') ? 'active': 
                       Request::is('votaciones*') ? 'active' :
                       Request::is('retirados*') ? 'active' :
                       Request::is('estadistica*') ? 'active' :
                       Request::is('regNotas.rep*') ? 'active' 
                       : '' }} " <?PHP echo $gm_reportes ?>>
    <a href="#">
        <i class="glyphicon glyphicon-file "></i> <span>Reportes</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li <?PHP echo $m_estadisticas ?> class="{{ Request::is('reportes*') ? 'active' :Request::is('estadistica*') ? 'active' : '' }}">
            <a href="{!! route('reportes.index') !!}"><i class="fa fa-circle"></i><span>Estadisticas</span></a>
        </li>
        <li <?PHP echo $m_horarios ?> class="{{ Request::is('rep_horarios*') ? 'active' : '' }}">
            <a href="{{ URL::to('rep_horarios') }}"><i class="fa fa-circle"></i><span>Horarios Asignados</span></a>
        </li>
        <li <?PHP echo $m_votaciones ?> class="{{ Request::is('votaciones*') ? 'active' : '' }}">
            <a href="{{ URL::to('votaciones') }}"><i class="fa fa-circle"></i><span>Votaciones</span></a>
        </li>
        <li <?PHP echo $m_retirados ?> class="{{ Request::is('retirados*') ? 'active' : '' }}">
            <a href="{{ URL::to('retirados') }}"><i class="fa fa-circle"></i><span>Retirados</span></a>
        </li>
    </ul>
</li>  

<li class="treeview {{ Request::is('regNotas*') ? 'active' : 
                       Request::is('notasExtras*') ? 'active' : 
                       '' }}" <?PHP echo $gm_notas ?>  >
    <a href="#">
        <i class="glyphicon glyphicon-list-alt "></i> <span>Notas</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li <?php echo $m_reg_notas?> class="{{ Request::is('regNotas') ? 'active' : '' }}" >
            <a href="{!! route('regNotas.index') !!}"><i class="fa fa-circle"></i><span>Reg Notas</span></a>
        </li>
        <li <?php echo $m_notas3ro?>  class="{{ Request::is('notasExtras*') ? 'active' : '' }}" >
            <a href="{!! route('notasExtras.index') !!}"><i class="fa fa-circle"></i><span>Notas 3ro</span></a>
        </li>
        <li <?php echo $m_subir_notas?>  class="{{ Request::is('SubirNotas*') ? 'active' : '' }}">
            <a href="{!! route('subirNotas.index') !!}"><i class="fa fa-circle"></i><span>Subir Notas</span></a>
        </li>
        <li <?php echo $m_rep_ingresos_notas?>  class="{{ Request::is('repingreso.notas*') ? 'active' : '' }}">
            <a href="{!! route('repingreso.notas') !!}" ><i class="fa fa-circle"></i><span>Reporte Ingresos</span></a>
        </li>
        <li <?php echo $m_rpt_notas?> class="{{ Request::is('regNotas.rep') ? 'active' : '' }}">
            <a href="regNotas.rep"><i class="fa fa-circle"></i><span>Reporte de Notas</span></a>
        </li>

        <li <?php echo $m_rpt_adicionales?> class="{{ Request::is('regNotas.rep') ? 'active' : '' }}">
            <a href="reporte_adicional"><i class="fa fa-circle"></i><span>Reportes Adicionales</span></a>
        </li>
        <li <?php echo $m_rpt_generales?> class="{{ Request::is('regNotas.rep') ? 'active' : '' }}">
            <a href="reporte_general_notas"><i class="fa fa-circle"></i><span>Reportes Generales</span></a>
        </li>

        <li <?php echo $m_rpt_finales?> class="{{ Request::is('regNotas.rep') ? 'active' : '' }}">
            <a href="reporte_cuadros_finales"><i class="fa fa-circle"></i><span>Cuadros Finales</span></a>
        </li>

        <li <?php echo $m_rpt_finales?> class="{{ Request::is('regNotas.rep_legalizacion') ? 'active' : '' }}">
            <a href="{!!route('reporte_legalizaciones')!!}"><i class="fa fa-circle"></i><span>Legalizaciones</span></a>
        </li>

    </ul>
</li>  

<li class="treeview {{ Request::is('requerimiento/*') ? 'active' : 
                     Request::is('requerimientos*') ? 'active' : 
                     Request::is('tramites*') ? 'active' : 
                  '' }} " <?PHP echo $gm_requerimientos ?>  >
    <a href="#">
        <i class="glyphicon glyphicon-envelope "></i> 
        <span>Requerimientos
                <span class="badge">{{Session::get('msj')}}</span>
        </span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li <?php echo $m_reg_requerimientos ?> class="{{ 
            Request::is('requerimiento*') ? 'active' : 
            Request::is('requerimientoMovimiento*') ? 'active' : 
            '' }}">
            <a href="{{route('requerimientoMovimiento',['id'=>$usu,'op'=>0]) }}"><i class="fa fa-circle"></i>
                <span>Requerimientos
                    <span class="badge">{{Session::get('msj')}}</span>
            </span></a>
        </li>
        <li <?php echo $m_reg_requerimientos ?> class="{{ 
            Request::is('requerimiento*') ? 'active' : 
            Request::is('*mov_requerimiento*') ? 'active' : 
            Request::is('requerimientoMovimiento*') ? 'active' : 
            '' }}">
            <a href="{{route('requerimientoMovimiento',['id'=>$usu,'op'=>1]) }}"><i class="fa fa-circle"></i><span>Requerimientos CC</span></a>
        </li>

        <li <?php echo $m_seguimientos?> class="{{ Request::is('requerimientos*') ? 'active' : '' }}">
            <a href="{!! route('requerimientos.index') !!}"><i class="fa fa-circle"></i><span>Seguimiento</span></a>
        </li>
        <li <?php echo $m_tramites?> class="{{ Request::is('tramites*') ? 'active' : '' }}">
            <a href="{!! route('tramites.index') !!}"><i class="fa fa-circle"></i><span>Tramites</span></a>
        </li>

        <li <?php echo $m_rep_requerimientos?> class="{{ Request::is('tramites*') ? 'active' : '' }}">
            <a href="{!! route('tramites.show',['id'=>0]) !!}"><i class="fa fa-circle"></i><span>Reporte</span></a>
        </li>

    </ul>
</li>  

<li class="treeview {{ Request::is('asistencias*') ? 'active' : '' }} " <?PHP echo $gm_asist ?>  >
    <a href="#">
        <i class="fa fa-clock-o " aria-hidden="true"></i><span>Inspeccion</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li <?php echo $m_asist_gen ?> class="{{ 
            Request::is('asistencias*') ? 'active' :'' }}">
            <a href="{{route('asistencias.index') }}"><i class="fa fa-clock-o" aria-hidden="true"></i><span>Asistencia General</span></a>
        </li>
        <li <?php echo $m_novedades_insp ?> class="{{ Request::is('novedadesInspeccions*') ? 'active' : '' }}">
            <a href="{!! route('novedadesInspeccions.index') !!}"><i class="fa fa-edit"></i><span>Novedades de Inspeccion</span></a>
        </li>        
        <li <?php echo $m_rep_asistencias ?> class="{{ Request::is('novedadesInspeccions*') ? 'active' : '' }}">
            <a href="{!! url('/reporte_asistencias') !!}"><i class="fa fa-edit"></i><span>Reporte de Asistencias</span></a>
        </li>        
        <li <?php echo $m_reporte_gen_asistencias ?> class="{{ Request::is('novedadesInspeccions*') ? 'active' : '' }}">
            <a href="{!! url('/reporte_general_asistencias') !!}"><i class="fa fa-edit"></i><span>Reporte General</span></a>
        </li>        
        <li <?php echo $m_reg_asistencias ?> class="{{ Request::is('regDisciplinas*') ? 'active' : '' }}">
            <a href="{!! route('regDisciplinas.index') !!}"><i class="fa fa-edit"></i><span>Registro de Comportamiento</span></a>
        </li>
        <li class="{{ Request::is('sancionados*') ? 'active' : '' }}">
            <a href="{!! route('sancionados.index') !!}"><i class="fa fa-edit"></i><span>Sancionados</span></a>
        </li>
    </ul>
</li>  


<li class="treeview {{ 
    Request::is('ordenesPensions*') ? 'active' :  
   Request::is('valorPensiones*') ? 'active': 
   Request::is('pagoPensiones*') ? 'active': 
   Request::is('recaudacionPensiones*') ? 'active':
   Request::is('pagoManualPensiones*') ? 'active': ''

}} " <?PHP echo $gm_pensiones ?>  >
    <a href="#">
        <i class="fa fa-money " aria-hidden="true"></i><span>Pensiones</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li <?php echo $m_vpension ?> class="{{ Request::is('valorPensiones*') ? 'active' : '' }}">
            <a href="{!! route('valorPensiones.index') !!}"><i class="fa fa-edit"></i><span>Valor Pensiones</span></a>
        </li>

        <li <?php echo $m_ord_pension?> class="{{ Request::is('ordenesPensions*') ? 'active' : '' }}">
            <a href="{!! route('ordenesPensions.index') !!}"><i class="fa fa-edit"></i><span>Ordenes Pensions</span></a>
        </li>
        <li <?php echo $m_rep_pagos?> class="{{ Request::is('pagoPensiones*') ? 'active' : '' }}">
            <a href="{!! route('pagoPensiones.index') !!}"><i class="fa fa-edit"></i><span>Reporte Pago Pensiones</span></a>
        </li>
        <li <?php echo $m_facturacion?> class="{{ Request::is('recaudacionPensiones*') ? 'active' : '' }}">
            <a href="{!! route('recaudacionPensiones.index') !!}"><i class="fa fa-edit"></i><span>Facturación Pensiones</span></a>
        </li>
        <li <?php echo $m_reg_pagos?> class="{{ Request::is('pagoManualPensiones*') ? 'active' : '' }}">
            <a href="{!! route('pagoManualPensiones.index') !!}"><i class="fa fa-edit"></i><span>Registro Pago Manual</span></a>
        </li>
        <li <?php echo $m_rep_pagos_dirigente?> class="{{ Request::is('') ? 'active' : '' }}">
            <a href="{{ URL::to('pagos_por_dirigente') }}"><i class="fa fa-edit"></i><span>Reporte Por Dirigente</span></a>
        </li>
    </ul>
</li>  

<li class="treeview {{ Request::is('rubros*') ? 'active' : '' }} " <?PHP echo $gm_rubros ?>  >
    <a href="#">
        <i class="fa fa-clock-o " aria-hidden="true"></i><span>Rubros</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li <?php echo $m_rubros ?> class="{{ Request::is('rubros*') ? 'active' : '' }}">
            <a href="{!! route('rubros.index') !!}"><i class="fa fa-edit"></i><span>Rubros</span></a>
        </li>
        <li <?php echo "" ?> class="{{ Request::is('rubros*') ? 'active' : '' }}">
            <a href="{!! URL::to('reporte_rubros') !!}"><i class="fa fa-file-o"></i><span>Reporte</span></a>
        </li>
    </ul>
</li>  

<li class="treeview {{ Request::is('rubros*') ? 'active' : '' }} " <?PHP echo $gm_rrhh ?>  >
    <a href="#">
        <i class="fa fa-user " aria-hidden="true"></i><span>RRHH</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">

<li <?php echo $m_pv ?> class="{{ Request::is('permisosVacaciones*') ? 'active' : '' }}">
    <a href="{!! route('permisosVacaciones.index') !!}"><i class="fa fa-edit"></i><span>Permisos Vacaciones</span></a>
</li>

<li <?php echo $m_he ?> class="{{ Request::is('horasExtras*') ? 'active' : '' }}">
    <a href="{!! route('horasExtras.index') !!}"><i class="fa fa-edit"></i><span>Horas Extras</span></a>
</li>

<li <?php echo $m_nl ?> class="{{ Request::is('diasNoLaborables*') ? 'active' : '' }}">
    <a href="{!! route('diasNoLaborables.index') !!}"><i class="fa fa-edit"></i><span>Dias No Laborables</span></a>
</li>

<li <?php echo $m_ra ?> class="{{ Request::is('registroAsistencias*') ? 'active' : '' }}">
    <a href="{!! route('registroAsistencias.index') !!}"><i class="fa fa-edit"></i><span>Registro Asistencias</span></a>
</li>

<li <?php echo $m_jornadas_lab ?> class="{{ Request::is('jornadasLaborables*') ? 'active' : '' }}">
    <a href="{!! route('jornadasLaborables.index') !!}"><i class="fa fa-edit"></i><span>Jornadas Laborables</span></a>
</li>
        
    </ul>
</li>  

<li class="treeview {{ Request::is('auditorias*') ? 'active' : '' }} " <?PHP echo $gm_sistema ?>  >
    <a href="#">
        <i class="fa fa-clock-o " aria-hidden="true"></i><span>Sistema</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li <?php echo $m_auditoria ?> class="{{ Request::is('auditorias*') ? 'active' : '' }}">
            <a href="{!! route('auditorias.index') !!}"><i class="fa fa-edit"></i><span>Auditorias</span></a>
        </li>
        <li <?php echo $m_avances ?> class="{{ Request::is('avances*') ? 'active' : '' }}">
            <a href="{!! route('avances.index') !!}"><i class="fa fa-database text-success"></i><span>Avances</span></a>
        </li>
        
    </ul>

</li>

<li class="treeview {{ Request::is('auditorias*') ? 'active' : '' }} " <?PHP echo $gm_dece ?>  >
    <a href="#">
        <i class="fa fa-clock-o " aria-hidden="true"></i><span>DECE</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li <?php echo $m_ficha_dece ?> class="{{ Request::is('fichaDeces*') ? 'active' : '' }}">
            <a href="{!! route('fichaDeces.index') !!}"><i class="fa fa-edit"></i><span>Ficha Dece</span></a>
        </li>
        <li <?php echo $m_seguimientos ?> class="{{ Request::is('seguimientoDeces*') ? 'active' : '' }}">
            <a href="{!! route('seguimientoDeces.index') !!}"><i class="fa fa-edit"></i><span>Seguimiento Estudiantes</span></a>
        </li>        
        <li <?php echo $m_expediente ?> class="{{ Request::is('seguimientoDeces*') ? 'active' : '' }}">
            <a href="{!! url('/expediente_estudiantil') !!}"><i class="fa fa-edit"></i><span>Expediente Estudiantil</span></a>
        </li>        
    </ul>
</li>

<li class="treeview {{ Request::is('auditorias*') ? 'active' : '' }} " <?PHP echo $gm_capellania ?>  >
    <a href="#">
        <i class="fa fa-clock-o " aria-hidden="true"></i><span>Capellania</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li <?php echo $m_seguimiento_est ?> class="{{ Request::is('seguimientoCapellanias*') ? 'active' : '' }}">
            <a href="{!! route('seguimientoCapellanias.index') !!}"><i class="fa fa-edit"></i><span>Seguimiento Estudiantes</span></a>
        </li>
        <li <?php echo $m_seguimiento_doc ?> class="{{ Request::is('seguimientoCapDocentes*') ? 'active' : '' }}">
            <a href="{!! route('seguimientoCapDocentes.index') !!}"><i class="fa fa-edit"></i><span>Seguimiento Docentes</span></a>
        </li>
        <li <?php echo $m_visita_hogares ?> class="{{ Request::is('visitasHogares*') ? 'active' : '' }}">
            <a href="{!! route('visitasHogares.index') !!}"><i class="fa fa-edit"></i><span>Visitas Hogares</span></a>
        </li>
        <li <?php echo $m_reportes_capellania ?> class="{{ Request::is('segSemanalDocentes*') ? 'active' : '' }}">
            <a href="{!! route('segSemanalDocentes.index') !!}"><i class="fa fa-edit"></i><span>Reportes </span></a>
        </li>        
    </ul>
</li>

<li class="treeview {{

   Request::is('proTipos*') ? 'active' :  
   Request::is('pagoPensiones*') ? 'active': 
   Request::is('movimientos*') ? 'active':
   Request::is('erpDivisions*') ? 'active': ''


 }} " <?PHP echo $gm_bodegas ?>  >
    <a href="#">
        <i class="fa fa-clock-o " aria-hidden="true"></i><span>Bodegas</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">

        <li <?php echo $m_pro_tipos ?> class="{{ Request::is('proTipos*') ? 'active' : '' }}">
            <a href="{!! route('proTipos.index') !!}"><i class="fa fa-edit"></i><span>Tipos</span></a>
        </li>

        <li <?php echo $m_productos ?> class="">
            <a href="{!! route('productos.index') !!}"><i class="fa fa-edit"></i><span>Productos</span></a>
        </li>
        <li <?php echo $m_bodegas ?> class="{{ Request::is('erpDivisions*') ? 'active' : '' }}">
            <a href="{!! route('erpDivisions.index') !!}"><i class="fa fa-edit"></i><span>Bodegas</span></a>
        </li>       
        <li <?php echo $m_movimientos ?> class="{{ Request::is('movimientos*') ? 'active' : '' }}">
            <a href="{!! route('movimientos.index') !!}"><i class="fa fa-edit"></i><span>Movimientos</span></a>
        </li>

        <li <?php echo "" ?> class="{{ Request::is('movimientos/subir_inventario*') ? 'active' : '' }}">
            <a href="{!!  URL::to('/movimientos/subir_inventario') !!}"><i class="fa fa-edit"></i><span>Subir Inventario</span></a>
        </li>

    </ul>
</li>

<li class="treeview {{ Request::is('auditorias*') ? 'active' : '' }} " <?PHP //echo $gm_comunicaciones ?>  >
    <a href="#">
        <i class="fa fa-clock-o " aria-hidden="true"></i><span>Comunicaciones</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li <?php echo $m_sms_mail ?> class="{{ Request::is('smsMails*') ? 'active' : '' }}">
            <a href="{!! route('smsMails.index') !!}"><i class="fa fa-edit"></i><span>Comunicación Externa</span></a>
        </li>
        <li  class="{{ Request::is('comunicaciones*') ? 'active' : '' }}">
            <a href="{!! url('/comunicaciones') !!}"><i class="fa fa-edit"></i><span>Comunicaciones Generales</span></a>
        </li>
        <li <?php echo $m_plantillas ?> class="{{ Request::is('plantillasSms*') ? 'active' : '' }}">
            <a href="{!! route('plantillasSms.index') !!}"><i class="fa fa-edit"></i><span>Plantillas Sms</span></a>
        </li>

    </ul>
</li>

<li class="treeview {{ Request::is('auditorias*') ? 'active' : '' }} " <?PHP echo $gm_encuestas ?>  >
    <a href="#">
        <i class="fa fa-clock-o " aria-hidden="true"></i><span>Encuestas</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li <?php echo $m_reg_encuestas ?> class="{{ Request::is('encEncabezados*') ? 'active' : '' }}">
            <a href="{!! route('encEncabezados.index') !!}"><i class="fa fa-edit"></i><span>Registro Encuestas</span></a>
        </li>
        <li <?php echo $m_grupos_valoracion ?> class="{{ Request::is('encGrupos*') ? 'active' : '' }}">
            <a href="{!! route('encGrupos.index') !!}"><i class="fa fa-edit"></i><span>Grupos Valoracion</span></a>
        </li>
        <li <?php echo $m_ejecutar_encuesta ?> class="{{ Request::is('encRegistros*') ? 'active' : '' }}">
            <a href="{!! route('encRegistros.index') !!}"><i class="fa fa-edit"></i><span>Realizar Encuesta</span></a>
        </li>
        <li <?PHP echo '' ?> class="{{ Request::is('encRegistros*') ? 'active' : '' }}">
            <a href="{{ URL::to('reporte_encuestas') }}"><i class="fa fa-circle"></i><span>Reportes </span></a>
        </li>
        <li <?php echo $m_ev_docente ?> class="{{ Request::is('encuestaEncabezados*') ? 'active' : '' }}">
            <a href="{!! route('encuestaEncabezados.index') !!}"><i class="fa fa-edit"></i><span>Evaluación Docente</span></a>
        </li>

    </ul>
</li>


<li class="treeview {{ Request::is('auditorias*') ? 'active' : '' }} "  ?>  >
    <a href="#">
        <i class="fa fa-clock-o " aria-hidden="true"></i><span>Aula Virtual</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li class="{{ Request::is('aulaVirtuals*') ? 'active' : '' }}">
            <a href="{!! route('aulaVirtuals.index') !!}"><i class="fa fa-edit"></i><span>Tareas y Deberes</span></a>
        </li>
        <li class="{{ Request::is('clasesOnlines*') ? 'active' : '' }}">
            <a href="{!! route('clasesOnlines.index') !!}"><i class="fa fa-edit"></i><span>Clases Online</span></a>
        </li>    
        
        <li class="{{ Request::is('evaluaciones*') ? 'active' : '' }}">
            <a href="{!! route('evaluaciones.index') !!}"><i class="fa fa-edit"></i><span>Evaluaciones</span></a>
        </li>

        <li class="{{ Request::is('aulaVirtuals_folder*') ? 'active' : '' }}">
            <a href="{!! URL::to('aulaVirtuals_folder') !!}"><i class="fa fa-edit"></i><span>Carpeta Estudiantil</span></a>
        </li>

        <li class="{{ Request::is('aulaVirtuals_tareas_recibidas*') ? 'active' : '' }}">
            <a href="{!! URL::to('aulaVirtuals_reporte_tareas_recibidas') !!}"><i class="fa fa-edit"></i><span>Reporte de Cumplimiento</span></a>
        </li>


    </ul>
</li>


<li class="treeview    
    {{ Request::is('productosServicios*') ? 'active' :  
       Request::is('reporte_ventas*') ? 'active' :  
       Request::is('clientes*') ? 'active':'' 
    }}
    "  <?php echo "" ?> >
    <a href="#">
        <i class="fa fa-clock-o " aria-hidden="true"></i><span>Productos y Servicios</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">

        <li class="{{ Request::is('productosServicios*') ? 'active' : '' }}">
            <a href="{!! route('productosServicios.index') !!}"><i class="fa fa-edit"></i><span>Productos Servicios</span></a>
        </li>
        <li class="{{ Request::is('reporte_ventas*') ? 'active' : '' }}">
            <a href="{{ url('/reporte_ventas') }}"><i class="fa fa-edit"></i><span>Reporte de Ventas</span></a>
        </li>
        <li class="{{ Request::is('clientes*') ? 'active' : '' }}">
            <a href="{!! route('clientes.index') !!}"><i class="fa fa-edit"></i><span>Clientes</span></a>
        </li>

    </ul>
</li>

<li class=" " >
    <a href="#">
        <i class="fa fa-file-o " aria-hidden="true"></i><span>Facturación Electrónica</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul  class="treeview-menu">
        <li class="">
            <a href="{!! route('facturacionElectronica.credenciales') !!}"><i class="fa fa-edit"></i><span>Adm Credenciales</span></a>
        </li>
    </ul>
</li>



<li  class="{{ Request::is('sugerencias*') ? 'active' : '' }}">
    <a href="{!! route('sugerencias.index') !!}"><i class="fa fa-edit"></i><span>Sugerencias</span></a>
</li>


<!-- <li  class="{{ Request::is('calendario_tareas*') ? 'active' : '' }}">
    <a href="{!! URL::to('calendario_tareas') !!}"><i class="fa fa-edit"></i><span>Tareas</span></a>
</li>
 





