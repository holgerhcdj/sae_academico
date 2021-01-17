<?php
$op=0;
if(isset($clasesOnline)){
$op=1;
}
?>

<script>

$(function(){
    var op='{{$op}}';
    var prf='{{$usr->usu_perfil}}';
    if(op==0){
        if(prf==3){
         $("select[name=mtr_id]").val(1);
     }
    }


})


    $(document).on("click",".btn_agrega_cursos",function(){
        $("#mdl_cursos").modal("show");

        $('.chk_cur').attr('checked',false);


var opt="";
        if($("select[name=mtr_id]").val()==1){
            opt+="<option value='CO'>CONTABILIDAD</option>";
            opt+="<option value='EI'>ELECTRICIDAD</option>";
            opt+="<option value='EO'>ELECTRÓNICA</option>";
            opt+="<option value='IN'>INFORMÁTICA</option>";
            opt+="<option value='MA'>MECANICA AUTOMOTRIZ</option>";
            opt+="<option value='MI'>MECÁNICA INDUSTRIAL</option>";
        }else{
            opt+="<option value='CU'>Cultural</option>";
            opt+="<option value='BG'>BGU</option>";
            opt+="<option value='BX'>Básica Flexible</option>";
        }

        $("#tipo").html(opt);


    })

    $(document).on("click",".btn_salir",function(){
        $("#mdl_cursos").modal("hide");

    })
    $(document).on("click",".btn_agrega_cursos_seleccionados",function(){

if($("#jor_id").val()=='0'){
    alert('Elija una Jornada');
}else{

        $("#mdl_cursos").modal("hide");
        var cur="";
        $(".chk_cur").each(function(){
            if($(this).prop("checked")){
                cur+=$("#jor_id").val()+"-"+$("select[name=tipo]").val()+"-"+$(this).attr('data')+"-"+$(this).val()+",";
            }

        })
        $("input[name=cls_cursos]").val(cur);
}

    })


</script>
<!-- Usu Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id',Auth::user()->id, ['class' => 'form-control']) !!}
</div>

<!-- Mtr Id Field -->
<div class="form-group col-sm-3">
    {!! Form::label('mtr_id', 'Materia:') !!}
    {!! Form::select('mtr_id',$mtr,null, ['class' => 'form-control']) !!}
</div>

<!-- Cls Link Field -->
<div class="form-group col-sm-9">
    {!! Form::label('cls_link', 'Link del Zoom:') !!}
    {!! Form::text('cls_link', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Cls Link Field -->
<div class="form-group col-sm-6">
        <div class="input-group">
          {!! Form::label('cls_cursos', 'Cursos:',['class'=>'input-group-addon']) !!}
          {!! Form::text('cls_cursos', null, ['class' => 'form-control','required'=>'required']) !!}
          <i class='btn btn-primary input-group-addon btn_agrega_cursos'>Agregar</i>
      </div>
</div>

<!-- Cls Days Field -->
<div class="form-group col-sm-6">
    <div class="input-group">
    {!! Form::label('cls_days', 'Día:',['class'=>'input-group-addon']) !!}
    {!! Form::select('cls_days',['1'=>'Lunes','2'=>'Martes','3'=>'miercoles','4'=>'Jueves','5'=>'Viernes','6'=>'Sábado'],null, ['class' => 'form-control']) !!}
    </div>
</div>

<!-- Cls Hinicio Field -->
<div class="form-group col-sm-3">
    {!! Form::label('cls_hinicio', 'Desde:') !!}
    {!! Form::time('cls_hinicio', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Cls Hfin Field -->
<div class="form-group col-sm-3">
    {!! Form::label('cls_hfin', 'Hasta:') !!}
    {!! Form::time('cls_hfin', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Cls Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cls_estado', 'Estado:') !!}
    {!! Form::select('cls_estado',['0'=>'Activo','1'=>'InActivo'],null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('clasesOnlines.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>

<!-- Modal -->
<div class="modal fade" id="mdl_cursos" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Cursos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="input-group">
                <label class="input-group-addon">Jornada</label>
                    <select name="jor_id" id="jor_id" class='form-control'>
                        <option value="0">Seleccione</option>
                        <option value="MA">Matutina</option>
                        <option value="NO">Nocturna</option>
                        <option value="SP">Semi-Presencial</option>
                    </select>
                <label class="input-group-addon">Tipo</label>
                    <select name="tipo" id="tipo" class='form-control input-group-addon'>

                        
                    </select>
          </div>

        <table class='table'>
            <tr>
                <th></th>
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
                <th>E</th>
                <th>F</th>
                <th>G</th>
            </tr>
        @foreach($cur as $c)
            <tr>
                <td>{{$c->cur_descripcion}}</td>
                    <td><input type="checkbox" value="A" data='{{$c->cur_obs}}' class='chk_cur'  ></td>
                    <td><input type="checkbox" value="B" data='{{$c->cur_obs}}' class='chk_cur'  ></td>
                    <td><input type="checkbox" value="C" data='{{$c->cur_obs}}' class='chk_cur'  ></td>
                    <td><input type="checkbox" value="D" data='{{$c->cur_obs}}' class='chk_cur'  ></td>
                    <td><input type="checkbox" value="E" data='{{$c->cur_obs}}' class='chk_cur'  ></td>
                    <td><input type="checkbox" value="F" data='{{$c->cur_obs}}' class='chk_cur'  ></td>
                    <td><input type="checkbox" value="G" data='{{$c->cur_obs}}' class='chk_cur'  ></td>
            </tr>
        @endforeach
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left btn_agrega_cursos_seleccionados" >Agregar</button>
        <button type="button" class="btn btn-danger pull-right btn_salir">Salir</button>
      </div>
    </div>
  </div>
</div>