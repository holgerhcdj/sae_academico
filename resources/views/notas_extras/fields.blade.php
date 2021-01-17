<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    {!! Form::number('id', null, ['class' => 'form-control']) !!}
</div>

<!-- Est Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('est_id', 'Est Id:') !!}
    {!! Form::number('est_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Anl Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('anl_id', 'Anl Id:') !!}
    {!! Form::number('anl_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Emi Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('emi_id', 'Emi Id:') !!}
    {!! Form::number('emi_id', null, ['class' => 'form-control']) !!}
</div>

<!-- F Registro Field -->
<div class="form-group col-sm-6">
    {!! Form::label('f_registro', 'F Registro:') !!}
    {!! Form::text('f_registro', null, ['class' => 'form-control']) !!}
</div>

<!-- Cert Primaria Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cert_primaria', 'Cert Primaria:') !!}
    {!! Form::text('cert_primaria', null, ['class' => 'form-control']) !!}
</div>

<!-- Par Estudiantil Field -->
<div class="form-group col-sm-6">
    {!! Form::label('par_estudiantil', 'Par Estudiantil:') !!}
    {!! Form::number('par_estudiantil', null, ['class' => 'form-control']) !!}
</div>

<!-- Ex Enes Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ex_enes', 'Ex Enes:') !!}
    {!! Form::number('ex_enes', null, ['class' => 'form-control']) !!}
</div>

<!-- Responsable Field -->
<div class="form-group col-sm-6">
    {!! Form::label('responsable', 'Responsable:') !!}
    {!! Form::text('responsable', null, ['class' => 'form-control']) !!}
</div>

<!-- Obs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('obs', 'Obs:') !!}
    {!! Form::text('obs', null, ['class' => 'form-control']) !!}
</div>

<!-- N2 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n2', 'N2:') !!}
    {!! Form::number('n2', null, ['class' => 'form-control']) !!}
</div>

<!-- N3 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n3', 'N3:') !!}
    {!! Form::number('n3', null, ['class' => 'form-control']) !!}
</div>

<!-- N4 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n4', 'N4:') !!}
    {!! Form::number('n4', null, ['class' => 'form-control']) !!}
</div>

<!-- N5 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n5', 'N5:') !!}
    {!! Form::number('n5', null, ['class' => 'form-control']) !!}
</div>

<!-- N6 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n6', 'N6:') !!}
    {!! Form::number('n6', null, ['class' => 'form-control']) !!}
</div>

<!-- N7 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n7', 'N7:') !!}
    {!! Form::number('n7', null, ['class' => 'form-control']) !!}
</div>

<!-- N8 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n8', 'N8:') !!}
    {!! Form::number('n8', null, ['class' => 'form-control']) !!}
</div>

<!-- N9 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n9', 'N9:') !!}
    {!! Form::number('n9', null, ['class' => 'form-control']) !!}
</div>

<!-- N10 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n10', 'N10:') !!}
    {!! Form::number('n10', null, ['class' => 'form-control']) !!}
</div>

<!-- N11 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n11', 'N11:') !!}
    {!! Form::number('n11', null, ['class' => 'form-control']) !!}
</div>

<!-- N12 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n12', 'N12:') !!}
    {!! Form::number('n12', null, ['class' => 'form-control']) !!}
</div>

<!-- N13 Field -->
<div class="form-group col-sm-6">
    {!! Form::label('n13', 'N13:') !!}
    {!! Form::number('n13', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('notasExtras.index') !!}" class="btn btn-default">Cancel</a>
</div>
