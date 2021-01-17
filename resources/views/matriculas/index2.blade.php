@extends('layouts.app')

@section('content')
<section class="content-header">
    <form action="matriculas.buscar" method="GET">
        Jornada: <select name="jor" id="jor">
            <option value="0">Todos</option>
            @foreach($jor as $j)
            <option value="{{$j->id}}">{{ $j->jor_descripcion }}</option>
            @endforeach
        </select>
        Especialidad: <select name="esp" id="esp">
            <option value="0">Todos</option>
            @foreach($esp as $e)
            <option value="{{$e->id}}">{{ $e->esp_descripcion }}</option>
            @endforeach
        </select>
        Curso: <select name="cur" id="cur">
            <option value="0">Todos</option>
            @foreach($cur as $c)
            <option value="{{$c->id}}">{{ $c->cur_descripcion }}</option>
            @endforeach
        </select>
        
            <input class="btn btn-default" type="submit" value="Buscar" />                    
    </form> 

</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            @include('matriculas.table')
        </div>
    </div>
</div>
@endsection

