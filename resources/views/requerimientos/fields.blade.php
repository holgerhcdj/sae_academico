<?php
$fecha = date('Y-m-d');
$vl_p=0;
$per_ids="";
if(isset($requerimientos)){
    $per=explode(';',$requerimientos->personas_ids);
    //$per_ids=explode(';',$requerimientos->cc_personas_ids);
    foreach ($per as $p) {
        if($usu_id==$p){
            $vl_p=1;
        }
    }

}


?>
<script>
    id = '<?php echo $id ?>';
    $(document).ready(function () {
        if (id == 0) {
            $('#mvr_fecha').val('<?php echo $fecha ?>');
        }

    });
    
    function traer_dato(obj,x) {

        var url = window.location;
        var usu = $('#personas').val();
        var ids = $('#personas_ids').val();
        $.ajax({
            url: url + "/match/" + $(obj).val()+"/"+x,
            type: 'GET',
            dataType: 'json',
            success: function (r) {
                $("#tbl_usuarios").html(r);
                $(".table-responsive").show();
            }
        });


    }

    function carga_personal(){

      pr_nms=$('#personas').val();
      pr_ids=$('#personas_ids').val();

      cc_nms=$('#cc_personas').val();
      cc_ids=$('#cc_personas_ids').val();


        $(".personal").each(function() {
                pr_chk=$("#to_"+$(this).val()).is(":checked");            
                cc_chk=$("#cc_"+$(this).val()).is(":checked");

                data=$("#usr_"+$(this).val()).html();

                if(pr_chk==true){
                    pr_nms=pr_nms+data+";";
                    pr_ids=pr_ids+$(this).val()+";";
                }
                if(cc_chk==true){
                    cc_nms=cc_nms+data+";";
                    cc_ids=cc_ids+$(this).val()+";";
                }

            // if($(this).is(":checked")){
            //     data=$(this).attr('id').split("_");
            //     pr_ids=pr_ids+data[1]+";";
            //     pr_nms=pr_nms+$("#usr_"+data[1]).html()+";";
            // }
        });


        $('#personas').val(pr_nms);
        $('#personas_ids').val(pr_ids);   

        $('#cc_personas').val(cc_nms);
        $('#cc_personas_ids').val(cc_ids);        

        $(".table-responsive").hide();

    }


    function validar_check(x,id){
            to_ck=$('#to_'+id).is(':checked');
            cc_ck=$('#cc_'+id).is(':checked');
        if(x==0){
            if(to_ck==true  && cc_ck==true){
                cc_ck=$('#cc_'+id).prop('checked',false);
            }
        }else{
            if(to_ck==true  && cc_ck==true){
                cc_ck=$('#to_'+id).prop('checked',false);
            }

        }

    }


    function cerrar_ventana(){
        $(".table-responsive").hide();
    }

    function limpiar() {
        $('#personas').val('');
        $('#personas_ids').val('');
    }
    function limpiar_cc() {
        $('#cc_personas').val('');
        $('#cc_personas_ids').val('');
    }

    $(document).on("click","#btn_reply",function(){
        var d=$(this).attr('data').split('&');
        $("#personas_ids").val(d[0]+";");
        $("#personas").val(d[1]+";");
        
    })

</script>
<style>
    #tbl_usuarios th{
        background:#055E8C;
        text-align:center; 
        color:#fff; 
    }

    #tbl_usuarios i{
        float:right; 
    }
    #tbl_usuarios tr td{
        padding-left:10px; 
    }
    #tbl_usuarios tr:hover{
        background:#E2E2E2;
        cursor:pointer;  
    }
    input[type=checkbox]{
        cursor:pointer;
    }
    .table-responsive{
        margin-left:25%; 
        position:fixed; 
        border:solid 1px #ccc; 
        background:#FEFEFE;
        z-index:999;
        border-radius:10px; 
        box-shadow:3px 3px 5px #000;
        overflow-y:scroll;
        width:30%;
        height:50%;   
        }    
</style> 
<div hidden class="table-responsive">
    <table id="tbl_usuarios" class="table">
    </table>
</div>

<div class="row" hidden>
    <!-- Usu_id Field -->
    <div class="form-group col-sm-6">
        {!! Form::text('usu_id', "$usu_id", ['class' => 'form-control','readonly'=>'true']) !!}
        {!! Form::text('req_id', "$id", ['class' => 'form-control','readonly'=>'true']) !!}
    </div>
</div>

<div class="row">
    <!-- Codigo Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('codigo', 'No.Requerimiento:') !!}
        {!! Form::text('codigo', "$codigo", ['class' => 'form-control','readonly'=>'true']) !!}
    </div>
    <!-- Fecha Registro Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('fecha_registro', 'Fecha Registro:') !!}
        {!! Form::date('mvr_fecha', null, ['class' => 'form-control','id'=>'mvr_fecha','readonly'=>'true']) !!}
    </div>
</div>


<div class="row">
    <div class="form-group col-sm-1">
        <label for="cc_personas">Para:</label>
    </div>
    <div class="form-group col-sm-3">
        {!! Form::select('para',array(''=>array('0'=>'Seleccione'),'Departamentos'=>$usuariosactivos->toarray()),null,['class'=>'form-control','id'=>'para', 'onchange'=>'traer_dato(this,0)' ]) !!}    
    </div>
    <div class="form-group col-sm-7">
        <?php
        if(isset($requerimientos)){
            if($usu_id!=$requerimientos->usur){
                $requerimientos->personas='';
                $requerimientos->cc_personas='';
            }
        }
        ?>
        {!! Form::text('personas', null, ['class' => 'form-control','id'=>'personas','readonly'=>'true','placeholder'=>'Personas']) !!}

    </div>
    <div class="form-group col-sm-1">
        <a class="btn btn-danger" onclick="limpiar()">Limpiar</a>
    </div>
    <div class="form-group col-sm-12" hidden >
        {!! Form::text('personas_ids',$per_ids, ['class' => 'form-control','id'=>'personas_ids','placeholder'=>'Personas_id']) !!}
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-1">
        <label for="cc_personas">Cc:</label>
    </div>
    <div class="form-group col-sm-3">
        {!! Form::select('para',array(''=>array('0'=>'Seleccione'),'Departamentos'=>$usuariosactivos->toarray()),null,['class'=>'form-control','id'=>'para', 'onchange'=>'traer_dato(this,1)' ]) !!}    
    </div>
    <div class="form-group col-sm-7">
        <?php
        if(isset($requerimientos)){
            if($usu_id!=$requerimientos->usur){
                $requerimientos->personas='';
            }
        }
        ?>
        {!! Form::text('cc_personas', null, ['class' => 'form-control','id'=>'cc_personas','readonly'=>'true','placeholder'=>'CC_Personas']) !!}

    </div>
    <div class="form-group col-sm-1">
        <a class="btn btn-danger" onclick="limpiar_cc()">Limpiar</a>
    </div>
    <div class="form-group col-sm-12" hidden >
        {!! Form::text('cc_personas_ids', null, ['class' => 'form-control','id'=>'cc_personas_ids','placeholder'=>'cc_Personas_id']) !!}
    </div>
</div>



<div class="row" hidden >
    <!-- Fecha Finalizacion Field -->
    <div class="form-group col-sm-6" hidden >
        {!! Form::label('fecha_finalizacion', 'Fecha Finalizacion:') !!}
        {!! Form::date('fecha_finalizacion', null, ['class' => 'form-control']) !!}
    </div>
    <!-- Asunto Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('asunto', 'Asunto:') !!}
        {!! Form::text('asunto', null, ['class' => 'form-control']) !!}
    </div>
</div>


<div class="row" >
    <div class="form-group col-sm-1">
        <label for="cc_personas">Tramite:</label>
    </div>  
    <div class="form-group col-sm-11">
        {!! Form::select('trm_id',$tramite,null,['class'=>'form-control','id'=>'trm_id' ]) !!}        
    </div>
    
</div>


<div class="row">
    <!-- Descripcion Field -->
    <div class="form-group col-sm-12">
        {!! Form::label('descripcion', 'Descripcion:') !!}
        {!! Form::textarea('mvr_descripcion', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <!-- Archivo Field -->
    <div class="form-group col-sm-3">
        {!! Form::label('archivo', 'Archivo:') !!}
        @if(empty($id))
        {!! Form::file('archivo', null, ['class' => 'form-control','accept'=>'application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*','id'=>'archivo']) !!}
        @else
            @if(!empty($requerimientos->archivo))
                {!! Form::text('archivo', null, ['class' => 'form-control','readonly'=>'true']) !!}
                <a href="{{url('/requerimiento/descargar',['id'=>$requerimientos->archivo])}}" class="btn btn-success">Descargar</a>
            @else
                {!! Form::file('archivo', null, ['class' => 'form-control','accept'=>'application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*','id'=>'archivo']) !!}            
            @endif
        @endif
    </div>
    <!-- Estado Field -->
    <div class="form-group col-sm-6" hidden>
        {!! Form::label('estado', 'Estado:') !!}
        {!! Form::select('estado', ['0'=>'Activo',
        '1'=>'Finalizado',
        '2'=>'Anulado'
        ],null, ['class' => 'form-control']) !!}
    </div>

</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    @if(empty($id))
            {!! Form::submit('Enviar', ['class' => 'btn btn-primary']) !!}
    @else
    @if($requerimientos->estado==0)
        @if($vl_p==1)
        {!! Form::submit('Reenviar', ['class' => 'btn btn-primary']) !!}
        @endif
    @if($usu_id==$requerimientos->usur)
            <a href="{{ route('requerimiento/finalizar',['id'=>$id,'usu_id'=>$usu_id]) }}" class="btn btn-success">Finalizar</a>
            <a href="{{ route('requerimiento/anular',['id'=>$id,'usu_id'=>$usu_id]) }}" class="btn btn-warning">Anular</a>
    @endif
    @endif
    @endif
    <a href="{{ route('requerimientoMovimiento',['id'=>$usu_id,'op'=>0]) }}" class="btn btn-danger">Cancelar</a>
</div>

