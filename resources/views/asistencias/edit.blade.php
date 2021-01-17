@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Asistencia {{$dat[0].'-'.$dat[1]}}
        </h1>
   </section>

   <script>
    $(document).on("click","#btn_save",function() {
      var url=window.location;
      var token=$("input[name=_token]").val();
      if($('#estado').val()>0){
        data=[$(this).attr('data'),
        $('#estado').val(),
        0
        ];

                          Swal.fire({
                            title: 'Esta Seguro de Continuar?',
                            text: "No podrá revertir esta acción",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, continuar!'
                          }).then((result) => {
                            if(result.value){
///************************************************************* 

                                  $.ajax({
                                    url: url+'/justifica_asistencia',
                                    headers:{'X-CSRF-TOKEN':token},
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {'data[]':data},
                                    beforeSend:function(){
                                    },
                                    success:function(dt){
                                      if(dt==0){
                                        Swal.fire({
                                          type: 'success',
                                          title: 'Proceso Correcto',
                                          text: 'Ok'
                                        })
                                        window.history.go(0);///Regresa el historial
                                      }else{
                                        Swal.fire({
                                          type: 'danger',
                                          title: 'Algún Proceso ha fallado',
                                          text: 'Error'
                                        })

                                      }
                                    }
                                  })

///*************************************************************

                            }
                          })


      } else{
                        Swal.fire({
                            type: 'info',
                          title: 'DEBE SELECCIONAR UNA OPCION',
                          text: 'Seleccione una opción'
                      })

      }     
    })
    $(document).on("click","#btn_aceptar",function() {
                     var url=window.location;
                     var token=$("input[name=_token]").val();
                     var data=[
                       $("#persona_justifica").val(),
                       $("#motivo_justifica").val(),
                       $("#ast_id").val()
                     ];

                    $.ajax({
                        url: url+'/justifica_asistencia',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {'data[]':data},
                        beforeSend:function(){
                          if($("#persona_justifica").val().length==0){
                            alert('Persona que justifica es obligatorio');
                            return false;
                          }
                          if($("#motivo_justifica").val().length==0){
                            alert('Motivo es obligatorio');
                            return false;

                          }
                        },
                        success:function(dt){
                          if(dt==0){
                            alert('Justificado Correctamente');
                          }else{
                            alert('Error Fvor Intente Nuevamente');
                          }
                        }
                    })
})     


$(function(){

// Swal.fire({
//   position: 'top-end',
//   type: 'warning',
//   title: 'Al registrar la Falta o Atraso no podrá ser modificado ',
//   showConfirmButton: false,
//   timer:5000
// })


})

   </script>

{{csrf_field()}}

<div class="modal" tabindex="-1" role="dialog" id="exampleModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center text-bold bg-primary">
          JUSTIFICACIÓN DE FALTAS
          <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </h4>
      </div>
      <div class="modal-body">
        <table class="table">
          <tr>
            <th>Responsable: </th>
            <td>
              <input type="text" id="usu_justifica" name="usu_justifica" class="form-control" readonly value="{{Auth::user()->usu_apellidos.' '.Auth::user()->name}}" >
              <input type="hidden" name="ast_id" id="ast_id" >
            </td>
          </tr>  
          <tr>
            <th>Persona que Justifica: </th>
            <td><input type="text" id="persona_justifica" name="persona_justifica" class="form-control" ></td>
          </tr>
          <tr>
            <th>Motivo: </th>
            <td>
              <textarea name="motivo_justifica" id="motivo_justifica" cols="30" rows="10" class="form-control"></textarea>
            </td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_aceptar" name="" class="btn btn-primary pull-left">Aceptar</button>
        <button type="button" name="" class="btn btn-danger pull-right" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>


   <div class="content">



       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
   <table class="table table-responsive">
     <thead>
       <tr>
        <th>No</th>
         <th>Estudiante</th>
         <th>Novedad</th>
         <th>Descripcion</th>
         <th>Justificado por:</th>
         <th>Motivo:</th>
         <th>Acciones</th>
       </tr>
     </thead>
     <tbody>
      <?php $c=1?>
      @foreach($asistencias as $a)
       <tr>
         <td>{{ $c++ }}</td>
         <td>{{ $a->est_apellidos." ".$a->est_nombres  }}</td>
         <td>
          @if($a->estado==0)
          {{'A'}}
          <i class="btn btn-info btn-xs fa fa-pencil " data-toggle="modal" data-target="#modad_modifica_asistencias" onclick="$('#btn_save').attr('data',{{$a->id}} )" ></i>
          @elseif($a->estado==1)
          {{'Falta'}}
          @elseif($a->estado==2)
          {{'Atraso'}}
          @elseif($a->estado==3)
          {{'Falta Justificada '}}
          @elseif($a->estado==4)
          {{'Atraso Justificado'}}
          @elseif($a->estado==5)
          {{'Uniforme'}}
          @endif
       </td>
       <td>{{ $a->observaciones  }}</td>
       <td>{{ $a->persona_justifica  }}</td>
       <td>{{ $a->motivo_justifica  }}</td>
       <td>
        @if($a->estado==1)
         <i class="btn btn-primary fa fa-pencil-square-o btn-xs btn_justifica" onclick="$('#ast_id').val($(this).attr('data'))"  data='{{$a->id}}' data-toggle="modal" data-target="#exampleModal" ></i>
        @endif
       </td>
       </tr>
       @endforeach
     </tbody>
   </table>
               </div>
           </div>
       </div>
   </div>
@endsection

<!-- Modal -->
<div class="modal fade" id="modad_modifica_asistencias" tabindex="-1" role="dialog" aria-labelledby="modal_asistencias" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <select name="estado" id="estado" class="form-control">
          <option value="">Elija Una Opción</option>
          <option value="1">Falta</option>
          <option value="2">Atraso</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_save" class="btn btn-primary pull-left">Guardar</button>
        <button type="button"  class="btn btn-danger" data-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>