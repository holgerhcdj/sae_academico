@extends('layouts.app')

@section('scripts')
<script>
    $(function () {
        $("#search").click(function () {
            dat=$("#jor").val()+'&'+$("#esp").val()+'&'+$("#part").val()+'&'+$("#txt").val();
            var url = window.location;
                $.ajax({
                    url: url + "/search/"+dat,
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {

                        tx=$("#txt").val();
                        if(tx.trim().length==0){
                            if($("#jor").val()==0){
                                alert("Elija una Jornada");
                                return false;                                
                            }else{
                                if($("#esp").val()==0){
                                    alert("Elija una Especialidad");
                                    return false;                                    
                                }else{
                                    if($("#part").val()==0){
                                        alert("Elija un Paralelo");
                                        return false;                                        
                                    }else{
                                        return true;
                                    }
                                }
                            }
                        }else{
                            return true;
                        }

                    },
                    success: function (datos) {
                        $("#datos_busqueda").val(dat);
                        dt="";
                        c=0;
                        $(datos).each(function (){
                            c++;
                            dt+="<tr><td>"+c+"</td><td class='tx_nombres'>"+this['est_apellidos']+" "+this['est_nombres']+"</td><td>"+this['est_cedula']+
                            "</td><td><input type='text' class='tx_notas' id='2_"+this['est_id']+"' maxlength='5' /></td>"+
                            "<td><input type='text' class='tx_notas' id='3_"+this['est_id']+"' maxlength='5' /></td>"+
                            "<td><input type='text' class='tx_notas' id='4_"+this['est_id']+"' maxlength='5' /></td>"+
                            "<td><input type='text' class='tx_notas' id='5_"+this['est_id']+"' maxlength='5' /></td>"+
                            "<td><input type='text' class='tx_notas' id='6_"+this['est_id']+"' maxlength='5' /></td>"+
                            "<td><input type='text' class='tx_notas' id='7_"+this['est_id']+"' maxlength='5' /></td>"+
                            "<td><input type='text' size='10' class='txt_text' id='pr_"+this['est_id']+"' /></td>"+
                            "<td><input type='text' class='tx_notas' id='8_"+this['est_id']+"' maxlength='5'  /></td>"+
                            "<td><input type='text' class='tx_notas' id='9_"+this['est_id']+"' maxlength='5'  /></td>"+
                            "<td><input type='text' class='tx_notas' id='10_"+this['est_id']+"' maxlength='5' /></td>"+
                            "<td><input type='text' class='tx_notas' id='11_"+this['est_id']+"' maxlength='5' /></td>"+
                            "<td><input type='text' class='tx_notas' id='12_"+this['est_id']+"' maxlength='5' /></td>"+
                            "<td align='center' ><input type='checkbox' id='pe_"+this['est_id']+"' onclick='guardar("+this['est_id']+")' /></td>"+
                            "<td align='center' ><input type='checkbox' id='ee_"+this['est_id']+"' onclick='guardar("+this['est_id']+")' /></td>"+
                            "<td><input type='text' sise='10' class='txt_text' id='ob_"+this['est_id']+"' /></td>"+
                            "</tr>";
                            $('#notasExtras-table tbody').html(dt);
                            var tmp_id=this['est_id'];

                            $.ajax({
                                url: url+"/search_note/"+this['est_id'],
                                type: 'GET',
                                dataType: 'json',
                                success:function(data){
                                 
                                   if(data.length>0){
                                    $("#2_"+tmp_id).val(data[0]['n2']);  
                                    $("#3_"+tmp_id).val(data[0]['n3']);  
                                    $("#4_"+tmp_id).val(data[0]['n4']);  
                                    $("#5_"+tmp_id).val(data[0]['n5']);  
                                    $("#6_"+tmp_id).val(data[0]['n6']);  
                                    $("#7_"+tmp_id).val(data[0]['n7']);  
                                    $("#8_"+tmp_id).val(data[0]['n8']);  
                                    $("#9_"+tmp_id).val(data[0]['n9']);  
                                    $("#10_"+tmp_id).val(data[0]['n10']);  
                                    $("#11_"+tmp_id).val(data[0]['n11']);  
                                    $("#12_"+tmp_id).val(data[0]['n12']);  
                                    $("#pr_"+tmp_id).val(data[0]['cert_primaria']);  
                                    $("#ob_"+tmp_id).val(data[0]['obs']);  
                                    if(data[0]['par_estudiantil']==1){
                                        $("#pe_"+tmp_id).prop('checked',true);
                                    }
                                    if(data[0]['ex_enes']==1){
                                        $("#ee_"+tmp_id).prop('checked',true);
                                    }

                                   }  
                                  
                                }
                            })

                        });

                    }
                });
        });
    })

    $(document).on('keyup', '.tx_notas', function () {
        this.value = this.value.replace(/[^0-9.]/g, '');
    });

    $(document).on('blur', '.tx_notas', function () {
        if(this.value>10){
            alert('Valor Incorrecto');
            $(this).focus();            
            $(this).val(null);
        }else{
            dt=this.id.split('_');
            guardar(dt[1]);
        }
    });

    $(document).on('blur', '.txt_text', function () {
            dt=this.id.split('_');
            guardar(dt[1]);
    });

    $(document).on('click', '#btn', function () {
        alert('Datos Guardados Correctamente');
        $('#notasExtras-table tbody').html(null);
    });


function guardar(id_est){
     n2=$("#2_"+id_est).val();
     n3=$("#3_"+id_est).val();
     n4=$("#4_"+id_est).val();
     n5=$("#5_"+id_est).val();
     n6=$("#6_"+id_est).val();
     n7=$("#7_"+id_est).val();
     n8=$("#8_"+id_est).val();
     n9=$("#9_"+id_est).val();
     n10=$("#10_"+id_est).val();
     n11=$("#11_"+id_est).val();
     n12=$("#12_"+id_est).val();
     pr=$("#pr_"+id_est).val();
     pe=$("#pe_"+id_est).prop('checked');
     ee=$("#ee_"+id_est).prop('checked');     
     ob=$("#ob_"+id_est).val();     
     if(pe==true){
        pe=1;
     }else{
        pe=0;
     }
     if(ee==true){
        ee=1;
     }else{
        ee=0;
     }
     if(id_est>0){
        if(n2.length==0){
            n2=0;
        }
        if(n3.length==0){
            n3=0;
        }
        if(n4.length==0){
            n4=0;
        }
        if(n5.length==0){
            n5=0;
        }
        if(n6.length==0){
            n6=0;
        }
        if(n7.length==0){
            n7=0;
        }
        if(n8.length==0){
            n8=0;
        }
        if(n9.length==0){
            n9=0;
        }
        if(n10.length==0){
            n10=0;
        }
        if(n11.length==0){
            n11=0;
        }
        if(n12.length==0){
            n12=0;
        }

    }else{
        alert("Error al Encontrar al Alumno");
        return false;
    }

data=id_est+"&"+n2+"&"+n3+"&"+n4+"&"+n5+"&"+n6+"&"+n7+"&"+n8+"&"+n9+"&"+n10+"&"+n11+"&"+n12+"&"+pr+"&"+pe+"&"+ee+"&"+ob;

            var url = window.location;
                $.ajax({
                    url: url + "/save/"+data,
                    type: 'GET', //this is your method
                    dataType: 'json',
                    beforeSend: function () {

                    },
                    success: function (dat) {
                        if(dat!=0){
                            alert("Error al guardar");
                        }
                    }
                }).fail( function(jqXHR, textStatus, errorThrown) {

                    if (jqXHR.status === 0) {

                        alert('Not connect: Verify Network.');

                    } else if (jqXHR.status == 404) {

                        alert('Requested page not found [404]');

                    } else if (jqXHR.status == 500) {

                        alert('Internal Server Error [500].');

                    } else if (textStatus === 'parsererror') {

                        alert('Requested JSON parse failed.');

                    } else if (textStatus === 'timeout') {

                        alert('Time out error.');

                    } else if (textStatus === 'abort') {

                        alert('Ajax request aborted.');

                    } else {

                        alert('Uncaught Error: ' + jqXHR.responseText);

                    }
                });

}


</script>
@endsection


@section('content')
    <section class="content-header">
        <div class="panel panel-primary text-center" style="font-size:20px;padding:0px;font-weight:bolder;   ">
                EXPEDIENTE ACADÉMICO DE TERCERO DE BACHILLERATO
        </div> 
        <div class="form-group col-sm-2">
            {!! Form::label('jor', 'Jornada:') !!}
            <select name="jor" id="jor" class="form-control" >
                <option value="0">Todas</option>
                @foreach($jor as $j)
                @if(isset($busqueda) && ($j->id==$busqueda['jor']))
                <option selected value="{{$j->id}}">{{ $j->jor_descripcion }}</option>
                @else
                <option value="{{$j->id}}">{{ $j->jor_descripcion }}</option>
                @endif
                @endforeach
            </select>  
        </div>
        <div class="form-group col-sm-2">
            {!! Form::label('esp', 'Especialidad:') !!}
            <select name="esp" id="esp" class="form-control">
                <option value="0">Todas</option>
                @foreach($esp as $e)
                @if(isset($busqueda) && ($e->id==$busqueda['esp']))                                            
                <option selected value="{{$e->id}}">{{ $e->esp_descripcion }}</option>
                @else
                <option value="{{$e->id}}">{{ $e->esp_descripcion }}</option>
                @endif
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-2">
            {!! Form::label('part', 'Paralelo Técnico:') !!}
            <select name="part" id="part" class="form-control">
                @if(isset($busqueda) && ($busqueda['part']!='0'))
                <option selected value="{{$busqueda['part']}}">{{$busqueda['part']}}</option>
                @endif
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
                <option value="NINGUNO">NINGUNO</option>
            </select>                
        </div>

        <div class="form-group col-sm-4">
            {!! Form::label('txt', 'NOMBRES/CEDULA:') !!}
            <div class="input-group">
                <input type="text" class="form-control" name="txt" id="txt" placeholder="Nombres / Apellidos /Cedula" value="<?php
                if (isset($busqueda)) {
                    echo $busqueda['txt'];
                }
                ?>" >
                <span class="input-group-btn">
                    <input class="btn btn-primary " type="submit" name="search" id="search" value="Buscar" />                    
                </span>
            </div>
        </div>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
<style type="text/css">
    .tx_notas{
        width:40px;
        text-align:right;   
    }
    .txt_text,.tx_notas{
        border-style:groove;
    }
    .row-tbl th{
        border:solid 1px #0684C6; 
        text-align:center;
        background:#2DB3D9;
        color:#fff;
        text-shadow:2px 2px 2px #000000 ;
    }
    #notasExtras-table tbody tr td{
        padding:0px;   
    }
    #notasExtras-table thead tr th{
        padding:5px 0px 5px 0px;   
    }
.glyphicon{
    padding:5px; 
}
</style>                

                <table class="table table-collapse table-responsive" id="notasExtras-table">
                    <thead>
                        <tr class="row-tbl" >
                            <th colspan="3" >ESTUDIANTE</th>
                            <th colspan="10" >CALIFICACIONES DE EDUCACION GENERAL BASICA</th>
                            <th colspan="2" >BACHILLER</th>
                            <th >PARTICIP</th>
                            <th >EXAMEN ENES</th>
                            <th colspan="2"></th>
                        </tr>
                        <tr class="row-tbl">
                            <th>No</th>
                            <th>Apellidos/Nombres</th>
                            <th>Cedula</th>
                            <th>2°</th>
                            <th>3°</th>
                            <th>4°</th>
                            <th>5°</th>
                            <th>6°</th>
                            <th>7°</th>
                            <th>Primaria</th>        
                            <th>8°</th>
                            <th>9°</th>
                            <th>10°</th>
                            <th>1°</th>
                            <th>2°</th>
                            <th>SI/NO</th>
                            <th>SI/NO</th>
                            <th>Obs</th>        
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td><button class="btn btn-primary" id="btn">Guardar</button></td>
                            <td colspan="16"></td>
                            {!! Form::open(['route' => 'notasExtras.store']) !!}
                            <td>
                                <input type="hidden" name="datos_busqueda" id="datos_busqueda" value="" />
                                <input type="submit" class="btn btn-success" name="" id="" value="Aceptar y Exportar">
                            </td>
                            {!! Form::close() !!}                            
                        </tr>
                    </tfoot>
                </table>                
<!--                 @include('notas_extras.table') -->
            </div>
<!--             <table id="tbl_notas"></table> -->
        </div>
    </div>
@endsection

