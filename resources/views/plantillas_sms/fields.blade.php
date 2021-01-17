<script>
    $(function(){

    })
    $(document).on("keyup","textarea[name=pln_descripcion]",function(){

        $("#caracteres").text($(this).val().length);

    })
</script>
<!-- Pln Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pln_descripcion', 'Plantilla:') !!}
    {!! Form::textarea('pln_descripcion', null, ['class' => 'form-control']) !!}
    <span class="badge" id="caracteres"></span>
</div>

<!-- Pln Var1 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pln_var1', 'Var1:') !!}
    {!! Form::text('pln_var1', null, ['class' => 'form-control']) !!}
</div>

<!-- Pln Var2 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pln_var2', 'Var2:') !!}
    {!! Form::text('pln_var2', null, ['class' => 'form-control']) !!}
</div>

<!-- Pln Var3 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pln_var3', 'Var3:') !!}
    {!! Form::text('pln_var3', null, ['class' => 'form-control']) !!}
</div>

<!-- Pln Var4 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pln_var4', 'Var4:') !!}
    {!! Form::text('pln_var4', null, ['class' => 'form-control']) !!}
</div>

<!-- Pln Var5 Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pln_var5', 'Var5:') !!}
    {!! Form::text('pln_var5', null, ['class' => 'form-control']) !!}
</div>

<!-- Pln Estado Field -->
<div class="form-group col-sm-3">
    {!! Form::label('pln_estado', 'Estado:') !!}
    {!! Form::select('pln_estado',['0'=>'Activo','1'=>'Inactivo'],null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('plantillasSms.index') !!}" class="btn btn-default">Cancel</a>
</div>
