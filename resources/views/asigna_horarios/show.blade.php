@extends('layouts.app')

@section('content')
    <section class="content-header">
        <table border="0" >
            <tr>
                <th class="text-center">
                    <b class="text-primary" style="font-size:25px ">{{' '.$usr->usu_apellidos.' '.$usr->name}}</b>
                </th>
                <th>Función:</th>
                <th>
                    <form action="asignaHorarios.show2" method="POST" class="pull-right" id="frm_horarios">
                        {{csrf_field()}}
                        <input type="hidden" value="{{$usr->id}}" name="usrid">
                        <select name="tipo" id="tipo" class="form-control">
                            <option value="0">Seleccione</option>
                            <option value="1">Coordinador</option>
                            <option value="2">Inspector</option>
                            <option value="3">DECE</option>
                            <option value="4">Secretaría</option>
                        </select>
                    </form>
                </th>                
            </tr>
        </table>
    </section>
    <script>
        $(document).on("click",".chk",function(){
                     var url=window.location;
                     var token=$("#token").val();
                     var obj=$(this);
                     var dt=$(obj).attr('data').split("&");
                     var u=$("#usuid").val();
                     var p=dt[0];
                     var c=dt[1];
                     var j=dt[2];
                     var tp=$("#tipo").val();
                     var op=0;
                     var did=0;
                     if($(obj).prop("checked")==false){
                        op=1;
                        did=$(obj).attr("lang");
                     }

                      $.ajax({
                        url: url+'/asigna_coordinador',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {u:u,p:p,c:c,j:j,op:op,did:did,tp:tp},
                        beforeSend:function(){

                        },
                        success:function(dt){
                            if(dt>0){
                                alert('Registro Correcto');
                                $(obj).attr('lang',dt);
                            }else{
                                alert('Error favor intente de nuevo');
                            }
                        }
                    })
            
        })

        $(document).on("change","#tipo",function(){

            if($(this).val()=='0'){
                    src="<?php asset('img/colegio.png') ?>";
                    Swal.fire({
                               title: 'Sweet!',
                            text: 'Elija una opción',
                            imageUrl: 'http://localhost/academico/public/img/logo_institucional_sae.png',
                            imageWidth: 100,
                            imageAlt: 'Custom image',
                            animation: false
                    })

  // title: 'Sweet!',
  // text: 'Modal with a custom image.',
  // imageUrl: 'https://unsplash.it/400/200',
  // imageWidth: 400,
  // imageHeight: 200,
  // imageAlt: 'Custom image',
  // animation: false

            }else{
                $("#frm_horarios").submit();
            }


        })

        $(function(){

            var dt=eval(<?php echo  $resp?>);
            var tp=eval(<?php echo  $tp?>);
            $("#tipo").val(tp);
            x=0;
            while(x<=(dt.length-1)){
                 dat=dt[x].split('//');
                 var obj=$("input[data='"+dat[1]+"']");
                 $(obj).prop("checked",true);
                 $(obj).attr("lang",dat[0]);
                x++;
            }
      })

    </script>

    <div class="content" style="border:solid 1px; ">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <input type="hidden" value="{{csrf_token()}}" id="token">
                    <input type="hidden" value="{{$usr->id}}" id="usuid">
                    @include('asigna_horarios.show_fields')
<!--                     <a href="{!! route('asignaHorarios.index') !!}" class="btn btn-default">Back</a> -->
                </div>
            </div>
        </div>
    </div>
@endsection
