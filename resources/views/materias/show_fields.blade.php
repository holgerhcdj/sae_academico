@section('scripts')
<script>
    var url = window.location;

		 $(document).on('click', '#add', function () {
		 	var cur=$('#cur_id').val();
		 	var mtr=$('#mtr_id').val();
		 	var mtrd=$('#mtr_descripcion').val();
		 	var hrs=$('#horas').val();
		 	var obs=$('#obs').val();
            var dt=cur+"&"+mtr+"&"+mtrd+"&"+hrs+"&"+obs;
                $.ajax({
                    url: url + "/mcult/"+dt,
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                    	if(mtr==0 && mtrd.length==0){
                    		alert('Nueva Materia es Obligatorio');
                    		$('#mtr_descripcion').focus();
                    		return false;
                    	}else if(hrs==0 || hrs.length==0){
                    		alert('Horas es Obligatorio');
                    		$('#horas').focus();
                    		return false;
                    	}else{
                    	return true;	
                    	}
                    	return false;

                    },
                    success: function (dt) {
                    	dat=dt.split("&");
                        $("#tbl_materias tbody").html(dat[0]);
                        $("#mtr_id").html(dat[1]);

                    }
                });
		 })

         $(document).on('click', '.btn_mtredit', function () {
            var obj=$(this).parent();
            var id=$(obj).find(".mtr_id").val();
            var desc=$(obj).find(".mtr_desc").val();
            $("#mtrid").val(id);
            $("#mtrdesc").val(desc);
            $("#cont_mtr").show();
         })

         $(document).on("click","#btn_mtrsave",function(){
            var data=$("#mtrid").val()+"&"+$("#mtrdesc").val();
            $.ajax({
                url:url+"/mtrupdate/"+data,
                type:'GET',
                dataType:'json',
                beforeSend:function(){
                    if($("#mtrdesc").val().length==0){
                        alert("Campo Descripcion es Requerido");
                        return false;
                    }else if(confirm("Se actualizará la Descripcion en todos los cursos asignados")){
                        return true;
                    }else{
                        return false;
                    }
                    
                },
                success:function(dt){
                    if(dt==0){
                        alert("Materia Actualizada Correctamente");
                        $("#frm_refresh").submit();
                    }else{
                        alert("Error");
                    }
                }
            })            
         })
     </script>
@endsection

<form action="materias.show" id="frm_refresh" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="cur_id" id="cur_id" value="{{$curso[0]->id}}" >
</form>



<div class="form-group col-sm-3">
	<input type="hidden" name="cur_id" id="cur_id" value="{{$curso[0]->id}}" >
    <select name="mtr_id" id="mtr_id" class="form-control" >
        <option value="0">Nueva Materia</option>
        @foreach($materias as $m)
        <option value="{{$m->id}}">{{$m->mtr_descripcion}}</option>
        @endforeach
    </select>
</div>
<div class="form-group col-sm-3">
    {!! Form::text('mtr_descripcion', null, ['id'=>'mtr_descripcion', 'class' => 'form-control','placeholder'=>'NUEVA MATERIA']) !!}
</div>

<!-- Horas Field -->
<div class="form-group col-sm-3">
    {!! Form::number('horas', null, ['id'=>'horas','class' => 'form-control','required'=>'required','placeholder'=>'Horas/Semana']) !!}
</div>

<!-- Obs Field -->
<div class="form-group col-sm-3" hidden="">
    {!! Form::text('obs', null, ['id'=>'obs','class' => 'form-control','placeholder'=>'Observaciones']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-3">
    {!! Form::submit('+', ['class' => 'btn btn-primary','id'=>'add']) !!}
</div>

<div id="cont_mtr" style="display:none; ">
    <div class="form-group col-sm-3 text-right" style="margin-top:10px; "   >
        <label for="mtrdesc">Materia</label>
    </div>
    <div class="form-group col-sm-3"   >
        <input type="hidden" id="mtrid" class="form-control">
        <input type="text" id="mtrdesc" class="form-control">
    </div>
    <div class="form-group col-sm-3 text-left"   >
        <button id="btn_mtrsave" title="Actualizar" class="btn"><i class="glyphicon glyphicon-floppy-disk text-primary"></i></button>    
    </div>
</div>

<div>
<table class="table table-striped table-hover" id="tbl_materias">
	<thead>
		<tr>
			<th scope="col" >No</th>
			<th>Materia</th>
			<th>Horas/Sem</th>
			<th colspan="2"></th>
		</tr>
	</thead>
	<tbody>
		<?php $x=1;?>
		@foreach($mtr_asg as $m)
		<tr>
			<td>{{$x++}}</td>
			<td>
                {{$m->mtr_descripcion}}
            </td>
			<td>{{$m->horas}}</td>
            <td class="text-right">
                <input type="hidden" class="mtr_id" value="{{$m->mtr_id}}">
                <input type="hidden" class="mtr_desc" value="{{$m->mtr_descripcion}}">
                <button class="btn_mtredit" title="Modificar Nombre de la Materia"><i class="glyphicon glyphicon-pencil text-primary"></i></button>
            </td>
			<td class="text-left">
                <form action="mat_curso.del" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="asm_id" id="asm_id" value="{{$m->ac_id}}" >
                    <input type="hidden" name="cur_id" id="cur_id" value="{{$m->cur_id}}" >
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit','title'=>'Eliminar Asignación','class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Esta Seguro de eliminar?')"]) !!}
                </form>		
			</td>
		</tr>

		@endforeach
	</tbody>
</table>
</div>