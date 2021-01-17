<!-- Usu Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Tipo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_tipo', 'Tar Tipo:') !!}
    {!! Form::number('tar_tipo', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Titulo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_titulo', 'Tar Titulo:') !!}
    {!! Form::text('tar_titulo', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_descripcion', 'Tar Descripcion:') !!}
    {!! Form::text('tar_descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Adjuntos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_adjuntos', 'Tar Adjuntos:') !!}
    {!! Form::text('tar_adjuntos', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Link Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_link', 'Tar Link:') !!}
    {!! Form::text('tar_link', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Finicio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_finicio', 'Tar Finicio:') !!}
    {!! Form::date('tar_finicio', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Hinicio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_hinicio', 'Tar Hinicio:') !!}
    {!! Form::text('tar_hinicio', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Ffin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_ffin', 'Tar Ffin:') !!}
    {!! Form::date('tar_ffin', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Hfin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_hfin', 'Tar Hfin:') !!}
    {!! Form::text('tar_hfin', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_estado', 'Tar Estado:') !!}
    {!! Form::number('tar_estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Cursos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_cursos', 'Tar Cursos:') !!}
    {!! Form::text('tar_cursos', null, ['class' => 'form-control']) !!}
</div>

<!-- Tar Aux Cursos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tar_aux_cursos', 'Tar Aux Cursos:') !!}
    {!! Form::text('tar_aux_cursos', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('aulaVirtuals.index') !!}" class="btn btn-default">Cancel</a>
</div>
