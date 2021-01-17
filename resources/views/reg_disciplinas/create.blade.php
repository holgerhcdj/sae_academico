@extends('layouts.app')

@section('content')

<script>
  $(function () {
    // $('#tbl_disciplina').DataTable({
    //   'paging'      : false,
    //   'lengthChange': false,
    //   'searching'   : false,
    //   'ordering'    : true,
    //   'info'        : true,
    //   'autoWidth'   : false
    // })
  })

        $(document).on('change', '.tx_comprtamiento', function () {
            obj=$(this);
            url=window.location;
            token=$("input[name=_token]").val();
            matid=$(obj).attr('mat_id');
            dscid=$(obj).attr('dsc_id');
            if(dscid==undefined){
                dscid=0;
            }
            mtrid=3;
            dsc_parcial=$('#parcial').val();
            dsc_tipo=0;
            dsc_nota=$(obj).val();

            $.ajax({
                url: url+'/registra_comportamiento',
                headers:{'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {matid:matid,
                       mtrid:mtrid,
                       dsc_parcial:dsc_parcial,
                       dsc_tipo:dsc_tipo,
                       dsc_nota:dsc_nota,
                       dsc_id:dscid,

                   },
                beforeSend:function(){

                    if($(obj).val()==0){
                        Swal.fire({
                          type: 'error',
                          title: 'Debe seleccionar una opción',
                          text: 'Error'
                      });

                        return false;
                    }

                },
                success:function(dt){

                    $(obj).attr('dsc_id',dt);

                },
                error : function(jqXHR, textStatus, errorThrown) {


                     if (jqXHR.status === 0) {
                      mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                      $(obj).val(0);
                    } else if (jqXHR.status == 404) {
                      mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                      $(obj).val(0);
                    } else if (jqXHR.status == 500) {
                      mensaje("error","Error en Conexión de red","No se pudo conectar a la red "+jqXHR.status);
                      $(obj).val(0);
                    } else if (textStatus === 'parsererror') {
                      mensaje("error","Error en Conexión de red","Requested JSON parse failed.");
                      $(obj).val(0);
                    } else if (textStatus === 'timeout') {
                      mensaje("error","Error en Conexión de red","Time out error.");
                      $(obj).val(0);
                    } else if (textStatus === 'abort') {
                      mensaje("error","Error en Conexión de red","Ajax request aborted.");
                      $(obj).val(0);
                    } else {
                      mensaje("error","Error en Conexión de red",'Uncaught Error: ' + jqXHR.responseText);
                      $(obj).val(0);
                    }


            }                   



            })  

              // this.value = $(this).val().toUpperCase();
              // this.value = this.value.replace(/[^a-eA-E]/g,''); 
        })

        function mensaje(ico,tit,txt){
          Swal.fire(tit,txt,ico)
        }


</script>

    <section class="content-header">
        <h1>Nuevo registro de Disciplina Parcial {{$p}}</h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">

            <form action="disc_busca_estudiante" method="POST">
                {{csrf_field()}}
                <div class="col-sm-3">
                    {!! Form::select('jor_id',$jor,null,['class'=>'form-control']) !!}    
                    <input type="hidden" name="parcial" id="parcial" value="{{$p}}" >
                </div>
                <div class="col-sm-3">
                    {!! Form::select('esp_id',$esp,null,['class'=>'form-control']) !!}    
                </div>
                <div class="col-sm-2">
                    {!! Form::select('cur_id',$cur,null,['class'=>'form-control']) !!}    
                </div>
                <div class="input-group col-sm-2">
                    {!! Form::select('paralelo',['A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E','F'=>'F','G'=>'G',],null,['class'=>'form-control','style'=>'margin-left:15px','id'=>'paralelo']) !!}    
                    <span class="input-group-addon">
                        <button class="btn btn-primary" name='btn_buscar' value="btn_buscar" style="margin-top:-8px; ">Buscar</button>
                    </span>
                </div>    
            </form>      
            </div>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tbl_disciplina" class="table">
                <thead>
                <tr>
                  <th>#</th>
                  <th>ESTUDIANTE</th>
                  <th>DISCIPLINA</th>
                </tr>
                </thead>
                <tbody>
                    {!!$result!!}
                </tbody>
              </table>
            </div>
          </div>
    </section>


        </div>
    </div>
@endsection
