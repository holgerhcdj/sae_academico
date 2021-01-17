@extends('layouts.app')

@section('content')

<script type="text/javascript">
$(document).ready(function() {
  $(".sel-status").select2();
});

$(document).on("click",".btn_facturar",function(){

        var url=window.location;
        var token=$('input[name=_token]').val();
        var est=$("#cmb_est").val();
        var obj=$(this).parent().parent();
        var cod=$(obj).find(".codigo").html();


                    $.ajax({
                        url: url+'/factura_pension',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data:{est:est,cod:cod},
                        beforeSend:function(){

                        },
                        success:function(dt){

                         if(dt==0){
                             alert('Factura ya Registrada ');
                         }else{

                            if(confirm("Factura Realizada Correctamente \n Desea Imprimir?")){
                               window.open('http://localhost/academico/public/recaudacionPensiones/'+dt,'_blank');
                            }

                        }

                        }
                    })


});    

$(document).on("click","#btn_search",function(){
        var url=window.location;
        var token=$('input[name=_token]').val();
        var est=$("#cmb_est").val();
                    $.ajax({
                        url: url+'/busca_est_pension',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data:{est:est},
                        beforeSend:function(){
                        },
                        success:function(dt){
                            var x=0;
                            var codigos="";
                             $(dt).each(function(){
                                 codigos+="<tr><td class='codigo'>"+dt[x]['codigo']+"</td><td>"+dt[x]['fecha_pago']+"</td><td>"+dt[x]['vpagado']+
                                 "</td><td class='text-center' ><i class='btn fa fa-file-pdf-o text-danger btn_facturar' ></i></td></tr>";
                                 x++;
                             });
                             $("#tbody").html(codigos);
                        }
                    })

})
</script>
<style>
    td{
        padding:5px;
        border:solid 1px #eee;  
    }
</style>
    <section class="content-header">
        <h1>
            Facturar
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row container-fluid">
                    {!! Form::open(['route' => 'recaudacionPensiones.store']) !!}
                    <table border="0">
                        <tr>
                            <td>{!! Form::label('est_ruc', 'Ruc:') !!}</td>
                            <td colspan="2">
                                <select class="form-control sel-status" id="cmb_est">
                                    <option value="0">Seleccione</option>
                                    @foreach($est as $e)
                                    <option value="{{$e->mat_id}}">{{$e->est_apellidos.' '.$e->est_nombres.' /'.$e->jor_descripcion.' /'.$e->cur_descripcion.' /'.$e->mat_paralelo}}</option>
                                    @endforeach
                                </select>    
                            </td>
                            <td>
                                <i id='btn_search' class="btn btn-primary fa fa-search"></i>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-center">Codigo</th>
                            <th class="text-center">Fecha Pago</th>
                            <th class="text-center">Valor Pagado</th>
                            <th class="text-center">...</th>
                        </tr>
                        <tbody id="tbody">
                            
                        </tbody>
                    </table>

<!--                         <div class="form-group col-sm-6"  >
                            {!! Form::label('cli_nombre', 'Nombre:') !!}
                            {!! Form::text('cli_nombre', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-sm-6"  >
                            {!! Form::label('cli_direccion', 'Direccion:') !!}
                            {!! Form::text('cli_direccion', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-sm-6"  >
                            {!! Form::label('cli_telefono', 'Telefono:') !!}
                            {!! Form::text('cli_telefono', null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-sm-6"  >
                            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                        </div> -->


                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection