@extends('layouts.app')

@section('content')

<script>
    $(document).on("click",".btn_credenciales",function(){
        $("#mdl_credenciales").modal("show");
    })
</script>
    <section class="content-header">
        <div class='bg-light-blue text-center col-md-10' style='font-size:18px '>
            Administracion de Credenciales
        </div>
    </section>
    <div class="content" style="margin-top:20px; ">
        <div class="row ">
                    @foreach($gerencias as $g)
                    <div class="col-md-4" >
                      <!-- small box -->
                      <div class="small-box bg-aqua p-3">
                        <div class="inner">
                          <h4>{{$g->ger_descripcion}}</h4>
                      </div>
                      <div class="icon">
                          <i class="glyphicon glyphicon-envelope"></i>
                      </div>
                      <a href="javascript:void(0)" class="small-box-footer btn_credenciales"   >Credenciales <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
              </div>
              @endforeach
          </div>
    </div>

@endsection


<!-- Modal -->
<div class="modal fade" id="mdl_credenciales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

                <div class="container-fluid">

                    <form action="{{route('facturacionElectronica.create_update_credenciales')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row ">
                            <div class="col-md-12">
                                <strong class="form-text text-muted">Servidor de Pruebas Recepción</strong>    
                                <input type="text" class="form-control" id="srv_pruebas_rec" name="srv_pruebas_rec">
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-12">
                                <strong class="form-text text-muted">Servidor de Pruebas Autorización</strong>    
                                <input type="text" class="form-control" id="srv_pruebas_auto" name="srv_pruebas_auto">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <strong class="form-text text-muted">Servidor de Producción Recepción</strong>    
                                <input type="text" class="form-control" id="srv_produccion_rec" name="srv_produccion_rec">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <strong class="form-text text-muted">Servidor de Producción Autorización</strong>    
                                <input type="text" class="form-control" id="srv_produccion_auto" name="srv_produccion_auto">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <strong class="form-text text-muted">Firma electrónica</strong>    
                                <input type="file" class="form-control" id="firma_electrocnica" name="firma_electrocnica">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <strong class="form-text text-muted">Clave de la Firma</strong>    
                                <input type="password" class="form-control" id="clave_firma_electrocnica" name="clave_firma_electrocnica">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <strong class="form-text text-muted">Ambiente:</strong>    
                                <br>
                                Pruebas:<input type="radio"  name="ambiente[]">
                                Producción:<input type="radio"  name="ambiente[]">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <strong class="form-text text-muted">Correo de envíos:</strong>    
                                <br>
                                <input type="email" class="form-control" id="correo_envio" name="correo_envio">
                            </div>
                        </div>
                        <div class="row">
                            <input type="submit" class="btn btn-primary" value="Guardar">
                        </div>
                    </form>


                </div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>