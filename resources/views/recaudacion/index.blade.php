@extends('layouts.app')
@section('content')
<?php
if(isset($_POST['search'])){
$desde=$_POST['desde'];
$hasta=$_POST['hasta'];
$fac_no=$_POST['fac_no'];
}else{
$desde=date('Y-m-d');
$hasta=date('Y-m-d');
$fac_no=null;
}
?>
<script>
    $(document).on("click",".btn_facturar",function(){
        var matid=$(this).attr("mtid");
        var mes=$(this).attr("mes");
        var url=window.location;
        var token=$("#token").val();
        $.ajax({
                        url: url+'/datos_factura',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {'matid':matid,'mes':mes},
                        beforeSend:function(){

                        },
                        success:function(dt){
                            alert(dt[0][0]['est_cedula']);
                        }
                    })
    })

function pdf(fac_id,num_fact){
            var url=window.location;

     if(num_fact==undefined){
        var nfc=prompt("Ingrese No: Factura");
        if($.isNumeric(nfc)){
            var token=$('input[name=_token]').val();

            $.ajax({
                url: url+'/actualiza_num_factura',
                headers:{'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {nfc:nfc,fac_id:fac_id},
                beforeSend:function(){

                },
                success:function(dt){

                    if(dt>0){
                       window.open(url+"/ticket/"+dt,"_blank");
                   }else if(dt==0){
                    alert('Factura Ya registrada');
                }else{
                    alert('Error al Registrar el Num de Factura');
                }
            }
        })
        }else{
            alert('Ingrese No de Factura Correcto');
        }

     }else{

        window.open(url+"/ticket/"+fac_id,"_blank");
     }

}    
</script>
<style>
    #tbl_facturar tr th,#tbl_facturar tr td{
        border:solid 1px; 
    }
</style>
    <section class="content-header">
        <h1 class="bg-primary text-center">Facturar Pago Pensiones</h1>
     <form action="recaudacionPensiones.index" method="POST" >
            <input type="hidden" name="_token" value="{{ csrf_token()}}">
            <div class="form-group col-sm-2">
              {!! Form::label('desde','Desde:') !!}
              {!! Form::date('desde',$desde,['class'=>'form-control']) !!}    
            </div>                
            <div class="form-group col-sm-2">
              {!! Form::label('hasta', 'Hasta:') !!}
              {!! Form::date('hasta',$hasta,['class'=>'form-control']) !!}
            </div>
            <div class="form-group col-sm-4">
              {!! Form::label('fac_no', 'Num.Factura:') !!}
              {!! Form::text('fac_no',$fac_no,['class'=>'form-control','placeholder'=>'No Factura / Estudiante']) !!}
            </div>
            <div class="input-group col-sm-2">
              <button style="margin-top:25px" class="btn btn-warning" value="search" type="submit" name="search" >
                <i class="fa fa-search"></i>
              </button>
            </div>
            <div class="input-group col-sm-2">
<!--               <button style="margin-top:-55px;margin-left:50px " class="btn btn-primary" value="search_impr" type="submit" name="search_impr" >
                <i class="fa fa-print"></i>
              </button>
 -->            </div>
          </form>
          <a class="btn btn-primary pull-right" style="margin-top: -50px;margin-bottom: 5px" href="{!! route('recaudacionPensiones.create') !!}">Nueva</a>
          @if(Auth::user()->id==1)
          <form action="elimina_duplicados_facturas" method="POST">
            {{csrf_field()}}
            <button class="btn btn-success pull-right"><i class="fa fa-info-circle" ></i></button>
              <!-- <i class="btn btn-success fa fa-info-circle pull-right" ></i> -->
          </form>
          @endif
    </section>

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                 <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Num.Fac</th>
                                <th>Estudiante</th>
                                <th>Codigo</th>
                                <th>$Pagado </th>
                                <th>Fecha de Pago</th>
                                <th>Sec</th>
                                <th colspan="3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $c=1;?>
                            @foreach($lista as $l)
                            <tr>
                                <td>{{$c++}}</td>
                                <td>{{$l->num_fact}}</td>
                                <td>{{$l->est_apellidos.' '.$l->est_nombres}}</td>
                                <td>{{$l->codigo}}</td>
                                <td>{{$l->valor_pagado}}</td>
                                <td>{{$l->fecha_pago}}</td>
                                <td>{{$l->fac_no}}</td>
                                <td>
                                    <a href="javascript:pdf({{$l->fac_id}},{{$l->num_fact}})"  >
                                        <i class="fa fa-file-pdf-o text-danger btn btn-xs"></i>
                                    </a>
                                    <a href="{!! route('recaudacionPensiones.edit',[$l->fac_id]) !!}" ><i class="fa fa-pencil btn btn-primary btn-xs"></i></a>
                                    <i class="fa fa-close btn btn-danger btn-xs"></i>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>   
            </div>
        </div>
    </div>
@endsection

