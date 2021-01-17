@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        CREAR NUEVO USUARIO
    </h1>
  </section>
<script>
    function validar() {
        if (password.value != password_confirm.value) {
            alert('Contraseñas no coinciden');
            return false;
        } else if(usu_perfil.value==3 && esp_id.value==10) {
            alert('Docente técnico no puede tener como especialidad Cultural');
            return false;
        }else{
            return true;
        }
    }
</script>
<div class="content">
    @include('adminlte-templates::common.errors')
    <div class="box box-primary">
        <div class="box-body">
            @include('flash::message')
            <div class="row">
                {!! Form::open(['route' => 'usuarios.store','autocomplete'=>'on','onsubmit'=>'return validar()']) !!}

                @include('usuarios.fields')

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
