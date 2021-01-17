<!-- Id Field -->
<div class="form-group" hidden="">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $usuarios->id !!}</p>
</div>
<style>
    .title{
        background:steelblue;
        color:white; 
    }
    .title label{
        padding:10px; 
    }
    tbody tr td{
        border:solid 1px wheat; 
        padding:5px; 
    }
    thead tr th{
        padding:10px; 
        text-align:center;
        border:solid 1px wheat; 
    }
</style>
<script>
    $(function(){
        $("#btn_config").hide();
    })
    $(document).on("click","#usr_tot",function(){
        vl=false;
        if($(this).prop('checked')==true && confirm('Este permiso es para Usuario Administrador Total \n Está seguro de Asignar el Permiso?') ){
            vl=true;
        }
            $('#usr_agregar').attr('checked',vl);
            $('#usr_editar').attr('checked',vl);
            $('#usr_cambiar_clave').attr('checked',vl);
            $('#usr_asigna_horario').attr('checked',vl);
            $('#usr_asigna_cursos').attr('checked',vl);
            $('#usr_permisos').attr('checked',vl);
            $('#usr_ver').attr('checked',vl);
    })
    $(document).on("click","input[name=especial]",function(){
        if($(this).prop('checked')==true){
            vl=true;
        }else{
            vl=false;
        }
            $('input[name=new]').prop('checked',vl);
            $('input[name=edit]').prop('checked',vl);
            $('input[name=del]').prop('checked',vl);
            $('input[name=show]').prop('checked',vl);
    });
    $(document).on("change","#mod_id",function(){
            vl=false;
            $("#btn_config").hide();
            if($(this).val()==7){//Usuarios es modulo especial
                vl=true;
                $("#btn_config").show();
            }
            $('#btn_config').attr('disabled',!vl);
            $('#btn_add').attr('disabled',vl);
            $('input[name=especial]').attr('disabled',vl);
            $('input[name=new]').attr('disabled',vl);
            $('input[name=edit]').attr('disabled',vl);
            $('input[name=del]').attr('disabled',vl);
            $('input[name=show]').attr('disabled',vl);            
    })
    $(document).on("click","#btn_modal_add",function(){

            vl1=0;
            if($('#usr_agregar').prop('checked')==true){
                vl1=1;
            }
            vl2=0;
            if($('#usr_editar').prop('checked')==true){
                vl2=1;
            }
            vl3=0;
            if($('#usr_cambiar_clave').prop('checked')==true){
                vl3=1;
            }
            vl4=0;
            if($('#usr_asigna_horario').prop('checked')==true){
                vl4=1;
            }
            vl5=0;
            if($('#usr_asigna_cursos').prop('checked')==true){
                vl5=1;
            }
            vl6=0;
            if($('#usr_permisos').prop('checked')==true){
                vl6=1;
            }
            vl7=0;
            if($('#usr_ver').prop('checked')==true){
                vl7=1;
            }

        dt= vl1+"&"+
            vl2+"&"+
            vl3+"&"+
            vl4+"&"+
            vl5+"&"+
            vl6+"&"+
            vl7;

        $("#permisos_especiales").val(dt);

        $("#frm_asigna_permisos").submit();
    })

</script>
<style>
    .table-hover tr:hover{
        cursor:pointer; 
    }
    .cls_prm_usr{
        margin-left:5px; 
    }
</style>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
          <span aria-hidden="true" class="pull-right">&times;</span>
      <div class="modal-body">
        <table class="table table-hover" id="prm_usuarios">
            <tr>
                <th></th>
                <th>PERMISOS DE USUARIOS</th>
                <th><input type="checkbox" id="usr_tot" value="0"></th>
            </tr>
            <tr>
                <td>1</td><td>Agregar</td>
                <td><input type="checkbox" id="usr_agregar" value="1"></td>
            </tr>
            <tr>
                <td>2</td><td>Editar</td>
                <td><input type="checkbox" id="usr_editar" value="2"></td>
            </tr>
            <tr>
                <td>3</td><td>Cambiar Clave</td>
                <td><input type="checkbox" id="usr_cambiar_clave" value="3"></td>
            </tr>
            <tr>
                <td>4</td><td>Asignar Horario</td>
                <td><input type="checkbox" id="usr_asigna_horario" value="4"></td>
            </tr>
            <tr>
                <td>5</td><td>Asignar Cursos</td>
                <td><input type="checkbox" id="usr_asigna_cursos" value="5"></td>
            </tr>
            <tr>
                <td>6</td><td>Permisos</td>
                <td><input type="checkbox" id="usr_permisos" value="6"></td>
            </tr>
            <tr>
                <td>7</td><td>Ver</td>
                <td><input type="checkbox" id="usr_ver" value="7"></td>
            </tr>
            <tr>

            </tr>  
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn_modal_add">Añadir</button>
      </div>
    </div>
  </div>
</div>


<div>
    {!! $usuarios->usu_foto !!}
</div>

<div class="form-group title ">
    {!! Form::label('name', 'Nombres:') !!}
    {!! $usuarios->usu_apellidos.' '.$usuarios->name!!}
    {!! Form::label('username', 'Usuario:') !!}
    {!! $usuarios->username !!}
    {!! Form::label('descripcion', 'Usu Perfil:') !!}
    {!! $usuarios->descripcion !!}
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Modulo</th>
            <th>Total</th>
            <th>Agregar</th>
            <th>Editar</th>
            <th>Eliminar</th>
            <th>Ver</th>
            <th>...</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            {!! Form::open(['route' => 'asignaPermisos.store','id'=>'frm_asigna_permisos']) !!}
            <td>
                <input type="hidden" name="usu_id" id="usu_id" value="{!! $usuarios->id !!}" />
                <input type="hidden" name="permisos_especiales" id="permisos_especiales" value="0">
                <i class="btn btn-success fa fa-outdent" id="btn_config"  data-toggle="modal" data-target="#exampleModal" ></i>
            </td>
            <td>
                <select name="mod_id" id="mod_id" class="form-control">
                    <option value="0">Todos</option>
                    @foreach($modulos as $m)
                    <option value="{{$m->id}}">{{$m->menu.' / '}} {{$m->submenu}}</option>
                    @endforeach
                </select>
            </td>
            <td class="text-center">
                {{ Form::checkbox('especial', 1, false) }}
            </td>
            <td class="text-center">
                {{ Form::checkbox('new', 1, false) }}
            </td>
            <td class="text-center">
                {{ Form::checkbox('edit', 1, false) }}
            </td>
            <td class="text-center">
                {{ Form::checkbox('del', 1, false) }}
            </td>
            <td class="text-center">
                {{ Form::checkbox('show', 1, false) }}
            </td>

            <td align='center'>
                {!! Form::submit('+', ['class' => 'btn btn-primary','id'=>'btn_add']) !!}
            </td>
            {!! Form::close() !!}   
        </tr>
        <?php
        $n = 1;
        ?>
        @foreach($permisos as $p)
        <tr>
            <td>{{$n++}}</td>
            <td>{{$p->menu }} {{'/'}} {{$p->submenu}}</td>
            @if($p->permisos_especiales!=null && strlen(trim($p->permisos_especiales))>1)
            <td colspan="5" class="text-left">
                <?php  
                    $d=explode("&",$p->permisos_especiales);
                    if($d[0]==1){echo "<span class='label label-primary cls_prm_usr'>Agregar</span>";}
                    if($d[1]==1){echo "<span class='label label-primary cls_prm_usr'>Editar</span>";}
                    if($d[2]==1){echo "<span class='label label-primary cls_prm_usr'>Cambiar Clave</span>";}
                    if($d[3]==1){echo "<span class='label label-primary cls_prm_usr'>Asiganr Horario</span>";}
                    if($d[4]==1){echo "<span class='label label-primary cls_prm_usr'>Asignar Cursos</span>";}
                    if($d[5]==1){echo "<span class='label label-primary cls_prm_usr'>Asignar Permisos</span>";}
                    if($d[6]==1){echo "<span class='label label-primary cls_prm_usr'>Ver</span>";}
                ?>
            </td>
            @else
            <td align='center'>
                @if($p->especial==1)
                {{'x'}}
                @else    
                {{'-'}}
                @endif
            </td>
            <td align='center'>
                @if($p->new==1)
                {{'x'}}
                @else    
                {{'-'}}
                @endif
            </td>
            <td align='center'>
                @if($p->edit==1)
                {{'x'}}
                @else    
                {{'-'}}
                @endif
            </td>
            <td align='center'>
                @if($p->del==1)
                {{'x'}}
                @else    
                {{'-'}}
                @endif
            </td>
            <td align='center'>
                @if($p->show==1)
                {{'x'}}
                @else    
                {{'-'}}
                @endif
            </td>
@endif
            <td>
            {!! Form::open(['route' => ['asignaPermisos.destroy', $p->id], 'method' => 'delete']) !!}
            <div class='btn-group'>
                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Desea Eliminar el Item?')"]) !!}
            </div>
            {!! Form::close() !!}
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
