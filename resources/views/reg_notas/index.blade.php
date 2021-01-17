@extends('layouts.app')
@section('content')
<section class="content-header">
    <h1 class="pull-left">REGISTRO DE NOTAS</h1>
    <br>
</section>
<style type="text/css">

            #tbl_notas tbody tr:hover{
                background:#9BC8D2; 
            }
            #tbl_notas thead{
                color:#00748E; 
            }
            #tbl_notas tbody td{
              border-bottom:solid 1px #B8E8F3;  
            }
            #tbl_notas thead tr th{
                text-align:center;
                border:solid 1px #75B5C3;
                vertical-align:bottom;
                font-size:11px;     
                font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;             
                height:50px !important;

            }
            #tbl_notas tbody tr td input{
                width:50px !important; 
                text-align:right; 
            }
            .txt_prom{
                background:#eee; 
            }
            .nota_baja{
                color:brown;
                font-weight:bold;
                border:solid 1px brown;  
            }
            .rotate_tx{
                writing-mode: vertical-lr;
                transform: rotate(180deg);
                 padding: 5px 0px 5px 0px;/*top right boottom left*/
            }
            .supletorio{
                border:solid 1px #F28E00;
               background:#FFEED5;
            }
            .remedial{
                border:solid 1px #d9534f;
               background:#FDCCCB;
            }
            .chk_selected{
                background:#5bc0de;
                padding:2   px; 
            }
            #tbl_tareas th,#tbl_tareas td{
              border:solid 1px #D8D8D8;  
            }
            .cls_prom_tmp{
                background:#B2E1F3; 
                font-weight:bolder; 
            }
            #tbl_tareas .form-control{
                width:50px;
                padding:0px;  
            }

            .tx_promq{
                background:#eee; 
            }

</style>
<script src="{{asset('js/regNotas.js')}}" ></script>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<div class="content" >
    <div class="box box-primary">
        <div class="box-body">
            <form action="cargar.frm_notas" method="POST" id='frm_data'>

                <input type="hidden" name="anl_id" id="anl_id" >

                <div class="form-group col-sm-2">
                    {!! Form::label('jor_id', 'Jornada:') !!}
                    {!! Form::select('jor_id',$jor,null,['class'=>'form-control','id'=>'jor_id']) !!}    
                </div>

                <div class="form-group col-sm-2">
                    {!! Form::label('esp_id', 'Especialidad:') !!}
                    {!! Form::select('esp_id',$esp,null,['class'=>'form-control','id'=>'esp_id']) !!}    
                </div>                
                <div class="form-group col-sm-2">
                    {!! Form::label('cur_id', 'Curso:') !!}
                    {!! Form::select('cur_id',$cur,null,['class'=>'form-control','id'=>'cur_id']) !!}
                </div>
                <div class="form-group col-sm-2">
                    {!! Form::label('mtr_id', 'Materia:') !!}
                    {!! Form::select('mtr_id',$mtr,null,['class'=>'form-control','id'=>'mtr_id']) !!}    
                </div>
                <div class="form-group col-sm-2" id="mtr_tec" hidden>
                    {!! Form::label('mtr_tec_id', 'Modulo:') !!}
                    {{ Form::select('mtr_tec_id', [
                        '0' => 'Seleccione',            
                        ],null,['class' => 'form-control','id'=>'mtr_tec_id']) }}    
                </div>
                <div class="form-group col-sm-2" id="bloq" >
                    {!! Form::label('bloque', 'Bloque/Parcial:') !!}
                    <select name="bloque" id="bloque" class="form-control">

                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <i id="btn_buscar" class="btn btn-primary fa fa-refresh" style="margin-top:25px ">  Cargar Datos</i>
                </div>
            </form>
        </div>

        <div class="row container-fluid">
            <div class="table-responsive col-lg-8 col-md-12 " id="cont_table">
                <table id="tbl_notas" border="0">
                </table>
            </div>
            <div class="table-responsive col-lg-4 col-md-12 " >


            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="mdl_notas_aula_virtual" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <input type="hidden" id="aux_ins_id">
          <div class="modal-header" style="background:#043643;color:white  ">
            <h5 class="modal-title text-center" id="mdl_titulo">
                <i class="fa fa-file-o pull-left btn bg-gray btn_nuevo_aporte" data-toggle='tooltip' data-placement='top' title="Añadir nuevo aporte" > Nuevo Aporte</i>
                <span></span>
            </h5>
      </div>
      <div class="modal-body" id="mdl_content">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary fa fa-hand-o-right pull-left" id="btn_asg_notas"> Asignar Notas</button>
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Salir</button>
      </div>    
    </div>
</div>
</div>

@endsection
