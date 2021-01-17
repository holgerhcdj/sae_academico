<!-- Ae Primaria Field -->
<span class="divisor col-sm-12">
ANTECEDENTES SOCIOECONOMICOS
</span>
<!-- Sc Tipo Casa Field -->
<div class="form-group col-sm-2">
    {!! Form::label('sc_tipo_casa', 'Tipo Casa:') !!}
    {!! Form::select('sc_tipo_casa',['0'=>'Propia','1'=>'Arrendada','2'=>'Otra'],null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('sc_tipo_construccion', 'Tipo de Construccion:') !!}
    {!! Form::select('sc_tipo_construccion',['0'=>'Hormigón','1'=>'Bloque','2'=>'Ladrillo','3'=>'Mixta'],null, ['class' => 'form-control']) !!}
</div>
<!-- Sc Num Hab Field -->
<div class="form-group col-sm-2">
    {!! Form::label('sc_num_hab', 'Num.Habitaciones:') !!}
    {!! Form::text('sc_num_hab', null, ['class' => 'form-control input-number']) !!}
</div>
<!-- Sc Resp Economica Field -->
<div class="form-group col-sm-3">
    {!! Form::label('sc_resp_economica', 'Responsable de la Economía:') !!}
    {!! Form::select('sc_resp_economica',['Madre'=>'Madre','Padre'=>'Padre','Representante'=>'Representante'],null,['class' => 'form-control']) !!}
</div>

<!-- Sc Nivel Field -->
<div class="form-group col-sm-2">
    {!! Form::label('sc_nivel', 'Nivel Economico:') !!}
    {!! Form::select('sc_nivel',['MB'=>'MB','B'=>'B','R'=>'R','M'=>'M'],null,['class' => 'form-control']) !!}
</div>
<span class="divisor col-sm-12">
SERVICIOS BÁSICOS
</span>
<!-- Sb Agua Field -->
<div class="form-group col-sm-2">
    {!! Form::label('sb_agua', 'Agua:') !!}
    {!! Form::checkbox('sb_agua', null, ['class' => 'form-control']) !!}
</div>    
<div class="form-group col-sm-2">
    {!! Form::label('sb_electricidad', 'Luz:') !!}
    {!! Form::checkbox('sb_electricidad', null, ['class' => 'form-control']) !!}    
</div>    
<div class="form-group col-sm-2">
    {!! Form::label('sb_alcantarillado', 'Alcantarillado:') !!}
    {!! Form::checkbox('sb_alcantarillado', null, ['class' => 'form-control']) !!}
</div>    
<div class="form-group col-sm-2">
    {!! Form::label('sb_telefono', 'Telefono:') !!}
    {!! Form::checkbox('sb_telefono', null, ['class' => 'form-control']) !!}
</div>    
<div class="form-group col-sm-2">
    {!! Form::label('sb_internet', 'Internet:') !!}
    {!! Form::checkbox('sb_internet', null, ['class' => 'form-control']) !!}
</div>    
<div class="form-group col-sm-2">
    {!! Form::label('sb_azfaltado', 'Azfaltado:') !!}
    {!! Form::checkbox('sb_azfaltado', null, ['class' => 'form-control']) !!}
</div>    

