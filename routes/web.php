<?php

Route::get('/', function () {
    return redirect('home');
});
Route::get('/logout', function () {
    return view('logout');
});


Auth::routes();
Route::get('/home', 'HomeController@index');
Route::group(['middleware' => 'auth'], function() {

    Route::get('ordenesPensions/ord_independiente','OrdenesPensionController@genera_num_orden');

    Route::get('estudiantes/cedula', 'EstudiantesController@valida_cedulas');
    Route::resource('anioLectivos', 'AnioLectivoController');
    Route::resource('cursos', 'CursosController');
    Route::resource('especialidades', 'EspecialidadesController');
    Route::resource('insumos', 'InsumosController');
    Route::resource('estudiantes', 'EstudiantesController');

    Route::get('/matriculas/create/{id}', 'MatriculasController@create');
    Route::get('/matriculas/edit/{id}', 'MatriculasController@edit');
    Route::resource('matriculas', 'MatriculasController');
    Route::resource('jornadas', 'JornadasController');
    Route::post('estudiantes.busqueda', 'EstudiantesController@buscar');
    Route::get('matriculas.buscar', 'MatriculasController@buscar');
    Route::resource('sucursales', 'SucursalesController');

    Route::resource('usuarios', 'UsuariosController');
    Route::name('usuarios.buscar')->post('usuarios.buscar', 'UsuariosController@index');

    Route::resource('reportes', 'ReportesController');

    Route::post('estadistica.preview', 'ReportesController@previewestadistica');
    Route::post('estadistica.xls', 'ReportesController@estadistica_xsl');
    Route::resource('asignaPermisos', 'AsignaPermisosController');
    Route::resource('modulos', 'ModulosController');
    Route::resource('materiasCursos', 'MateriasCursosController');

    //Route::post('materiasCursos.asignar', 'MateriasCursosController@asignar');
    //Route::name('materiasCursos.asignar')->post('materiasCursos.asignar', 'MateriasCursosController@asignar');

    Route::post('materiasCursos.asignar', 'MateriasCursosController@asignar')->name('materiasCursos.asigno');

    Route::post('materias.buscar', 'MateriasController@buscar');
    Route::post('materias.show', 'MateriasController@show');
    Route::resource('materias', 'MateriasController');
    
    Route::resource('asignaHorarios', 'AsignaHorariosController');

    Route::post('asignaHorarios/asignaHorarios.show2', 'AsignaHorariosController@show2');

    Route::post('asignaHorarios/{id}/asigna_coordinador', 'AsignaHorariosController@asigna_coordinador');

    Route::post('asignaHorarios/{id}/busca_coordinador', 'AsignaHorariosController@busca_coordinador');

    Route::get('rep_horarios','ReportesController@horarios_docentes');
    Route::get('votaciones','ReportesController@votaciones');
    Route::get('rpt_votacion','ReportesController@rep_total');
    Route::get('reset_v','ReportesController@reset_v');
    
    Route::get('retirados','ReportesController@retirados');

    Route::post('retirados','ReportesController@retirados');

    Route::get('pagos_por_dirigente','ReportesController@reporte_pago_dirigente');

    Route::post('buscar_pagos_por_dirigente','ReportesController@buscar_pagos_por_dirigente');


///CARGAR CONFIGURACION DE AÑOS LECTIVOS
    Route::post('/reporte_general_notas/configuracion_anio_lectivo', 'RegNotasController@configuracion_anio_lectivo');


    Route::get('/regNotas/cur/{op}/{jor_id}','RegNotasController@show'); 
    Route::get('/regNotas/save_notes/{dt}','RegNotasController@save' );  
    Route::get('/regNotas/{dt}','RegNotasController@load_datos');    
    Route::get('/regNotas/mtr/{esp}/{cur}','RegNotasController@mtr_tecnicas');  
    ///********GUARDAR NOTAS
    Route::post('/regNotas/load_parciales','RegNotasController@load_parciales');   
    Route::post('/regNotas/guardar_notas','RegNotasController@guardar_notas');   
    ///*******
    Route::resource('regNotas', 'RegNotasController');
    Route::post('regNotas.descarga_archivo', 'RegNotasController@descarga_archivo');
    Route::post('cargar.frm_notas','RegNotasController@create');
    Route::get('/cargar.frm_notas/save_notes/{mat_id}','RegNotasController@save' );  
    Route::get('ordenesPensions/busca_est/{cedula}', 'OrdenesPensionController@busca_est');    
    Route::get('ordenesPensions/busca_varios_est/{cedula}', 'OrdenesPensionController@busca_varios_est');    
    Route::get('rubros/{op}/busca_varios_est/{cedula}', 'OrdenesPensionController@busca_varios_est2');    
    Route::get('rubros/{op}/busca_pagos_est/{dt}', 'OrdenesPensionController@busca_pagos');        



    ////*************ORDENES DE PENSIÓN****////////////////////////
    Route::get('ordenesPensions/busca_orden/{idt}', 'OrdenesPensionController@busca_ord');    
    Route::get('ordenesPensions/genera_ord/{dt}', 'OrdenesPensionController@genera_ord');    
    Route::resource('valorPensiones', 'ValorPensionesController');
    Route::resource('ordenesPensions', 'OrdenesPensionController');  

    Route::post('generar_matriculas_provisionales_nuevo_anio', 'OrdenesPensionController@generar_matriculas_provisionales_nuevo_anio');  

    /////////////////********************////////////////////////



    Route::get('notasExtras/search/{dt}','NotasExtrasController@buscar' );
    Route::get('notasExtras/search_note/{id}','NotasExtrasController@search_note' );
    Route::get('notasExtras/save/{dt}','NotasExtrasController@guarda_nota');
    Route::resource('notasExtras', 'NotasExtrasController');
    Route::get('materias.show/mcult/{dt}','MateriasCursosController@asignar_cultural');
    Route::post('mat_curso.del','MateriasCursosController@elimina_cultural');

    Route::post('reporte','RegNotasController@reporte');
    Route::get('regNotas.rep','RegNotasController@rep_ntas');
    Route::get('regNotas.rep/notas/{data}','RegNotasController@reporte');
    Route::get('regNotas.rep/load_mat_tec/{data}','RegNotasController@load_mat_tec');
    Route::post('regNotas.excel','RegNotasController@excel');  

    Route::get('reporte_general_notas','RegNotasController@reporte_general_notas');  
    Route::post('reporte_general_notas','RegNotasController@reporte_general_notas');  

    Route::get('reporte_cuadros_finales','RegNotasController@reporte_cuadros_finales');  
    Route::post('reporte_cuadros_finales','RegNotasController@reporte_cuadros_finales');  


    Route::resource('departamentos', 'DepartamentosController');
    Route::resource('tramites', 'TramitesController');
    Route::post('tramites/reporte_tramites','TramitesController@rep_tramites');
    Route::resource('requerimientos', 'RequerimientosController');
    Route::name('/requerimiento/descargar')->get('/requerimiento/descargar/{id}', 'RequerimientosController@descargar');
   
    Route::name('requerimiento/create')->get('requerimiento/create/{id}', 'RequerimientosController@create');
    Route::name('requerimientos/edit')->get('requerimientos/edit/{id}/{usu_id}', 'RequerimientosController@edit');
    Route::name('requerimientoMovimiento')->get('requerimiento/{id}/{op}', 'MovimientosRequerimientoController@index');
    Route::name('requerimientos/show')->get('requerimiento/show/{id}/{usu_id}', 'MovimientosRequerimientoController@show');
    Route::name('requerimiento/finalizar')->get('requerimiento/finalizar/{id}/{usu_id}', 'RequerimientosController@finalizar');
    Route::name('requerimiento/anular')->get('requerimiento/anular/{id}/{usu_id}', 'RequerimientosController@anular');

    
    Route::get('/requerimiento/create/{id}/match/{usu_id}/{op}', 'RequerimientosController@cargar_dato');
    Route::get('/requerimientos/edit/{id}/{user}/match/{usu_id}/{op}', 'RequerimientosController@cargar_dato2');
    Route::post('requermientos.busqueda','RequerimientosController@buscador');
    Route::name('mov_requerimiento/create')->get('mov_requerimiento/create/{id}/{estado}/{op}', 'MovimientosRequerimientoController@create');

    Route::name('materias.show/mtrupdate/')->get('materias.show/mtrupdate/{dt}', 'MateriasController@actualizar');
    Route::name('materiasCursos.asignar/mtrupdate/')->get('materiasCursos.asignar/mtrupdate/{dt}', 'MateriasController@actualizar');
    Route::name('materiasCursos/mtrupdate/')->get('materiasCursos/mtrupdate/{dt}', 'MateriasController@actualizar');
   


    Route::post('/matriculas/edit/{mtrid}/val_paralelo','EstudiantesController@valida_cupo');
    
    Route::post('/estudiantes/create/{mtrid}/val_paralelo','EstudiantesController@valida_cupo');

    Route::get('/estudiantes/mostrar/estadistica','ReportesController@reporte_est');
    Route::get('/estudiantes.busqueda/mostrar/estadistica','ReportesController@reporte_est');


Route::post('asistencias/lista_save','AsistenciaController@store');
Route::post('asistencias/search','AsistenciaController@search');
Route::get('asistencias/lista/{dt}','AsistenciaController@lista');
Route::resource('asistencias', 'AsistenciaController');

Route::post('asistencias/asistencias_buscar', 'AsistenciaController@buscar');

Route::get('ordenesPensions/update_orden/{dt}','OrdenesPensionController@update_orden');
Route::get('ordenesPensions/delete_este/{dt}','OrdenesPensionController@delete_este');
Route::get('ordenesPensions/add_est/{dt}','OrdenesPensionController@add_est');
Route::get('ordenesPensions/add_est_ord_ind/{dt}','OrdenesPensionController@add_est_ord_ind');

Route::post('ordenesPensions.excel','OrdenesPensionController@excel');
//Auditoria
Route::resource('auditorias', 'AuditoriaController');
Route::post('adt_search', 'AuditoriaController@adt_search');
Route::resource('rubros', 'RubrosController');
Route::resource('pagoRubros', 'PagoRubrosController');
Route::post('pagoRubros.index', 'PagoRubrosController@index');
Route::post('rubros/{id}/guarda_pago','PagoRubrosController@store');
Route::post('rubros/{id}/elimina_pago','PagoRubrosController@destroy');
Route::post('rubros/imrpime_pago','PagoRubrosController@imprimir');
Route::get('rubros/reporte/{rbid}','PagoRubrosController@reporte');
Route::resource('pagoPensiones', 'PagoPensionesController');
Route::post('pagoPensiones.index', 'PagoPensionesController@index');

Route::resource('recaudacionPensiones', 'RecaudacionPensionesController');
Route::post('recaudacionPensiones.index', 'RecaudacionPensionesController@index');
Route::post('recaudacionPensiones/datos_factura','RecaudacionPensionesController@datos_factura');
Route::post('recaudacionPensiones/create/busca_est_pension', 'RecaudacionPensionesController@busca_pensiones');    
Route::post('recaudacionPensiones/create/factura_pension', 'RecaudacionPensionesController@factura_pension');    

Route::post('elimina_duplicados_facturas', 'RecaudacionPensionesController@elimina_duplicados_facturas');    

Route::resource('pagoManualPensiones', 'PagoManualPensionesController');
Route::post('pagoManualPensiones.index', 'PagoManualPensionesController@index');

Route::post('pagoManualPensiones.index/registra_pago', 'PagoManualPensionesController@registra_pago');
Route::post('pagoManualPensiones.index/elimina_pago', 'PagoManualPensionesController@elimina_pago');
Route::post('elimina_orden', 'OrdenesPensionController@elimina_ord');

Route::resource('adminNotas', 'AdminNotasController');
Route::post('adminNotas/create/busca_especialidades','AdminNotasController@busca_especialidades');
Route::post('adminNotas/{vl}/edit/busca_especialidades','AdminNotasController@busca_especialidades');
            //adminNotas/113/edit
Route::post('pagoRubros.index/excluye_pago','PagoRubrosController@excluye_pago');

Route::post('cursos/{id}/asg_dirgente','CursosController@asg_dirgente');

// Route::get('/reporte_gen_pagos','ReportesController@rep_gen_pagos');

Route::resource('avances', 'AvancesController');

Route::post('avances.index', 'AvancesController@index');

Route::resource('sugerencias', 'SugerenciasController');


Route::get('reporte_rubros', 'RubrosController@reporte');
Route::post('rub_rep_gen', 'RubrosController@reporte_gen');


Route::resource('permisosVacaciones', 'PermisosVacacionesController');

Route::resource('horasExtras', 'HorasExtrasController');

Route::resource('diasNoLaborables', 'DiasNoLaborablesController');

Route::resource('registroAsistencias', 'RegistroAsistenciaController');
Route::post('registroAsistencias.store', 'RegistroAsistenciaController@store');
Route::post('registroAsistencias.index', 'RegistroAsistenciaController@index');

Route::post('pagoPensiones.index/ordenes', 'PagoPensionesController@ordenes');
Route::post('pagoPensiones.index/save_ordenes', 'PagoPensionesController@save_ordenes');

Route::resource('jornadasLaborables', 'JornadasLaborablesController');
Route::resource('asgJornadasLaborables', 'AsgJornadasLaborablesController');
Route::resource('configuraciones', 'ConfiguracionesController');

Route::post('/jornadasLaborables/elimina_asignacion_jornada', 'JornadasLaborablesController@destroy');

Route::get('recaudacionPensiones.index/ticket/{fac_id}','RecaudacionPensionesController@show');
Route::post('recaudacionPensiones.index/actualiza_num_factura','RecaudacionPensionesController@actualiza_num_factura');

Route::resource('subirNotas','SubirArchivoController');



Route::resource('fichaDeces', 'FichaDeceController');
Route::post('fichaDeces.index', 'FichaDeceController@index');
Route::get('/fichaDeces.fichapdf/{id}','FichaDeceController@fichapdf');

Route::resource('seguimientoDeces', 'SeguimientoDeceController');

Route::resource('seguimientoAccionesDeces', 'SeguimientoAccionesDeceController');

Route::resource('seguimientoCapellanias', 'SeguimientoCapellaniaController');

Route::resource('seguimientoCapDocentes', 'SeguimientoCapDocentesController');

Route::post('buscar_novedades', 'NovedadesInspeccionController@busqueda');

Route::resource('novedadesInspeccions', 'NovedadesInspeccionController');

Route::resource('visitasHogares', 'VisitasHogaresController');

Route::post('buscar_estudiantes', 'VisitasHogaresController@busqueda');

Route::post('/visitasHogares/create/buscar_estudiantes', 'VisitasHogaresController@busqueda');

Route::post('seguimientoCapellanias_buscar', 'SeguimientoCapellaniaController@buscar');

Route::post('asistencias/{dt}/edit/justifica_asistencia','AsistenciaController@justifica_asistencia');

Route::resource('smsMails', 'SmsMailController');

Route::post('/smsMails/buscar_estudiantes', 'SmsMailController@buscar_estudiantes');

Route::post('smsMails/{cod}/actualiza_estado', 'SmsMailController@actualiza_estado');

Route::post('smsMails/{cod}/envia_mail', 'SmsMailController@envia_mail');

Route::post('envia_mails', 'SmsMailController@envia_mail');

Route::post('actualiza_estado_sms', 'SmsMailController@actualiza_estado');

Route::get('repingreso.notas', ['as' => 'repingreso.notas', 'uses' => 'RegNotasController@rep_ingreso_notas']);

Route::post('repingreso.reporte', 'RegNotasController@reporte_ingreso_general');
Route::post('busca_materia_especialidad', 'RegNotasController@busca_materia_especialidad');

Route::post('ver_notas_reporte', 'RegNotasController@ver_notas_reporte');

Route::post('lista_mensaje_no_enviados', 'SmsMailController@lista_mensaje_no_enviados');
Route::resource('plantillasSms', 'PlantillasSmsController');
Route::post('busca_asistencias', 'AsistenciaController@busca_asistencias');

Route::get('/administrar_notas', 'RegNotasController@administrar_notas');

Route::post('busca_notas_generales', 'RegNotasController@busca_notas_generales');

Route::post('buscar_asistencias', 'AsistenciaController@index');

Route::post('seguimientoDece_buscar', 'SeguimientoDeceController@buscar');

Route::post('seguimientoCapDoc_buscar', 'SeguimientoCapDocentesController@buscar');

Route::post('/visitasHogares/create/buscar_visita_hogares', 'VisitasHogaresController@buscar_visita_hogares');

Route::resource('segSemanalDocentes', 'SegSemanalDocenteController');

Route::post('segSemanalDocentes.index', 'SegSemanalDocenteController@index');

Route::get('reporte_asistencias', 'AsistenciaController@reporte_asistencias');
Route::get('reporte_general_asistencias', 'AsistenciaController@reporte_general_asistencias');
Route::post('reporte_general_asistencias', 'AsistenciaController@reporte_general_asistencias');


Route::post('busca_notas_generales', 'RegNotasController@busca_notas_generales');
Route::post('buscar_asistencias', 'AsistenciaController@index');

Route::post('busca_asistencias_novedades', 'AsistenciaController@busca_asistencias_novedades');

Route::post('busca_asistencias_reporte', 'AsistenciaController@busca_asistencias_reporte');

Route::get('expediente_estudiantil', 'FichaDeceController@expediente_estudiantil');

Route::post('expediente_estudiantil', 'FichaDeceController@expediente_estudiantil');

Route::post('periodos_bgu', 'AnioLectivoController@periodos_bgu');
Route::post('cambia_periodos_bgu', 'AnioLectivoController@cambia_periodos_bgu');
//***
Route::post('regNotas/obtiene_anio_lectivo', 'AnioLectivoController@obtiene_anio_lectivo');

Route::post('encEncabezados/grabar_preguntas', 'EncEncabezadoController@grabar_preguntas');
Route::post('encEncabezados/eliminar_preguntas', 'EncEncabezadoController@eliminar_preguntas');

Route::post('encRegistros/registra_encuesta', 'EncRegistrosController@registra_encuesta');

Route::post('encRegistros/busca_registro_encuesta', 'EncRegistrosController@busca_registro_encuesta');

Route::post('encRegistros/finalizar_encuesta', 'EncRegistrosController@finalizar_encuesta');

Route::resource('encEncabezados', 'EncEncabezadoController');

Route::resource('encGrupos', 'EncGruposController');

Route::resource('encRegistros', 'EncRegistrosController');

Route::post('reporte_insumos', 'RegNotasController@reporte_insumos');

Route::post('rubros.index', 'RubrosController@index');

Route::post('/smsMails/create/busca_plantillas', 'PlantillasSmsController@busca_plantillas');
Route::post('/smsMails/create/busca_una_plantilla', 'PlantillasSmsController@busca_una_plantilla');

Route::post('buscar_comunicaciones', 'SmsMailController@index');

///***********COMUNICACIONES*********///
Route::post('comunicaciones', 'SmsMailController@comunicaciones');
Route::get('comunicaciones', 'SmsMailController@comunicaciones');
Route::post('comunicaciones/cargar_estudiantes', 'SmsMailController@cargar_estudiantes');
Route::post('comunicaciones/enviar_notificaciones', 'SmsMailController@enviar_notificaciones');
Route::post('comunicaciones/load_datos_comunicado', 'SmsMailController@load_datos_comunicado');
Route::post('comunicaciones/elimina_comunicado', 'SmsMailController@elimina_comunicado');

////*/*******************///////////////////////

Route::post('/seguimientoDeces/{id}/seguimientoAccionesDeces.destroy', 'SeguimientoAccionesDeceController@destroy');
Route::post('/seguimientoDeces/seguimientoAccionesDeces.destroy', 'SeguimientoAccionesDeceController@destroy');
Route::post('departamentos/{id}/actualizar_perfiles', 'ConfiguracionesController@actualizar_perfiles');
Route::post('regNotas/registra_comportamiento', 'RegNotasController@registra_comportamiento');
Route::post('regDisciplinas/disc_busca_estudiante/registra_comportamiento', 'RegNotasController@registra_comportamiento');
Route::resource('regDisciplinas', 'RegDisciplinaController');
Route::post('regDisciplinas/disc_busca_estudiante', 'RegDisciplinaController@create');
Route::post('imprimir_individuales','RegNotasController@imprimir_individuales');   
Route::get('reporte_encuestas','ReportesController@reporte_encuestas');   
Route::get('/reporte_ind_encuestas/{id}','ReportesController@reporte_ind_encuestas');   
Route::resource('parciales', 'ParcialesController');
Route::get('reporte_adicional', 'RegNotasController@reporte_adicional');
Route::post('resumen_notas_modulo', 'RegNotasController@resumen_notas_modulo');
Route::resource('sancionados', 'SancionadosController');
Route::post('sancionados.index', 'SancionadosController@index');
Route::post('reporte_ind_encuestas/{id_enc}/registra_totales_encuesta','EncRegistrosController@registra_totales_encuesta');   
Route::get('reporte_consolidado_encuesta','ReportesController@reporte_gen_encuestas');   
Route::resource('sancionadosSeguimientos', 'SancionadosSeguimientoController');
Route::post('matriculas/edit/{id}/revisa_asistencia','MatriculasController@revisa_asistencia');   
Route::post('reporte_general_notas/modifica_notas','RegNotasController@modifica_notas');   

///***********BODEGAS*********///
Route::get('/movimientos/subir_inventario', 'MovimientosController@subir_inventario' );
Route::resource('proTipos', 'ProTipoController');
Route::post('productos.index', 'ProductosController@index');
Route::resource('productos', 'ProductosController');
Route::resource('movimientos', 'MovimientosController');
Route::resource('erpDivisions', 'ErpDivisionController');

Route::post('movimientos/cargar_inventario', 'MovimientosController@cargar_inventario');


///***********GERENCIAS*********///
Route::resource('gerencias', 'GerenciasController');
///***********ASIGNA DEPARTAMENTOS*********///
Route::post('usuarios/dep_asignados', 'UsuariosController@dep_asignados');
Route::post('usuarios/asignar_departamento', 'UsuariosController@asignar_departamento');
Route::post('usuarios/elimina_asignar_departamento', 'UsuariosController@elimina_asignar_departamento');

///***********PRODUCTOS SERVICIOS*********///
Route::resource('productosServicios', 'ProductosServiciosController');
Route::post('productosServicios/{pro_id}/busca_cliente', 'ProductosServiciosController@busca_cliente');
Route::get('/reporte_ventas', 'ProductosServiciosController@reporte_ventas');
Route::get('reporte_ventas/ticket/{fac_id}', 'ProductosServiciosController@reporte_ventas_ticket');
Route::post('reporte_ventas', 'ProductosServiciosController@reporte_ventas');
///******************//////////////
Route::resource('clientes', 'ClientesController');

///************AULA VIRTUAL**********/////////
Route::resource('aulaVirtuals', 'AulaVirtualController');
Route::post('regNotas/aulaVirtuals_store', 'AulaVirtualController@store');//Guarda las nuevas tareas desde las notas
Route::post('regNotas/guarda_notas_aportes', 'AulaVirtualController@guarda_notas_aportes');//Guarda notas de aportes

Route::post('aulaVirtuals/load_tareas', 'AulaVirtualController@load_tareas');
Route::post('aulaVirtuals/load_una_tarea', 'AulaVirtualController@load_una_tarea');
Route::post('aulaVirtuals.destroy', 'AulaVirtualController@destroy');
Route::post('aulaVirtuals/calificar_tarea', 'AulaVirtualController@calificar_tarea');
Route::post('descargar_archivo_aula', 'AulaVirtualController@descargar_archivo_aula');
Route::get('comunicaciones/tareas/descargar_archivo/{adj}', 'AulaVirtualController@descargar_archivo');

Route::post('aulaVirtuals/load_codigo_tarea', 'AulaVirtualController@load_codigo_tarea');
Route::post('aulaVirtuals/load_modulo_materia', 'AulaVirtualController@load_modulo_materia');
Route::post('descargar_tareas_enviadas', 'AulaVirtualController@descargar_tareas_enviadas');
Route::post('aulaVirtuals/load_parciales_modulo', 'AulaVirtualController@load_parciales_modulo');
Route::post('aulaVirtuals/transferir_notas', 'AulaVirtualController@transferir_notas');
Route::post('cumplimiento_tareas', 'AulaVirtualController@cumplimiento_tareas');
Route::resource('clasesOnlines', 'ClasesOnlineController');
Route::get('aulaVirtuals_folder', 'AulaVirtualController@aulaVirtuals_folder');
Route::post('student_folder_search', 'AulaVirtualController@student_folder_search');

Route::post('regNotas/student_folder_search', 'AulaVirtualController@student_folder_search');

Route::post('student_folder_search/registra_notas_aulav', 'AulaVirtualController@registra_notas_aulav');
Route::post('student_folder_search/comprimirDescargar', 'AulaVirtualController@comprimirDescargar');
Route::get('aulaVirtuals_reporte_tareas_recibidas', 'AulaVirtualController@reporte_tareas_recibidas');
Route::post('aulaVirtuals_reporte_tareas_recibidas', 'AulaVirtualController@reporte_tareas_recibidas');

Route::post('descargar_adjuntos_tareas', 'AulaVirtualController@descargar_adjuntos_tareas')->name('descargar_adjuntos_tareas');
Route::post('load_detalle_cumplimiento', 'AulaVirtualController@load_detalle_cumplimiento')->name('load_detalle_cumplimiento');
Route::post('informe_cumplimiento_tareas', 'AulaVirtualController@informe_cumplimiento_tareas')->name('informe_cumplimiento_tareas');

Route::post('regNotas/ocultar_tarea', 'AulaVirtualController@ocultar_tarea')->name('ocultar_tarea');


///************EVALUACIONES**********/////////
Route::resource('evaluaciones', 'EvaluacionesController');
Route::resource('evaluacionGrupos', 'EvaluacionGrupoController');
Route::resource('evaluacionPreguntas', 'EvaluacionPreguntasController');
Route::post('evaluaciones/evaluaciones.store_groups', 'EvaluacionesController@store_groups');
Route::post('evaluaciones/evaluaciones.elimina_grupo', 'EvaluacionesController@elimina_grupo');
Route::post('evaluaciones/{evl_id}/load_pregunta', 'EvaluacionesController@load_pregunta');


Route::post('evaluaciones/evaluaciones.store_questions', 'EvaluacionesController@store_questions');
Route::get('image-view','EvaluacionesController@index_img');
Route::post('image-view','EvaluacionesController@store_img');

///*********REPORTE DE LEGALIZACIONES*************************///////////////
Route::get('reporte_legalizaciones','RegNotasController@reporte_legalizaciones')->name('reporte_legalizaciones');
Route::post('reporte_legalizaciones/lista_reporte_legalizaciones','RegNotasController@lista_reporte_legalizaciones')->name('lista_reporte_legalizaciones');

Route::post('reporte_cuadros_finales/elimina_notas_quimestres','RegNotasController@elimina_notas_quimestres')->name('elimina_notas_quimestres');

Route::resource('encuestaEncabezados', 'EncuestaEncabezadoController');
Route::post('encuestaEncabezados/create/guarda_encabezado', 'EncuestaEncabezadoController@guarda_encabezado');
Route::post('encuestaEncabezados/{id}/edit/guarda_encabezado', 'EncuestaEncabezadoController@guarda_encabezado');
Route::post('encuestaEncabezados/create/elimina_pregunta', 'EncuestaEncabezadoController@elimina_pregunta');
Route::post('encuestaEncabezados/{id}/edit/elimina_pregunta', 'EncuestaEncabezadoController@elimina_pregunta');
Route::post('encuestaEncabezados/{id}/load_detalle_encuesta', 'EncuestaEncabezadoController@load_detalle_encuesta');
Route::resource('encuestaGrupos', 'EncuestaGruposController');
Route::resource('encuestaPreguntas', 'EncuestaPreguntasController');
Route::resource('solicitudMatriculas', 'SolicitudMatriculaController');
//FACTURACION ELECTRÓNICA
Route::get('/credenciales', 'ConfiguracionesController@credenciales')->name('facturacionElectronica.credenciales');
Route::post('create_update_credenciales', 'ConfiguracionesController@create_update_credenciales')->name('facturacionElectronica.create_update_credenciales');
/////******/////////
Route::post('regNotas/load_tareas_cursos', 'AulaVirtualController@load_tareas_cursos')->name('load_tareas_cursos');



});

