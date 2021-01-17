<?php
if(isset($adminNotas)){
    $fini=$adminNotas->adm_finicio;
    $ffin=$adminNotas->adm_ffinal;
    $hini=$adminNotas->adm_hinicio;
    $hfin=$adminNotas->adm_hfinal;
    $jr=$adminNotas->jor_id;
    $ep=$adminNotas->esp_id;
    $cr=$adminNotas->cur_id;
    $mr=$adminNotas->mtr_id;
    $md=$adminNotas->mod_id;
    $is=$adminNotas->insumo;
}else{
    $fini=date('Y-m-d');
    $ffin=date('Y-m-d');
    $hini=date('H:i');
    $hfin=date('H:i');
    $jr=0;
    $ep=10;
    $cr=0;
    $mr=0;
    $md=0;
    $is=0;

}
?>

<script>
    $(function (){
        $("#jor_id").val('<?php echo $jr ?>');
        $("#cur_id").val('<?php echo $cr ?>');
        $("#mtr_id").val('<?php echo $mr ?>');
        $("#mod_id").val('<?php echo $md ?>');
        $("#insumo").val('<?php echo $is ?>');
        especialidades($("#adm_tipo").val());
    })

    $(document).on("change","#adm_tipo",function(){
        especialidades($(this).val());
    })

    function especialidades(){
        var url=window.location;
        var token=$("input[name='_token']").val();
        var tp=$("#adm_tipo").val();

        $.ajax({
            url: url+'/busca_especialidades',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {tp:tp},
            beforeSend:function(){
            },
            success:function(dt){
                $("#esp_id").html(dt);
                if(tp==1){
                    $("#cnt_modulos").hide();
                    $("#cnt_materia").show();

                }else{
                    $("#cnt_modulos").show();
                    $("#cnt_materia").hide();

                }               
                $("#esp_id").val('<?php echo $ep ?>');
                if($("#esp_id").val()==null){
                    $("#esp_id").val(0);
                }
                //alert($("#esp_id").val());

            }
        })
    }

    function validar(){
        if($("#adm_tipo").val()==1 && $("#adm_parcial").val()==0){
            alert("Parcial es obligatorio");
            return false;
        }
    }

    $(document).on("change","#adm_tipo",function(){
        // if(this.value==1){
        //     $("#cnt_parcial").show();
        //     $("#cnt_modulos").hide();
        //     $("#cnt_materia").show();
        //     //$("#cnt_esp").hide();

        // }else{
        //     $("#cnt_parcial").hide();
        //     $("#cnt_modulos").show();
        //     $("#cnt_materia").hide();
        //     //$("#cnt_esp").show();
        // }
    })
</script>
<!-- Usu Id Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id', Auth::user()->id , ['class' => 'form-control']) !!}
</div>
<!-- Adm Hinicio Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('adm_hinicio', 'Adm Hinicio:') !!}
    {!! Form::text('adm_hinicio', $hini, ['class' => 'form-control']) !!}
</div>

<!-- Adm Hfinal Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('adm_hfinal', 'Adm Hfinal:') !!}
    {!! Form::text('adm_hfinal', $hfin, ['class' => 'form-control']) !!}
</div>

<div class="panel panel-primary" >
  <div class="panel-body">
    <!-- Contenido del panel -->
    <div class="row container-fluid">
        <!-- Adm Finicio Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('adm_finicio', 'Desde:') !!}
            {!! Form::date('adm_finicio', $fini, ['class' => 'form-control']) !!}
        </div>
        <!-- Adm Ffinal Field -->
        <div class="form-group col-sm-3">
            {!! Form::label('adm_ffinal', 'Hasta:') !!}
            {!! Form::date('adm_ffinal', $ffin, ['class' => 'form-control']) !!}
        </div>
        <!-- Adm Obs Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('adm_obs', 'Descripcion:') !!}
            {!! Form::text('adm_obs', null, ['class' => 'form-control']) !!}
        </div>
    </div>
  </div>
</div>

<div class="row container-fluid">
<div class="panel panel-primary" style="margin-top:-20px; ">
  <div class="panel-body">

    <div class="form-group col-sm-3">
        {!! Form::label('adm_tipo', 'Habiliar por:') !!}
        {!! Form::select('adm_tipo',
        ['1'=>'Culturales'
        ,'2'=>'Técnicos'
        ] ,null, ['class' => 'form-control','id'=>'adm_tipo']) !!}
    </div>

    <div class="form-group col-sm-3" id="cnt_parcial">
        {!! Form::label('adm_parcial', 'Parcial:') !!}
        {!! Form::select('adm_parcial',
        ['0'=>'Seleccione'
        ,'1'=>'Parcial 1'
        ,'2'=>'Parcial 2'
        ,'3'=>'Parcial 3'
        ,'7'=>'Ex Quimestre 1'
        ,'4'=>'Parcial 4'
        ,'5'=>'Parcial 5'
        ,'6'=>'Parcial 6'
        ,'8'=>'Ex Quimestre 2'
        ,'9'=>'Ex Supletorio'
        ,'10'=>'Ex Remedial'
        ,'11'=>'Ex Gracia'
        ] ,null, ['class' => 'form-control','id'=>'adm_parcial']) !!}
    </div>

    <div class="form-group col-sm-3">
        {!! Form::label('jor_id', 'Jornada:') !!}
        {!! Form::select('jor_id',$jor,null,['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-3" id="cnt_esp" >
        {!! Form::label('esp_id', 'Especialidad:') !!}
        {!! Form::select('esp_id',$esp,null,['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-3">
        {!! Form::label('cur_id', 'Curso:') !!}
        {!! Form::select('cur_id',$cur,null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-3">
        {!! Form::label('paralelo', 'Paralelo:') !!}
        {!! Form::select('paralelo',
        [
        '0'=>'Todos',
        'A'=>'A',
        'B'=>'B',
        'C'=>'C',
        'D'=>'D',
        'E'=>'E',
        'F'=>'F',
        'G'=>'G',
        'H'=>'H',
        'I'=>'I',
         ] ,null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-sm-3" id="cnt_materia">
        {!! Form::label('mtr_id', 'Materia:') !!}
        {!! Form::select('mtr_id',$mtr,null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-3" id="cnt_modulos" hidden>
        {!! Form::label('mod_id', 'Modulos:') !!}
        {!! Form::select('mod_id',$mod,null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group col-sm-3" id="cnt_insumos">
        {!! Form::label('insumo', 'Insumo:') !!}
        {!! Form::select('insumo',$ins,null, ['class' => 'form-control']) !!}
    </div>
     <div class="form-group col-sm-3" hidden>
        {!! Form::label('doc_id', 'Docente:') !!}
        {!! Form::select('doc_id',$doc,null,['class' => 'form-control']) !!}
    </div>

  </div>
    </div>
</div>
<!-- Adm Estado Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('adm_estado', 'Adm Estado:') !!}
    {!! Form::number('adm_estado', 1, ['class' => 'form-control']) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('adminNotas.index') !!}" class="btn btn-danger pull-right">Cancelar</a>
</div>
