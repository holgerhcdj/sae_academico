<?php
$ecb_id=0;
$ecb_des=null;
$ecb_obj=null;
if(isset($encuesta)){
  $ecb_id=$encuesta[0]->ecb_id;
  $ecb_des=$encuesta[0]->ecb_descripcion;
  $ecb_obj=$encuesta[0]->ecb_objetivo;
}


?>
<script>
$(document).on("click","#btn_guarda_grupo",function(){
            var token=$("input[name=_token]").val();
            var url=window.location;

            let ecb_descripcion=$("input[name=ecb_descripcion]").val();
            let ecb_objetivo=$("input[name=ecb_objetivo]").val();
            let gru_descripcion=$("input[name=gru_descripcion]").val();
            let gru_valoracion=$("input[name=gru_valoracion]").val();
            let pre_pregunta=$("input[name=pre_pregunta]").val();
            let ecb_id=$("input[name=ecb_id]").val();

         $.ajax({
            url:url+'/guarda_encabezado',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {op:0,
                ecb_desc:ecb_descripcion,
                ecb_obj:ecb_objetivo,
                gru_desc:gru_descripcion,
                gru_val:gru_valoracion,
                pre_preg:pre_pregunta,
                ecb_id:ecb_id
            },
            beforeSend:function(){
                //Swal.showLoading();
            },
            success:function(dt){
                let gru=dt[0];
                let preg=dt[1];
                let pre_id=dt[2];
                let rst=`<tr>
                        <td>--</td>
                        <td>-</td>
                        <td>${preg}</td>
                        <td>
                           <i pre_id='${pre_id}' class='btn btn-danger btn-xs fa fa-trash btn_elimina_pregunta'></i>
                        </td>
                      </tr>`;
              $("input[name=ecb_id]").val(dt[3]);
              $("#tbody_preguntas").append(rst);
              $("input[name=pre_pregunta]").val(null);
            }
        })     
})

$(document).on("click",".btn_elimina_pregunta",function(){

        var token=$("input[name=_token]").val();
        var url=window.location;
        let obj=$(this);
        let preid=$(obj).attr('pre_id');

         $.ajax({
            url:url+'/elimina_pregunta',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {op:0,preid:preid },
            beforeSend:function(){

                if( !confirm("Desea eliminar la pregunta") ){
                    return false;
                }
                //Swal.showLoading();
            },
            success:function(dt){
                
                if(dt==0){
                    var td=$(obj).parent();
                    var tr=$(td).parent();
                    $(tr).remove();
                }

            }
        })    


})

</script>
<style>
    body {
      font-family: "Ubuntu", "Trebuchet MS", sans-serif;
    }
    table {
      border-collapse: collapse;
    }
    th, td {
      padding: 5px 10px;
      border: 1px solid #999;
      font-size: 12px;
    }
    th {
      background-color: #eee;
    }
  

</style>

<div style="border:solid 1px #2588CD;padding:15px;font-size:16px ">
  <div class="bg-primary text-center" style="padding:5px;" >DATOS GENERALES DE LA ENCUESTA</div>
  <div class="card-body" >
    <p class="card-text">
        <div class="form-group ">
            {!! Form::label('ecb_descripcion', 'Descripcion:') !!}
            {!! Form::text('ecb_descripcion',$ecb_des, ['class' => 'form-control']) !!}
            {!! Form::hidden('ecb_id',$ecb_id, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group ">
            {!! Form::label('ecb_objetivo', 'Objetivo:') !!}
            {!! Form::text('ecb_objetivo', $ecb_obj, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group row" style="display:none;">
            <div class="col-md-4">
            {!! Form::text('gru_descripcion', 'General', ['class' => 'form-control','placeholder'=>'Agrupar por:']) !!}
            </div>
            <div class="col-md-4">
                {!! Form::text('gru_valoracion', 100, ['class' => 'form-control','placeholder'=>'Valor %']) !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12 text-center" style="background:#eee;">Preguntas de la Encuesta</div>

            <div class="col-md-10">
            {!! Form::text('pre_pregunta', null, ['class' => 'form-control','placeholder'=>'Describa la pregunta']) !!}
            </div>
            <div class="col-md-2">
                <i class="btn btn-success fa fa-plus" id="btn_guarda_grupo"></i>
            </div>
        </div>

    </p>
  </div>
</div>
<div class="cont_preguntas" >
    
  <table>
    <thead>
      <tr>
        <th>Grupo</th>
        <th>#</th>
        <th>Pregunta</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="tbody_preguntas">
<?php $x=1?>
@if(isset($encuesta))

      @foreach($encuesta as $enc)
      <tr>
        <td>{{$enc->gru_descripcion}}</td>
        <td>{{$x++}}</td>
        <td>{{$enc->pre_pregunta}}</td>
        <td>
          <i pre_id='{{$enc->pre_id}}' class='btn btn-danger btn-xs fa fa-trash btn_elimina_pregunta'></i>
        </td>
      </tr>
      @endforeach

@endif
    

    </tbody>
  </table>


</div>

