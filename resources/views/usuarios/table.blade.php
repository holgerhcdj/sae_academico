@section('scripts')
<script>
$(document).ready(function () {
   $('#entradafilter').keyup(function () {
      var rex = new RegExp($(this).val(), 'i');
        $('.contenidobusqueda tr').hide();
        $('.contenidobusqueda tr').filter(function () {
            return rex.test($(this).text());
        }).show();
        })
});
</script>
@endsection

<script>
    
    $(document).on("click",".add_departamento",function(){
        $("#modal_titulo").text("DEPARTAMENTOS DE: "+$(this).attr("usu_name"));
        $("#modal_titulo_dep").text("DEPARTAMENTO PRINCIPAL: "+$(this).text());
        $("#modal_titulo_dep").attr('data',$(this).attr("dep_id"));

        var url=window.location;
        var token=$("input[name=_token]").val();
        $("input[name=usu_id]").val($(this).attr("usu_id"));
        $.ajax({
            url: url+'/dep_asignados',//UsuariosController@dep_asignados
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {us:$(this).attr("usu_id")},
            beforeSend:function(){
            },
            success:function(d){
                
                $("#tbl_datos").html(d);
            }
        })
    })

    $(document).on("click","#btn_add_dep",function(){

        var url=window.location;
        var token=$("input[name=_token]").val();
        var dp=$("select[name=dep_id]").val();
        var us=$("input[name=usu_id]").val();
        $.ajax({
            url: url+'/asignar_departamento',//UsuariosController@asignar_departamento
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {us:us,dp:dp},
            beforeSend:function(){
                if(dp=='0'){
                    alert("Elija un departamento");
                    return false;
                }

                if(validar_duplicados(dp)==1){
                    alert("Departamento ya está asignado");
                    return false;
                }

            },
            success:function(d){
                //tbl_datos(d);
                $("#tbl_datos").append(d);
            }
        })


    })


function validar_duplicados(dp){
var i=0;
    $(".cls_ids").each(function(){
        if($(this).attr('data')==dp){
            i=1;
        }
    })
    return i;
}

    $(document).on("click",".btn_elimina_asg",function(){
        var obj=$(this).parent().parent();
        var url=window.location;
        var token=$("input[name=_token]").val();
        var aud=$(this).attr('data');
        $.ajax({
            url: url+'/elimina_asignar_departamento',//UsuariosController@elimina_asignar_departamento
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {aud:aud},
            beforeSend:function(){
                if(!confirm("Esta seguro de eliminar?")){
                    return false;
                }
            },
            success:function(d){
                if(d==0){
                    obj.remove();
                }else{
                    alert(d);
                }
                
            }
        })
    })


</script>


<!-- Modal -->
<div class="modal fade" id="modal_asg_departamentos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title bg-black text-center" id="modal_titulo"></h4>
        <h4 class="modal-title cls_ids" id="modal_titulo_dep"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-sm-12">
            <input type="hidden" name="usu_id" >
              <div class="input-group "> 
                <span class="btn input-group-addon" id="btn_add_dep" style="background:#047E15;color:white  ">Agregar</span>
                <select name="dep_id" id="dep_id" class="form-control">
                    <option value="0">Departamento</option>
                    @foreach($dep as $dp)
                    <option value="{{$dp->id}}">{{$dp->departamento}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">#</div>
            <div class="col-sm-8">Gerencia/Departamento</div>
            <div class="col-sm-2">...</div>
        </div>
        <div id="tbl_datos">
            
        </div>
      </div>
    </div>
  </div>
</div>





<div class="row">
  <div class="col-sm-9">
      <div class="input-group "> 
        <span class="input-group-addon">BUSCAR EN LISTA</span>
        <input id="entradafilter" type="text" class="form-control">
    </div>
  </div>
  <form action="usuarios.buscar" method="POST">
    {{ csrf_field() }}
   <div class="col-sm-2">
        <select class="form-control" id="usu_estado" name="usu_estado">
            <option value="0">Activo</option>     
            <option value="1">InActivo</option>     
        </select>
  </div>
  <div class="col-sm-1">
    <!-- <input type="submit" name="btn_search_usr" id="btn_search_usr" value="B"> -->
        <button class="btn btn-primary" name="btn_search_usr" id="btn_search_usr"><i class="fa fa-search"></i></button>
  </div>
  </form>
</div>


<table class="table table-responsive" id="usuarios-table">
    <thead>
    <th>No</th>
    <th>Nombre Completo</th>
    <th>Usuario del Sistema</th>
    <th>Departamento</th>        
    <th>Estado</th>
    <th>Horario</th>
    <th>Asg.Cursos</th>
    <th>Permisos</th>
    <th>Acciones</th>
</thead>
<?php
$n = 1;
?>
<tbody class="contenidobusqueda">
    @foreach($usuarios as $user)
    <tr>
        <td>{!! $n++ !!}</td>
        <td title="{{$user->id}}">{!! strtoupper($user->usu_apellidos." ".$user->name) !!}</td>
        <td>{!! $user->username !!}</td>
        <td class="btn add_departamento" data-toggle="modal" data-target="#modal_asg_departamentos" dep_id="{{$user->usu_perfil}}" usu_name="{!! strtoupper($user->usu_apellidos.' '.$user->name) !!}" usu_id="{{$user->id}}" >
            {!! $user->ger_codigo.' / '.$user->descripcion !!}
        </td>
        <td>
            <?php
            switch ($user->usu_estado) {
                case 0:echo $estado = "Activo";
                    break;
                case 1:echo $estado = "Inactivo";
                    break;
                default :
                    echo $estado = "Indefinido";
                    break;
            }
            ?>
        </td>
        <td>
            @if($pr[3]==1)                            
            <a href="{!! route('asignaHorarios.create',['usu_id'=>$user->id]) !!}" class='btn btn-default btn-xs' title="Asignar Horario" ><i class="fa fa-calendar text-primary"></i></a>
            @endif            
        </td>
        <td>
            @if($pr[4]==1)                            
            <a href="{!! route('asignaHorarios.show',['usu_id'=>$user->id]) !!}" class='btn btn-default btn-xs' title="Asignar Cursos" ><i class="fa fa-users text-primary"></i></a>
            @endif            
        </td>
        <td>
            @if($pr[5]==1)                            
            <a href="{!! route('usuarios.show', [$user->id]) !!}" class='btn btn-default btn-xs' title="Permisos" ><i class="glyphicon glyphicon-cog text-danger "></i></a>
            @endif            
        </td>
        <td>
            <div class='btn-group'>
                @if($pr[1]==1)                
                <a href="{!! route('usuarios.edit', [$user->id,'op'=>1] ) !!}" class='btn btn-default btn-xs' title="Editar" ><i class="glyphicon glyphicon-pencil text-info"></i></a>
                @endif                
                @if($pr[2]==1)                
                <a href="{!! route('usuarios.edit', [$user->id,'op'=>2] ) !!}" class='btn btn-default btn-xs' title="Resetear Clave" ><i class="fa fa-key text-info"></i></a>
                @endif                                
                @if($pr[6]==1)                
                <a href="{!! route('usuarios.edit', [$user->id,'op'=>3] ) !!}" class='btn btn-default btn-xs' title="Ver Ficha" ><i class="fa fa-eye text-info"></i></a>
                @endif                                
            </div>
        </td>
    </tr>
    @endforeach
</tbody>
</table>
