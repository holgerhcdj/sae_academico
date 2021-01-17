<!-- Menu Field -->
<div class="form-group col-sm-6">
    {!! Form::label('menu', 'Menu:') !!}
    {!! Form::text('menu', null, ['class' => 'form-control']) !!}
</div>

<!-- Submenu Field -->
<div class="form-group col-sm-6">
    {!! Form::label('submenu', 'Submenu:') !!}
    {!! Form::text('submenu', null, ['class' => 'form-control']) !!}
</div>

<!-- Direccion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('direccion', 'Direccion:') !!}
    {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::number('estado', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('mod_grupo', 'Grupo:') !!}
    {!! Form::number('mod_grupo', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('modulos.index') !!}" class="btn btn-default">Cancel</a>
</div>
