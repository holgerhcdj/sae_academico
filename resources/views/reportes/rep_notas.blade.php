@extends('layouts.app')
@section('scripts')
<script>
$(function(){

    
$('#esp_id').val(10);

$('#parametro_t').hide();

$('#radioBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');

    if($('#'+tog).val()=='Q' || $('#'+tog).val()=='P'){
        //$('#cont_mtr').show();
    }else if($('#'+tog).val()=='M'){
        //$('#cont_mtr').show();
    }else if($('#'+tog).val()=='0'){
        $('#cont_quim').show();

        //$('#cont_esp').hide();
        $('#cont_esp').show();

        $('#parametro_c').show();
        $('#parametro_t').hide();

        //$('#cont_mtr').show();

        $('#cont_mtrt').show();
    }else if($('#'+tog).val()=='1'){
        $('#cont_quim').hide();
        $('#cont_esp').show();
        $('#parametro_c').hide();
        $('#parametro_t').show();
        //$('#cont_mtr').show();
       // $('#cont_mtrt').show();

        $("#cur_id").val(4);

        load_mat_tec();
    }else if($('#'+tog).val()=='TO'){
        //$('#cont_mtr').show();
        //$('#cont_mtrt').show();
    }else if($('#'+tog).val()=='MO'){
        //$('#cont_mtr').show();
        //$('#cont_mtrt').show();
    }else if($('#'+tog).val()=='2'){

    }
})
  
})
      $(document).on('click', '#generar', function () {
                var url = window.location;
                if($("#opt_tipo").val()==0){
                    data=$("#jor_id").val()+
                    "&"+$("#cur_id").val()+
                    "&"+$("#parc").val()+
                    "&"+$("#quimestre").val()+
                    "&"+$("#option").val()+
                    "&"+$("#mtr_id").val()+
                    "&"+$("#opt_tipo").val()+
                    "&"+$("#esp_id").val();
                }else if($("#opt_tipo").val()==1){
                    data=$("#jor_id").val()+"&"+$("#cur_id").val()+"&"+$("#parc").val()+"&"+$("#quimestre").val()+"&"+$("#opt_mod").val()+"&"+$("#mtrt_id").val()+"&"+$("#opt_tipo").val()+"&"+$("#esp_id").val();
                }else if($("#opt_tipo").val()==2){
                    data=$("#jor_id").val()+"&"+$("#cur_id").val()+"&"+$("#parc").val()+"&"+$("#quimestre").val()+"&"+$("#option").val()+"&"+$("#mtr_id").val()+"&"+$("#opt_tipo").val();
                }
                $.ajax({
                    url: url + "/notas/"+data,//RegNotasController@reporte
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                        $(".bloqueo").css('visibility', 'visible');
                    },
                    success: function (dt) {
                        $("#tbl_notas").html(dt);
                        $(".bloqueo").css('visibility', 'hidden');
                    }
                });
         
      }) 

       $(document).on('change', '#quimestre', function () {
        if(this.value==1 || this.value==2){
            $("#parametro_c").show();
        }else{
            $("#parametro_c").hide();
        }
    })

      $(document).on('click', '#excel,#pdf,#view', function () {
        if(this.id=="excel"){
            $("#op").val(0);
        }else if(this.id=="pdf"){
            $("#op").val(1);
        }else{
            $("#op").val(2);
        }
        $("#frm_excel").submit(function(){
            $("#datos").val($("#tbl_notas").html());
        });

})

function load_mat_tec(){
    var url = window.location;
                $.ajax({
                    url: url + "/load_mat_tec/"+$("#esp_id").val()+"&"+$("#cur_id").val(),
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {
                        if($("#cur_id").val()<=3 && $("#opt_tipo").val()==1){
                            alert("Curso debe ser Primero, Segundo o Tercero");
                            $("#cur_id").val(4);
                            return false;
                        }

                    },
                    success: function (dt) {

                        $("#mtrt_id").html(dt);
                    }
                });

}



</script>
@endsection
@section('content')
<style>
table{
   background:white;  
   border:solid 1px #ccc;
}
table th,table td{
    border: solid 1px #ccc; 
}
.rotar {
    writing-mode: vertical-lr;
    transform: rotate(180deg);
    margin-left:40%; 
} 

table .t1{
    text-align:center; 
    font-size:15px;
    background:black;
    color:white;  

}    
table .t2 span{
    margin-left:30px;  
} 
.nota{
    text-align:right;
    width:40px; 
}
#radioBtn .notActive{
    color: #3276b1;
    background-color: #fff;
}
tfoot span{
    margin-left:20px;
    border:solid 1px #ccc;
    padding:5px;   
}
.bloqueo{
    background:rgba(245, 245, 245, 0.4);
    position:absolute;
    width:83%;
    height:85%;
    z-index:9999;
    text-align:center;
    visibility:hidden; 
}
.bloqueo img{
    width: 120px;
    margin-top:10%; 
}
.rpt_ind:hover{
    color:#2C9FE8;
    cursor:pointer;  
    text-decoration:underline; 
}
.nota_baja{
    color:brown;
}  
#tbl_head th,#tbl_head{
    border:none; 
}  
.enc_materias{
    text-align:center;
    vertical-align:middle;  
    /*text-decoration:none;*/ 
}
.num{
    height:70px;
}
.est{
    min-width:250px; 
}
</style>
<section class="content-header">

    <div class="bloqueo">
        <img src="{{asset('img/loading.gif')}}" class="user-image" alt="User Image"/>
    </div>

    
<div class="panel " style="margin-top:-15px;">
    <div class="panel-heading bg-info">
      <h3 class="panel-title text-center " style="font-size:25px;color:#000 !important ">REPORTE DE NOTAS</h3>
    </div>
    <div class="panel-body" style="margin-top:-12px; " >
        <table class="table" id="tbl_head" border="0">
            <tr>
                <th>
                    <div class="input-group " >
                        <div id="radioBtn" class="btn-group ">
                            <a class="btn btn-primary btn-sm active" data-toggle="opt_tipo" data-title="0">NOTAS CULTURALES</a>
                            <!-- <a class="btn btn-primary btn-sm notActive" data-toggle="opt_tipo" data-title="1" style="display:block; " >NOTAS TÉCNICAS</a> -->
                            <!--                 <a class="btn btn-primary btn-sm notActive" data-toggle="opt_tipo"  data-title="2">INDIVIDUALES</a> -->
                        </div>
                        <input type="hidden" name="opt_tipo" value="0" id="opt_tipo">
                    </div>                      
                </th>
                <th>
                    <div class="input-group " id="parametro_c" >
                        <div id="radioBtn" class="btn-group"  >
                            <a class="btn btn-danger btn-sm active" data-toggle="option" data-title="Q">QUIMESTRE</a>
                            <a class="btn btn-danger btn-sm notActive" data-toggle="option" data-title="P">PARCIAL</a>
                            <a class="btn btn-danger btn-sm notActive" data-toggle="option" data-title="M">MATERIA</a>
                        </div>
                        <input type="hidden" name="option" value="Q" id="option">
                    </div>    
                </th>
                <th>
                    <div class="input-group " id="parametro_t" >
                        <div id="radioBtn" class="btn-group">
                            <a class="btn btn-danger btn-sm active" data-toggle="opt_mod" data-title="TO">TOTAL</a>
                            <a class="btn btn-danger btn-sm notActive" data-toggle="opt_mod" data-title="MO">MODULO</a>
                        </div>
                        <input type="hidden" name="opt_mod" value="TO" id="opt_mod">
                    </div>                     
                </th>
                <th>
                    <div class="form-group " >
                        <form action="regNotas.excel" method="POST" id="frm_excel" target="_blank">
                            <input type="hidden" name="_token" value="{{ csrf_token()}}">
                            <input type="hidden" name="datos" id="datos" >
                            <input type="hidden" name="op" id="op" >
                            <button class="btn btn-success" id="excel" >XLS</button>
<!--                             <button class="btn btn-danger" id="pdf" >PDF</button> -->
                            <button class="btn btn-danger" id="view" >PDF</button>
                        </form>

                    </div>
                </th>
            </tr>
        </table>
<!-- Buscador -->
<div class="cont_buscador" style="margin-top:-35px ">
    
    <form action="imprimir_individuales" method="POST" target="_blank">
        <div class="form-group col-sm-3">
            {!! Form::label('jor_id', 'Jornada:') !!}
            {!! Form::select('jor_id',$jor,null,['class'=>'form-control']) !!}    
        </div> 
        <div class="form-group col-sm-3" id="cont_esp"  >
            {!! Form::label('esp_id', 'Especialidad:') !!}
            {!! Form::select('esp_id',$esp,null,['class'=>'form-control','onchange'=>'load_mat_tec()']) !!}
        </div>
        <div class="form-group col-sm-3">
            {!! Form::label('cur_id', 'Curso:') !!}
            {!! Form::select('cur_id',$cur,null,['class'=>'form-control','id'=>'cur_id','onchange'=>'load_mat_tec()']) !!}
        </div>

        <div class="form-group col-sm-2">
            {!! Form::label('parc', 'Paralelo:') !!}
            <select name="parc" id="parc" class="form-control">
                <option value="0">Todos</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
                <option value="F">F</option>
                <option value="G">G</option>
                <option value="H">H</option>
                <option value="I">I</option>
            </select>                
        </div>
        <div class="form-group col-sm-3" id="cont_quim" >
            {!! Form::label('quimestre', 'Quimestre/Bloque:') !!}
            {{ Form::select('quimestre', [
            '0' => 'Seleccione',
            'B1' => 'Bloque 1',            
            'B2' => 'Bloque 2',            
            'B3' => 'Bloque 3',            
            '1' => 'Primer Quimestre I',            
            'B4' => 'Bloque 4',            
            'B5' => 'Bloque 5',            
            'B6' => 'Bloque 6',            
            '2' => 'Segundo Quimestre',            
            ],null,['class' => 'form-control','id'=>'quimestre']) }}    
        </div>

        <div class="form-group col-sm-2">
            <br>
            <i id="generar" class="btn btn-info glyphicon glyphicon-search"></i>
            {{csrf_field()}}
            <button class="btn btn-default pull-right "  id="rep_masivo"><i class="glyphicon glyphicon-print"></i> Individuales</button>    
        </div>    
        <div class="form-group col-sm-3" id="cont_mtr" hidden >
            {!! Form::label('mtr_id', 'Materia/Modulo:') !!}
            {!! Form::select('mtr_id',$mtr,null,['class'=>'form-control','id'=>'mtr_id']) !!}
        </div>

        <div class="form-group col-sm-3" id="cont_mtrt" hidden >
            {!! Form::label('mtrt_id', 'Materia/Modulo:') !!}
            {!! Form::select('mtrt_id',$mtrt,null,['class'=>'form-control','id'=>'mtrt_id']) !!}
        </div>
    </form> 
</div>


    </div>  


    </div>
</section>
<div class="content" style="margin-top:-30px; ">
        <table  id="tbl_notas" class="table table-striped" >
        </table>   
</div>



@endsection
