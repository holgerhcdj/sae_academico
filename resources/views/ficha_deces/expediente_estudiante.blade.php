<?php
function getAge($birthday) {
    $birth = strtotime($birthday);
    $now = strtotime('now');
    $age = ($now - $birth) / 31536000;
    return floor($age);
}

?>

@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="text-center btn-primary">
           Expediente del Estudiante
        </h1>
    
   <table style="margin-top: 20px;">
      <tr>
          <td>
              <form action="expediente_estudiantil" method="POST"> 
              {{csrf_field()}}
                <div class="form-group col-sm-4">
                <input type="text" name="estudiante" class="form-control" size="80" placeholder="Nombre del Estudiante">
                </div>
                <div class="form-group col-sm-4">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
             </form>
           </td>
      </tr>
  </table>
</section>
  <div class="content" style="margin-top:-10px; ">
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    <table class="table table-responsive" >
    <thead>
        <tr>
        <th>#</th>
        <th>Cedula</th>
        <th>Estudiante</th>
        <th>Sexo</th>
        <th>Edad</th>
        <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $x=1;
        ?>
    @foreach($exp as $e)
        <tr>
            <td>{{$x++}}</td>
            <td>{{$e->est_cedula}}</td>
            <td>{{$e->est_apellidos.' '.$e->est_nombres}}</td>
            <td><?php if(($e->est_sexo)==0){echo "M";}else{echo "F";}?></td>
            <td><?php echo getAge($e->est_fnac)." años" ?></td>
            <td>
               
                <a href="{!! route('fichaDeces.show', [$e->id]) !!}" class='btn btn-default btn-xs' title="Expediente Estudiante" ><i class="glyphicon glyphicon-user text-danger"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection