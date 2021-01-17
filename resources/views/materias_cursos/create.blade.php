@extends('layouts.app')

@section('content')

<script type="text/javascript">
    var url = window.location;
         $(document).on('click', '.btn_mtredit', function () {
            var obj=$(this).parent();
            var id=$(obj).find(".mtr_id").val();
            var desc=$(obj).find(".mtr_desc").val();
            var horas=$(obj).find(".mtr_horas").val();
            var bloq=$(obj).find(".mtr_bloq").val();
            var estado=$(obj).find(".mtr_estado").val();
            var asg_id=$(obj).find(".asg_id").val();
            $("#mtrid").val(id);
            $("#mtrdesc").val(desc);
            $("#mtrhoras").val(horas);
            $("#mtrbloq").val(bloq);
            $("#mtrestado").val(estado);
            $("#asgid").val(asg_id);
            $("#cont_mtr").show();

         })    
         $(document).on("click","#btn_mtrsave",function(){
            var data=$("#mtrid").val()+"&"+$("#mtrdesc").val()+"&"+$("#mtrhoras").val()+"&"+$("#mtrbloq").val()+"&"+$("#asgid").val()+"&"+$("#mtrestado").val();
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

<section class="content-header">
    <h1 style="text-align:center; background:tan; border-radius:2px;margin-top:-10px;" >
          Materias Técnicas de {{$esp->esp_descripcion}}
    </h1>
</section>
<div class="content">
    @include('adminlte-templates::common.errors')
    <div class="box box-primary">

        <div class="box-body">
            <div class="row">
                {!! Form::open(['route' => 'materiasCursos.store','id'=>'frm_mtr_cursos']) !!}

                @include('materias_cursos.fields')


                <div id="cont_mtr" class="text-center" style="display:none;">
                    <table class="table">
                        <tr>
                            <th>Materia</th>
                            <th>Horas/Semana</th>
                            <th>Bloques</th>
                            <th>Estado</th>
                        </tr>
                        <tr>
                            <td>
                                <input type="hidden" id="mtrid" class="form-control">
                                <input type="hidden" id="asgid" class="form-control">
                                <input type="text" id="mtrdesc" class="form-control">
                            </td>
                            <td>
                                <input type="text" id="mtrhoras" class="form-control">
                            </td>
                            <td>
                                <input type="text" id="mtrbloq" class="form-control">
                            </td>
                            <td>
                                <select name="mtrestado" id="mtrestado" class="form-control">
                                    <option value="0">En Curso</option>
                                    <option value="1">Finalizado</option>
                                </select>
                            </td>
                            <td>
                                <div class="form-group col-sm-1 text-left"   >
                                    <span class="btn bg-info " title="Modificar Nombre de la Materia"><i id="btn_mtrsave" class="glyphicon glyphicon-floppy-disk text-primary"></i></span>
                                </div>
                            </td>
                        </tr>
                    </table>   
                </div>

                {!! Form::close() !!}
            </div>
            <div class="box-body">
                @include('materias_cursos.table')
            </div>

            <form action="materiasCursos.asignar" id="frm_refresh" method="POST">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" value="1" id="jor_id" name="jor_id" />
                <input type="hidden" value="1" id="tipo" name="tipo" />
                <input type="hidden" value="{{$datos['cur_id']}}" id="cur_id" name="cur_id" />
                <input type="hidden" value="{{$esp->id}}" id="esp_id" name="esp_id" />
            </form>

        </div>
    </div>
</div>
@endsection
