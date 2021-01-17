<!-- Vstid Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('vstid', 'Vstid:') !!}
    <p>{!! $visitasHogares->vstid !!}</p>
</div>

<div class="col-sm-12">
    <h4 style="text-align: center; background: silver; font-weight: bold;">Datos Principales</h4>
</div>

<!-- Mat Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('mat_id', 'Estudiante:') !!}
    <p>{!! $visitasHogares->est_apellidos.' '.$visitasHogares->est_nombres !!}</p>
</div>

<!-- Usu Id Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('usu_id', 'Usu Id:') !!}
    <p>{!! $visitasHogares->usu_id !!}</p>
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fecha', 'Fecha:') !!}
    <p>{!! $visitasHogares->fecha !!}</p>
</div>

<!-- H Inicio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('h_inicio', 'Hora Inicio:') !!}
    <p>{!! $visitasHogares->h_inicio !!}</p>
</div>

<!-- H Fin Field -->
<div class="form-group col-sm-3">
    {!! Form::label('h_fin', 'Hora Fin:') !!}
    <p>{!! $visitasHogares->h_fin !!}</p>
</div>

<!-- Sector Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sector', 'Sector:') !!}
    <p>{!! $visitasHogares->sector !!}</p>
</div>

<!-- Barrio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('barrio', 'Barrio:') !!}
    <p>{!! $visitasHogares->barrio !!}</p>
</div>

<!-- Calles Field -->
<div class="form-group col-sm-3">
    {!! Form::label('calles', 'Calles:') !!}
    <p>{!! $visitasHogares->calles !!}</p>
</div>

<!-- Punto Ref Field -->
<div class="form-group col-sm-3">
    {!! Form::label('punto_ref', 'Punto de Referencia:') !!}
    <p>{!! $visitasHogares->punto_ref !!}</p>
</div>

<!-- Croquis Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('croquis', 'Croquis:') !!}
    <p>{!! $visitasHogares->croquis !!}</p>
</div>

<!-- Genograma Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('genograma', 'Genograma:') !!}
    <p>{!! $visitasHogares->genograma !!}</p>
</div>

<div class="col-sm-12">
    <h4 style="text-align: center; background: silver; font-weight: bold;">Antecedentes</h4>
</div>

<!-- Ant Familiares Field -->
<div class="form-group col-sm-4">
    {!! Form::label('ant_familiares', 'Antecedentes Familiares:') !!}
    <p>{!! $visitasHogares->ant_familiares !!}</p>
</div>

<!-- Ant Academicas Field -->
<div class="form-group col-sm-4">
    {!! Form::label('ant_academicas', 'Antecedentes Academicas:') !!}
    <p>{!! $visitasHogares->ant_academicas !!}</p>
</div>

<!-- Ant Conductuales Field -->
<div class="form-group col-sm-4">
    {!! Form::label('ant_conductuales', 'Antecedentes Conductuales:') !!}
    <p>{!! $visitasHogares->ant_conductuales !!}</p>
</div>

<div class="col-sm-12">
    <h4 style="text-align: center; background: silver; font-weight: bold;">Servicios Básicos</h4>
</div>

<!-- Tipo Vivienda Field -->
<div class="form-group col-sm-3">
    {!! Form::label('tipo_vivienda', 'Tipo de Vivienda:') !!}
    <p>
        @if($visitasHogares->tipo_vivienda==0)
        {{"Propia"}}
        @elseif($visitasHogares->tipo_vivienda==1)
        {{"Arrendada"}}
        @else
        {{"Prestada"}}
        @endif
    </p>
</div>

<!-- Tipo Construccion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('tipo_construccion', 'Tipo de Construccion:') !!}
    <p>{!! $visitasHogares->tipo_construccion !!}</p>
</div>

<!-- Agua Field -->
<div class="form-group col-sm-3">
    {!! Form::label('agua', 'Agua:') !!}
    <p>
        @if($visitasHogares->agua==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

<!-- Luz Field -->
<div class="form-group col-sm-3">
    {!! Form::label('luz', 'Luz:') !!}
    <p>
        @if($visitasHogares->luz==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

<!-- Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('telefono', 'Telefono:') !!}
    <p>
        @if($visitasHogares->telefono==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

<!-- Internet Field -->
<div class="form-group col-sm-3">
    {!! Form::label('internet', 'Internet:') !!}
    <p>
        @if($visitasHogares->internet==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

<!-- Tvcable Field -->
<div class="form-group col-sm-3">
    {!! Form::label('tvcable', 'Tvcable:') !!}
    <p>
        @if($visitasHogares->tvcable==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

<!-- Otros Field -->
<div class="form-group col-sm-3">
    {!! Form::label('otros', 'Otros:') !!}
    <p>{!! $visitasHogares->otros !!}</p>
</div>

<div class="col-sm-12">
    <h4 style="text-align: center; background: silver; font-weight: bold;">Aspecto Espiritual</h4>
</div>

<!-- Necesita Ayuda Field -->
<div class="form-group col-sm-3">
    {!! Form::label('necesita_ayuda', 'Necesita Ayuda:') !!}
    <p>
        @if($visitasHogares->necesita_ayuda==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

<!-- Vida Cristo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('vida_cristo', '¿Entregó su vida a Cristo?:') !!}
    <p>
        @if($visitasHogares->vida_cristo==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

<!-- Cree Jesus Field -->
<div class="form-group col-sm-3">
    {!! Form::label('cree_jesus', '¿Cree usted que Jesús es el hijo Unigénito de Dios?:') !!}
    <p>
        @if($visitasHogares->cree_jesus==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

<!-- Cree Porque Field -->
<div class="form-group col-sm-3">
    {!! Form::label('cree_porque', '¿Porqué?:') !!}
    <p>{!! $visitasHogares->cree_porque !!}</p>
</div>

<!--Bautizado Field-->
<div class="form-group col-sm-3">
    {!! Form::label('usted_bautizado', '¿Es bautizado?:') !!}
    <p>
        @if($visitasHogares->usted_bautizado==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

<!-- Se Congrega Field -->
<div class="form-group col-sm-3">
    {!! Form::label('se_congrega', '¿Actualmente se congrega?:') !!}
    <p>
        @if($visitasHogares->se_congrega==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

<!-- Congregra Frecuencia Field -->
<div class="form-group col-sm-3">
    {!! Form::label('congregra_frecuencia', '¿Con qué frecuencia?:') !!}
    <p>{!! $visitasHogares->congregra_frecuencia !!}</p>
</div>

<!-- Lugar Congrega Field -->
<div class="form-group col-sm-3">
    {!! Form::label('lugar_congrega', '¿Dónde se congrega?:') !!}
    <p>{!! $visitasHogares->lugar_congrega !!}</p>
</div>

<!-- Miembro Activo Field -->
<div class="form-group col-sm-3">
    {!! Form::label('miembro_activo', '¿Es un miembro activo de su congregación?:') !!}
    <p>
        @if($visitasHogares->miembro_activo==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

<!-- Ministerio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('ministerio', '¿En qué ministerio?:') !!}
    <p>{!! $visitasHogares->ministerio !!}</p>
</div>

<!-- Libros Manuales Field -->
<div class="form-group col-sm-3">
    {!! Form::label('libros_manuales', '¿Qué libros y/o manuales utiliza para su crecimiento espiritual?:') !!}
    <p>{!! $visitasHogares->libros_manuales !!}</p>
</div>

<!-- Religion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('religion', 'Religion:') !!}
    <p>{!! $visitasHogares->religion !!}</p>
</div>

<!-- Peticion Oracion Field -->
<div class="form-group col-sm-3">
    {!! Form::label('peticion_oracion', 'Petición de Oración:') !!}
    <p>{!! $visitasHogares->peticion_oracion !!}</p>
</div>

<!-- Porcion Biblica Field -->
<div class="form-group col-sm-3">
    {!! Form::label('porcion_biblica', 'Porción Bíblica:') !!}
    <p>{!! $visitasHogares->porcion_biblica !!}</p>
</div>

<!-- Recomendaciones Familia Field -->
<div class="form-group col-sm-3">
    {!! Form::label('recomendaciones_familia', 'Recomendaciones a la Familia:') !!}
    <p>{!! $visitasHogares->recomendaciones_familia !!}</p>
</div>

<!-- Recomendaciones Colegio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recomendaciones_colegio', 'Recomendaciones al Colegio:') !!}
    <p>{!! $visitasHogares->recomendaciones_colegio !!}</p>
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    <p>
        @if($visitasHogares->estado==0)
        {{"Sí"}}
        @else
        {{"No"}}
        @endif
    </p>
</div>

