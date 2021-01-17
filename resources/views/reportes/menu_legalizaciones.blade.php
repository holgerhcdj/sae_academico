@extends('layouts.app')
@section('content')
<script>
  /*  
    $(document).on("click",".btn_imprimible",function() {
               var url=window.location;
               var token=$("input[name=_token]").val();
               let jor=$("select[name=jor_id]").val();
               let esp=$("select[name=esp_id]").val();
               let cur=$("select[name=cur_id]").val();
               let par=$("select[name=par_id]").val();
               $.ajax({
                url: url+'/nomina_matriculados',
                headers:{'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {jor:jor,esp:esp,cur:cur,par:par},
                beforeSend:function(){
                },
                success:function(dt){
                    alert(dt);
                    // if(dt.length==0){
                    //     alert("Cliente no existe");
                    // }else{
                    //     $("#tbody_clientes").html(dt);
                    // }

                }
            })
    });
    //function 
 */   

 $(document).on("click",".btn_modal_matriculados",function() {

    $("#mdl_matriculados").modal("show");
    $("input[name=op_print]").val($(this).attr('data'));

 })


</script>
<section class="content-header">
    <section class="content-header">
        <h1>
           Obtener Cuadros de Legalización 
        </h1>
    </section>
</section>
<div class="content">
    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="box box-primary">
        <div class="box-body">
            <div class="btn btn-primary btn_modal_matriculados" data='0' ><i class="fa fa-table"></i> Certificados de Matrículas</div>
<!--             <div class="btn btn-primary btn_modal_matriculados" data='1' ><i class="fa fa-table"></i> Promociones generales</div> -->
        </div>
    </div>
</div>
<!-- /////////////********MODAL MATRICULADOS************////////// -->
<div class="modal fade" id="mdl_matriculados" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="height:70% !important;background:white " role="document">
    <div class="modal-content" style="height:70% !important;" >
      <div class="modal-header" >
        Nómina de Matriculados
      </div>
      <div class="modal-body">
        <form action="{{route('lista_reporte_legalizaciones')}}" method="POST" target="_blank">
            {{csrf_field()}}
            <input type="hidden" name="op_print" >
            
            <div class="form-group ">
                {!! Form::label('jor_id', 'Jornada:') !!}
                {!! Form::select('jor_id',$jor,null,['class'=>'form-control','id'=>'jor_id']) !!}    
            </div>

            <div class="form-group ">
                {!! Form::label('esp_id', 'Especialidad:') !!}
                {!! Form::select('esp_id',$esp,null,['class'=>'form-control','id'=>'esp_id']) !!}    
            </div> 

            <div class="form-group ">
                {!! Form::label('cur_id', 'Curso:') !!}
                {!! Form::select('cur_id',$cur,null,['class'=>'form-control','id'=>'cur_id']) !!}
            </div>

            <div class="form-group ">
                {!! Form::label('par_id', 'Paralelo:') !!}
                {!! Form::select('par_id',[
                'A'=>'A',
                'B'=>'B',
                'C'=>'C',
                'D'=>'D',
                'E'=>'E',
                'F'=>'F',
                'G'=>'G',
                'H'=>'H',
                ],null,['class'=>'form-control','id'=>'par_id']) !!}
            </div>
            <div class="form-group ">
                {!! Form::label('tp_report', 'Tipo de Reporte:') !!}
                {!! Form::select('tp_report',['0'=>'Nómina de Matriculados','1'=>'Certificado individual de matrículas',
                ],null,['class'=>'form-control','id'=>'tp_report']) !!}
            </div>

<br>
            <div class="form-group ">
                <button name="print" value="imprimible" class="btn btn-primary pull-left btn_imprimible">Reporte Imprimible <i class="fa fa-file-text"></i> </button>
                <button name="excel" value="excel" class="btn btn-success pull-right">Reporte Exportable <i class="fa fa-file-excel-o"></i> </button>
            </div>
        </form>
    </div>


    </div>
  </div>
</div>

@endsection

