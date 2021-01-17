@extends('layouts.app')

@section('content')
<script>
    $(document).on("click",".btn_pago_pension",function(){
                    var url=window.location;
                    var token=$("#token").val();
                    var obj=$(this).parent().parent();
                    var valor=$(obj).find('.txt_vpagado').val();
                    var motivo=$(obj).find('.txt_motivo').val();
                    var mtid=$(this).attr('data');
                    //alert(mtid);
                    var opid=$(this).attr("lang");
                    var ms=$("#mes").val();
                    var jr=$("#jor_id").val();
                    $.ajax({
                        url: url+'/registra_pago',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {'vl':valor,'mtid':mtid,'ms':ms,'jr':jr,'mtv':motivo,'opid':opid},
                        beforeSend:function(){
                            // if(valor<=0 || motivo.length==0){
                            //     alert("Debe ingresar un valor y un motivo");
                            //     return  false;
                            // }else{
                                 if(!confirm("Esta seguro de Registrar Pago?")){
                                     return false;
                                 }
                            // }

                        },
                        success:function(dt){
                            $(obj).find('.cod').text(dt['codigo']);                            
                            $(obj).find('.vl').text(dt['valor']);                            
                            $(obj).find('.fpag').text(dt['fecha_pago']);                            
                            $(obj).find('.resp').text(dt['responsable']);                            
                            $(obj).find('.boton').html("<i class='fa fa-check'></i>");                            
                        }
                    })
        
    });
    $(document).on("click",".btn_del_pago",function(){
                    var url=window.location;
                    var token=$("#token").val();
                    var obj=$(this).parent().parent();
                    var opid=$(this).attr("data");
                    $.ajax({
                        url: url+'/elimina_pago',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {'opid':opid},
                        beforeSend:function(){
                                if(!confirm("Esta seguro de Eliminar Pago?")){
                                    return false;
                                }
                        },
                        success:function(dt){
                            if(dt==0){
                            $(obj).find('.cod').text('');                            
                            $(obj).find('.vl').text('');                            
                            $(obj).find('.fpag').text('');                            
                            $(obj).find('input').val('');                            
                            $(obj).find('.resp').text('');                            
                            $(obj).find('.boton').html("<i class='fa fa-check'></i>");                            
                            }else if(dt==1){
                                alert("Ud No tiene permisos para esta acción");
                            }else{
                                alert("No se pudo eliminar");
                            }
                    }
                    })
        
    });
</script>
<style>
    .btn-sx{
        padding:3px; 
    }
        .table tr:hover{
            background:#ccc; 
            cursor:pointer;
        }
</style>
    <section class="content-header">
        <input type="hidden" id="token" value="{{ csrf_token() }}" >
        <h1 class="bg-primary text-center">Registro Manual de Pago de Pensiones</h1>
     <form action="pagoManualPensiones.index" method="POST" >
            <input type="hidden" name="_token" value="{{ csrf_token()}}">
            <div class="form-group col-sm-2">
                {!! Form::label('jor_id','Jornada:') !!}
                {!! Form::select('jor_id',$jor,null,['class'=>'form-control','id'=>'jor_id']) !!}    
            </div>                
            <div class="form-group col-sm-2">
                {!! Form::label('esp_id', 'Especialidad:') !!}
                {!! Form::select('esp_id',$esp,null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group col-sm-2">
                {!! Form::label('cur_id', 'Curso:') !!}
                {!! Form::select('cur_id',$cur,null,['class'=>'form-control']) !!}
            </div>
            <div class="form-group col-sm-2">
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
                    'I'=>'I'],null,['class'=>'form-control']) !!}    
                </div>            <div class="form-group col-sm-2">
                {!! Form::label('mes', 'Matricula/Pension:') !!}
                {!! Form::select('mes',[
                    '1'=>'Matricula',
                    '2'=>'Septiembre',
                    '3'=>'Octubre',
                    '4'=>'Noviembre',
                    '5'=>'Diciembre',
                    '6'=>'Enero',
                    '7'=>'Febrero',
                    '8'=>'Marzo',
                    '9'=>'Abril',
                    '10'=>'Mayo',
                    '11'=>'Junio',
                    ],null,['class'=>'form-control','id'=>'mes']) !!}    
                </div>
                <div class="input-group col-sm-2">
                    <button style="margin-top:25px" class="btn btn-warning" value="search" type="submit" name="search" >
                        <i class="fa fa-search"></i>
                    </button>
                </div>
     </form>
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
                            <th>Estudiante</th>
                            <th>Especialidad</th>
                            <th>Codigo</th>
                            <th>$ Solicitado</th>
                            <th>F-pago</th>
                            <th>$ Pagado</th>
                            <th>Motivo</th>
                            <th></th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $c=1?>
                        @foreach($lista as $l)
                        <tr>
                            <td>{{ $c++ }}</td>
                            <td>{{$l->est_apellidos." ".$l->est_nombres }}</td>
                            <td>{{$l->esp_descripcion}}</td>                            
                            <td class="cod">{{$l->codigo}}</td>                            
                            <td class="vl" >{{$l->valor}}</td>                            
                            <td class="fpag" >{{$l->fecha_pago}}</td>                            
                            <td><input type="text" value="{{$l->vpagado}}" style="width:80px " class="form-control txt_vpagado"></td>                            
                            <td><input type="text" value="{{$l->motivo}}" style="width:200px " class="form-control txt_motivo"></td>                            
                            <td class="boton">
                            @if($l->estado==1 && $l->tipo==1)
                                <i class='fa fa-trash btn btn-danger btn-sx btn_del_pago' data="{{ $l->opid }}"></i>                                
                            @else
                                @if(empty($l->vpagado))
                                <i class="btn btn-success fa fa-floppy-o btn-sx btn_pago_pension" data="{{ $l->est_id }}" lang="{{ $l->opid }}" aria-hidden="true"></i>
                                @endif
                            @endif
                            </td>
                            <td>
                                @if($l->estado==1)
                                {{ 'Pagado' }}
                                @else
                                {{ 'Pendiente' }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

