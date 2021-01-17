@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Comunicados enviados {{$cod}}
        </h1>
    </section>
    <style>
        .tbl_comunicados td{
            padding:2px 3px 2px 3px; 
            border-top:solid 1px #eee; 
            font-size:12px; 
            font-family:Arial; 
        }
        .tbl_comunicados tr:hover{
            background:#B9E4F0 ;
            cursor:pointer;
        }
        .bg-danger{
            background:brown; 
            color:white; 
        }
        .tbl_comunicados th{
            padding:2px 3px 2px 3px;
            text-align:center;  
        }
    </style>
    <script>

       $(document).ready(function(e) { 
           $(".btn_send").on("click",function(){
               var token=$("input[name=_token]").val();
               var url = "https://sms.innobix.com.ec/sapi/sms_sendingp.php"; 
               var us='fvidanueva';
               var pss='V1D4nU3V4@2019';
               var tp=$(this).attr('lang');
               var sms=$('#sms').text().trim();
               var sms_id=$(this).attr('id');  

if(tp==0){
               var num=$(this).attr('title').substring(1);

               $.post(url,{user:us,pss:pss,numero:num,mensaje:sms}, function(response) {
                alert(response);
                }, 'json').done(function() {
                    alert( "second success" );
                }).fail(function() {
                    actualiza_estado(sms_id,token);
                })
}else{
                var num=$(this).attr('title');
                envia_correo(num,sms,sms_id);
}

           })

       })

         function actualiza_estado(id,token){
                     var url=window.location;
                    $.ajax({
                        url: url+'/actualiza_estado',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {'sms_id':id},
                        beforeSend:function(){

                        },
                        success:function(dt){
                            if(dt==0){
                            $('.alert').append('Envío Correcto...');
                                //alert('Envío Correcto');
                            }else{
                                $('.alert').append('Error al enviar...');
                            }
                        }
                    })
        }

        function envia_correo(num,sms,sms_id){
            token=$('input[name=_token]').val(); 
            url=window.location;                        
            $.ajax({
                url: url+'/envia_mail',
                headers:{'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {'correo':num,'mensaje':sms},
                beforeSend:function(){
                                //return false;
                            },
                            success:function(dt){
                               if(dt==0){
                                   actualiza_estado(sms_id,token);
                               }
                           }
                       })    
        }


    </script>
    {{csrf_field()}}
    <div class="alert alert-warning"></div>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px;width:100%;overflow:auto; ">
                    <table class="tbl_comunicados" border="0">
                        <tr>
                            <th>No</th>
                            <th>Estudiante</th>
                            <th>Motivo</th>
                            <th>Tipo</th>
                            <th>Direccion/Telefono</th>
                            <th>Destinatario</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Mensaje</th>
                            <th>Respuesta</th>
                            <th>Acc</th>
                        </tr>
                        <?php $x=1?>
                        @foreach($smsMail as $s)
                        <tr>
                            <td>{{$x++}}</td>
                            <td>{{$s->est_apellidos.' '.$s->est_nombres}}</td>
                            <td>{{$s->sms_modulo}}</td>
                            @if($s->sms_tipo==0)
                                <td>{{'SMS'}}</td>
                            @else
                                <td>{{'E-mail'}}</td>
                            @endif
                            <td>{{$s->destinatario}}</td>
                            <td>{{$s->persona}}</td>
                            <td>{{$s->sms_fecha.' '.$s->sms_hora}}</td>
                                @if($s->estado==0)
                                <td class="bg-info">{{'Registrado'}}</td>    
                                @elseif($s->estado==1)
                                <td class="bg-success">{{'Enviado'}}</td>
                                @elseif($s->estado==2)
                                <td class="bg-danger" >{{'Error'}}</td>
                                @endif
                                @if($x==2)
                                <td rowspan="{{$count}}" style="vertical-align:top" id="sms">
                                    {!!html_entity_decode($s->sms_mensaje,ENT_COMPAT,'UTF-8')!!}
                                </td>  
                                @endif
                            <td>{{$s->respuesta}}</td>
                            <td>
                                @if($s->estado==0)
                                <i class="btn btn-warning fa fa-paper-plane btn_send" id="{{$s->sms_id}}" data="{!!html_entity_decode($s->sms_mensaje,ENT_COMPAT,'UTF-8')!!}"  lang="{{$s->sms_tipo}}" title="{{$s->destinatario}}" ></i>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
