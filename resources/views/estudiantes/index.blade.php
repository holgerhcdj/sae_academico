@extends('layouts.app')
@section('content')
<?php
$est=1;
$parc=0;
$part=0;
if(isset($busqueda['mat_estado'])){
    $est=$busqueda['mat_estado'];
}
if(isset($busqueda['parc'])){
    $parc=$busqueda['parc'];
}
if(isset($busqueda['part'])){
    $part=$busqueda['part'];

}

?>
@section('scripts')
<script>
    $(function(){
        $("#mat_estado").val({{$est}});
        $("#parc").val('{{$parc}}');
        $("#part").val('{{$part}}');
    });

    var url=window.location;
    $(document).on("click","#btn_estadistica",function(){
                $.ajax({
                    url: url + "/mostrar/estadistica",
                    type: 'GET',
                    dataType: 'json',
                    beforeSend: function () {
                    },
                    success: function (dt) {
                        //alert(dt);
                        $(".cont_estadistica").show("slow");
                        $("#tbody_datos").html(dt)
                    }
                });
        
    })

    $(document).on("click","#btn_close,.fa-close",function(){
        $(".cont_estadistica").hide("slow");
    })

</script>

<style>
.cont_estadistica{
    width:40%;
    margin-left:20%;
    position:fixed;
    z-index:999;
    display:none;
    box-shadow: 5px 5px 5px 5px #999999;      
}
.table-fixed thead {
  width: 97%;
}
.table-fixed tbody {
  height: 400px;
  overflow-y: auto;
  width: 100%;
}
.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
  display: block;
}
.table-fixed tbody td, .table-fixed thead > tr> th {
  float: left;
  border-bottom-width: 0;
}
label{
    background:#ccc; 
}

</style>
@endsection
<section class="content-header">
        <h1 style="text-align:center;border-radius:2px;margin-top:-10px;   ">
            Lista de Estudiantes
        </h1>
    <form action="estudiantes.busqueda" method="POST">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="form-group col-sm-2 text-center" >
            <select name="jor" id="jor" class="form-control" >
                <option value="0">Jornada</option>
                @foreach($jor as $j)
                @if(isset($busqueda) && ($j->id==$busqueda['jor']))
                <option selected value="{{$j->id}}">{{ $j->jor_descripcion }}</option>
                @else
                <option value="{{$j->id}}">{{ $j->jor_descripcion }}</option>
                @endif
                @endforeach
            </select>  
        </div>
        <div class="form-group col-sm-2">
            <select name="esp" id="esp" class="form-control">
                <option value="0">Especialidad</option>
                @foreach($esp as $e)
                @if(isset($busqueda) && ($e->id==$busqueda['esp']))                                            
                <option selected value="{{$e->id}}">{{ $e->esp_descripcion }}</option>
                @else
                <option value="{{$e->id}}">{{ $e->esp_descripcion }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-2">
            <select name="cur" id="cur" class="form-control">
                <option value="0">Curso</option>
                @foreach($cur as $c)
                @if(isset($busqueda) && ($c->id==$busqueda['cur']))
                <option selected value="{{$c->id}}">{{ $c->cur_descripcion }}</option>
                @else
                <option value="{{$c->id}}">{{ $c->cur_descripcion }}</option>
                @endif
                @endforeach
            </select>                
        </div>
        <div class="form-group col-sm-2">
            <select name="parc" id="parc" class="form-control">
                <option value="0">Paralelo C.</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
                <option value="F">F</option>
                <option value="G">G</option>
                <option value="H">H</option>
                <option value="I">I</option>
                <option value="NINGUNO">NINGUNO</option>
            </select>                
        </div>
        <div class="form-group col-sm-2">
            <select name="part" id="part" class="form-control">
                <option value="0">Paralelo T.</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
                <option value="F">F</option>
                <option value="G">G</option>
                <option value="H">H</option>
                <option value="I">I</option>
                <option value="NINGUNO">NINGUNO</option>
            </select>                
        </div>
        <div class="form-group col-sm-2">
            <select name="mat_estado" id="mat_estado" class="form-control" >
                <option value="0">Inscrito</option>
                <option value="1">Matriculado</option>
                <option value="2">Retirado</option>
                <option value="3">Anulado</option>
                <option value="4">Otro</option>                
            </select>
        </div>

        <div class="form-group col-sm-6">
            <div class="input-group">
                <input type="text" class="form-control" name="txt" id="txt" placeholder="Nombres / Apellidos /Cedula" value="<?php
                if (isset($busqueda)) {
                    echo $busqueda['txt'];
                }
                ?>" >
                <span class="input-group-btn">
                    <input class="btn btn-primary " type="submit" name="search"  value="Buscar" />                    
                    <?php
                    if (count($estudiantes) == 0) {
                        ?>
                        <button style="margin-left:30% " disabled class="btn btn-success " type="submit" name="search"  value="excel">Excel</button>
                        <button style="margin-left:10px " disabled class="btn btn-danger" type="submit" name="search"  value="pdf">PDF</button>
                        <?php
                    } else {
                        ?>
                        <button style="margin-left:30% " class="btn btn-success " type="submit" name="search"  value="excel">Excel</button>
                        <button style="margin-left:10px "  class="btn btn-danger" type="submit" name="search"  value="pdf">PDF</button>
                        <?php
                    }
                    ?>
                </span>
            </div>
        </div>

        <div class="form-group col-sm-4">
            <div class="input-group">
                <button style="margin-left:50% " class="btn btn-warning " type="submit" name="search"  value="matriz" >Matriz</button>
            </div>
        </div>
        @if($permisos['new']==1 && $anl_select[0]['especial']==0)
                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('estudiantes.create') !!}">Nuevo</a>                
        @endif
    </form>    
    <span class="btn btn-info" id="btn_estadistica">Estadistica</span>
</section>

<div class="cont_estadistica">
      <div class="panel panel-default">
        <div class="panel-heading bg-primary">
          <h4>
            Estadisticas por Curso y Paralelo
            <span id="#btn_close" class="btn btn-danger pull-right"><i class="fa fa-close" aria-hidden="true"></i></span>
          </h4>
        </div>
        <table class="table table-fixed">
          <thead>
            <tr class="text-primary">
              <th class="col-xs-4 bg-info">Jornada</th>
              <th class="col-xs-4 bg-info">Curso</th>
              <th class="col-xs-2 bg-info">Paralelo</th>
              <th class="col-xs-2 bg-info">Cant</th>
            </tr>
          </thead>
          <tbody id="tbody_datos">
          </tbody>
        </table>
      </div>
</div>

<div class="content">
    <div class="clearfix"></div>
    <div class="clearfix"></div>
        <div class="table-responsive" style="background:#fff ">
            @include('estudiantes.table')
        </div>
</div>
@endsection

