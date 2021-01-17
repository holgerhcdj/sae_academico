@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Reg Notas
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
<?php
if(isset($adminNotas)){
    $fini=$adminNotas->adm_finicio;
    $ffin=$adminNotas->adm_ffinal;
    $hini=$adminNotas->adm_finicio;
    $hfin=$adminNotas->adm_ffinal;
}else{
    $fini=date('Y-m-d');
    $ffin=date('Y-m-d');
    $hini=date('H:i');
    $hfin=date('H:i');
}
?>
<script>
    $(function (){
        $(document).on("change","#adm_tipo",function(){
            if(this.value=='0'){
                //alert('ok');
            }
        })
    })
    function jornadas(){

                     var url=window.location;
                     var token=$("#token").val();
                     var cli=$("#FCA_RUC_CLI").val();
                    $.ajax({
                        url: url+'/busca_cliente',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {'cli':cli},
                        beforeSend:function(){
                        },
                        success:function(dt){
                            if(dt.length==0){
                                alert("Cliente no existe");
                            }else{
                                $("#tbody_clientes").html(dt);
                            }
                        }
                    })

    }
</script>
                    
                    {!! Form::open(['route' => 'regNotas.store']) !!}

                        @include('reg_notas.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
