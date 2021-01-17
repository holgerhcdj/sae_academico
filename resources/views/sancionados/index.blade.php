@extends('layouts.app')

@section('content')
    <section class="content-header">
    <div class="row text-center" style="margin-top:-30px; ">
        <h3 class="bg-primary">Lista de Sanciones a los Estudiantes</h3>
    </div>

    <div class="col-md-6">
        <form action="sancionados.index" method="POST">
            {{csrf_field()}}
            <div class="input-group">
              <input type="text" class="form-control" name="est" placeholder="Cedula / Apellidos del Estudiante">
              <span class="input-group-btn">
                <button class="btn btn-default" name="buscar" value="buscar">Buscar</button>
            </span>
        </div>
    </form>
</div>

          
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('sancionados.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

