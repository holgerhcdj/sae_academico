<style>
    .divisor{
        background-color:#eee; 
        border:solid 1px #ccc; 
        text-align:center;
        margin-top:5px; 
        font-weight:bolder;   
    }
</style>
<div class="form-group col-sm-3">
    {!! Form::label('usu_apellidos', 'Apellidos:') !!}
    {!! Form::text('usu_apellidos', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('name', 'Nombres:') !!}
    {!! Form::text('name', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- Email Field -->
<div class="form-group col-sm-3" >
    {!! Form::label('email', 'Correo Electronico:') !!}
    {!! Form::email('email', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-3" >
    {!! Form::label('materia', 'Materias:') !!}
    {!! Form::text('materia', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('esp_id', 'Especialidad:') !!}
    {!! Form::select('esp_id',$especialidades,null,['class'=>'form-control']) !!}    
</div>
<div class="form-group col-sm-6" >

    {!! Form::label('jor1', 'Matutina:') !!}
    {{ Form::checkbox('jor1', 1, null, ['class' => 'field']) }}
    {!! Form::label('jor4', 'Vespertina:') !!}
    {{ Form::checkbox('jor4', 1, null, ['class' => 'field']) }}
    {!! Form::label('jor2', 'Nocturna:') !!}
    {{ Form::checkbox('jor2', 1, null, ['class' => 'field']) }}
    {!! Form::label('jor3', 'Semi-Presencial:') !!}
    {{ Form::checkbox('jor3', 1, null, ['class' => 'field']) }}
</div>

<span class="divisor col-sm-12">CREDENCIALES</span>
<!-- Password Field -->
<div class="form-group col-sm-3">
    {!! Form::label('username', 'Usuario (Alias):') !!}
    {!! Form::text('username', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<div class="form-group col-sm-3">
    {!! Form::label('password', 'Contraseña:') !!}
    {!! Form::password('password', ['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('password_confirm', 'Confirme Contraseña:') !!}
    {!! Form::password('password_confirm', ['class' => 'form-control','required'=>'required']) !!}
</div>
<div class="form-group col-sm-3">
    {!! Form::label('usu_perfil', 'Departamento/Perfil:') !!}
    {!! Form::select('usu_perfil',$departamentos,null,['class'=>'form-control']) !!}    
</div>
<div class="form-group col-sm-12">
    {!! Form::submit('Guadrar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('usuarios.index') !!}" class="btn btn-default">Cancelar</a>
</div>
@section('scripts')
<script>
    $(function(){
        $(document).on('change', '#usu_perfil', function () {
            if(this.value==3){
                $("#esp_id").show();
                $("#esp_id").val(5);                
            }else{
                $("#esp_id").val(10);                
                $("#esp_id").hide();
            }
        });
    })
</script>
@endsection
