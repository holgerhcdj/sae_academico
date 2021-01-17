@extends('layouts.app')

@section('content')
<?php
$dep=Auth::user()->usu_perfil;
if(isset($_POST['btn_buscar'])){
    $espid=$_POST['esp_id'];
}else{
    $espid=10;
}
?>
<script>
    $(function(){
        var dep='<?php echo $dep?>';
        if(dep==6){// si es inspector
            $("select[name=tp_asis]").val(0);
            $("select[name=esp_id]").val('<?php echo $espid?>');
            $("#mtr_id").hide();
        }else{
            $("select[name=tp_asis]").val(1);
            $("select[name=esp_id]").val('<?php echo $espid?>');
            $("#mtr_id").hide();
        }
    })
    
    $(document).on("change","select[name=mtr_id]",function() {
        $("input[name=materia]").val($(this).val());
    })

function validar(){

         if( ($('select[name=esp_id]').val()==7 || $('select[name=esp_id]').val()==8) && ($('select[name=jor_id]').val()==1 || $('select[name=jor_id]').val()==4 ) ){
            alert('Especialidad BGU/Basica Flexible sólo existe en Jornada Nocturna y Semi-Presencial');
            return false;
         }    
}


</script>
<style>
    table tr:hover,.sel_asistencia:hover{
        background:#eee;
        cursor:pointer;
    }
    
</style>
    <section class="content-header">
        <h1 class="text-center bg-primary">Registrar Asistencia {{date('Y-m-d')}}</h1>
<form action="asistencias_buscar" method="POST" onsubmit="return validar()" >
    {{csrf_field()}}
        <table class="table" style="margin-top:0px;">
            <tr>
                <td hidden id='td_perid'>
                    {!! Form::text('per_id',$per,null,['class'=>'form-control']) !!}    
                </td>
                <td hidden id="anl_id">
                    {!! Form::text('anl_id',$anl,null,['class'=>'form-control']) !!}    
                </td>
                <td hidden>
                    {!! Form::select('tp_asis',['0'=>'Inspección','1'=>'Docente'],null,['class'=>'form-control']) !!}    
                </td>
                <td id="jor_id">
                    {!! Form::select('jor_id',$jor,null,['class'=>'form-control']) !!}    
                </td>
                <td id="esp_id">
                    {!! Form::select('esp_id',$esp,null,['class'=>'form-control']) !!}    
                </td>
                <td id="cur_id">
                    {!! Form::select('cur_id',$cur,null,['class'=>'form-control']) !!}    
                </td>
                <td id="mtr_id" >
                    {!! Form::select('mtr_id',$mtr,null,['class'=>'form-control','id'=>'mtr_id']) !!}    
                </td>            
                <td>
                    {!! Form::select('par_id',[
                    'A'=>'A',
                    'B'=>'B',
                    'C'=>'C',
                    'D'=>'D',
                    'E'=>'E',
                    'F'=>'F',
                    'G'=>'G',
                    'H'=>'H',
                    'I'=>'I',
                    'J'=>'J',
                    ],null,['class'=>'form-control','id'=>'mtr_id']) !!}    
                </td>            

                <td>
                    <button class="btn btn-primary" name="btn_buscar"><i class="fa fa-search"></i> Buscar</button>

                </td>
            </tr>  
        </table>
</form>
    </section>
    <div class="content" style="margin-top:-30px ">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'asistencias.store']) !!}
                    {!! Form::hidden('materia',null,['class' => 'form-control']) !!}
                    {!! Form::hidden('fecha',date('Y-m-d'),['class' => 'form-control']) !!}
                    <table  style="width:50%" border="0">
                        <tr>
                            <th>#</th>
                            <th>Estudiante</th>
                            <th>Asistencia</th>
                            <th hidden>Observaciones</th>
                        </tr>
                        <?php $x=0;?>
                        @foreach($est as $e)
                        <?php $x++?>
                        <tr>
                            <td>{{$x}}</td>
                            <td>{{$e->est_apellidos.' '.$e->est_nombres}}</td>
                            <td>
                                {!! Form::select('estado'.$x,['0'=>'Asistencia','1'=>'Falta','2'=>'Atraso'],null, ['class' => 'form-control sel_asistencia']) !!}
                                {!! Form::hidden('mat_id'.$x,$e->mat_id, ['class' => 'form-control']) !!}
                            </td>
                            <td hidden>
                                {!! Form::text('observaciones'.$x,null, ['class' => 'form-control']) !!}
                            </td>
                        </tr>
                        @endforeach
                        <tfoot>
                         <tr>
                             <td colspan="4">
                                <button class="btn btn-primary btn_asist">Registrar Asistencias</button>
<!--                                 <button class="btn btn-warning pull-right btn_asist_envio">Registrar y Enviar Notificaciones</button> -->
                            </td>
                        </tr>
                    </tfoot>
                </table>
                {!! Form::hidden('cant',$x, ['class' => 'form-control']) !!}
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</form>    
@endsection
