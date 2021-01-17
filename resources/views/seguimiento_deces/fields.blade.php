<?php
$f=date('Y-m-d');
$f2=date('Y-m-d');
$res=Auth::user()->usu_apellidos.' '.Auth::user()->name;
$prf=(Auth::user()->usu_perfil);//Obtengo el perfil
$prm=Auth::user()->AsignaPermisos->where('mod_id',39)->first();//Obtengo los permisos
//dd($prm);
$hdd="hidden";
$vl=0;
if(isset($seguimientoDece)){
    $f=$seguimientoDece->fecha;
    $res=$seguimientoDece->responsable;
    $hdd="";
    $vl=$seguimientoDece->mat_id;
}
?>

<style>
    .error{
        border: solid 1px brown;
    }
</style>

<script type="text/javascript">
$(function(){
    var vl='<?php echo $vl?>';
 $("#mat_id").val(vl);
 if(vl!=0){
    $("#mat_id").attr('disabled',true);
    $("#fecha").attr('disabled',true);
 }
 $(".sel-status").select2();
})
$(document).on("click","#btn_continuar",function(){
    if(confirm("Los Datos son Correctos")){
        $("#cont_seguimientos").show();
        $("#btn_continuar").hide();
    }
})
function validar(){

         if ($("select[name=mat_id]").val()=='0'){
            alert("Elija un Estudiante");
            $("select[name=mat_id]").select();
            $("select[name=mat_id]").addClass("error");
            return  false;
        }
         if ($("input[name=motivo]").val().length==0){
            alert("Motivo es obligatorio");
            $("input[name=motivo]").select();
            $("input[name=motivo]").addClass("error");
            return  false;
        }

        if ($("input[name=responsable]").val().length==0){
            alert("Responsable es obligatorio");
            $("input[name=responsable]").select();
            $("input[name=responsable]").addClass("error");
            return  false;
        }
        if ($("input[name=obs]").val().length==0){
            alert("Observaciones es obligatorio");
            $("input[name=obs]").select();
            $("input[name=obs]").addClass("error");
            return  false;
        }

        //alert($("textarea[name=area_trabajada]").val());

        if ($("textarea[name=area_trabajada]").val().length==0){
            alert("Area Trabajada es obligatorio");
            $("textarea[name=area_trabajada]").select();
            $("textarea[name=area_trabajada]").addClass("error");
            return  false;
        }
        if ($("textarea[name=seguimiento]").val().length==0){
            alert("Detalle es obligatorio");
            $("textarea[name=seguimiento]").select();
            $("textarea[name=seguimiento]").addClass("error");
            return  false;
        }
}
</script>

<!-- Mat Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mat_id', 'Estudiante:') !!}
    {!! Form::select('mat_id',$est,null, ['class' => 'form-control sel-status','id'=>'mat_id']) !!}
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::date('fecha',$f2, ['class' => 'form-control']) !!}
</div>

<!-- Motivo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('motivo', 'Motivo:') !!}
    {!! Form::text('motivo', null, ['class' => 'form-control']) !!}
</div>

<!-- Responsable Field -->
<div class="form-group col-sm-6" hidden="">
    {!! Form::label('responsable', 'Responsable:') !!}
    {!! Form::text('responsable', $res, ['class' => 'form-control']) !!}
</div>

<!-- Obs Field -->
<div class="form-group col-sm-6">
    {!! Form::label('obs', 'Observacion Inicial:') !!}
    {!! Form::text('obs', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6" hidden {{$hdd}}>
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado',['0'=>'Activo','1'=>'Inactivo'],null, ['class' => 'form-control']) !!}
</div>



<div class="col-sm-12" id="cont_seguimientos" >
    <table class="" style="width:100%">
        <tr class="bg-info">
            <th class="text-center">Departamento</th>
            <th class="text-center">Area Trabajada</th>
            <th class="text-center">Detalle</th>
        </tr>
        <tr>
            <td style="vertical-align:top ">
                {!! Form::hidden('segid',null,['class' => 'form-control']) !!}
                @if($prm->especial==1)
                <!-- Si tiene permisos especial -->
                    {!! Form::select('departamento',['0'=>'DECE','1'=>'CAPELLANIA'],null, ['class' => 'form-control']) !!}
                @else
                    @if($prf==7)
                    <!-- Si es perfil DECE -->
                      {!! Form::select('departamento',['0'=>'DECE'],null, ['class' => 'form-control']) !!}
                    @elseif($prf==15)
                    <!-- Si es perfil es Capellania -->
                      {!! Form::select('departamento',['1'=>'CAPELLANIA'],null, ['class' => 'form-control']) !!}
                    @else
                      <span class="label label-danger" style="font-size:17px ">SU PERFIL NO PERMITE AÑADIR SEGUIMIENTOS</span>
                    @endif
                @endif
            </td>
            <td>
                {!! Form::textarea('area_trabajada',null, ['class' => 'form-control','cols'=>'30','rows'=>'1']) !!}
            </td>
            <td>
                {!! Form::textarea('seguimiento',null, ['class' => 'form-control','cols'=>'30','rows'=>'1']) !!}
            </td>
        </tr>
        <tr>
            <td colspan="3" >
                <a href="{!! route('seguimientoDeces.index') !!}" class="btn btn-danger pull-left" ><i class="fa fa-close"> SALIR</i></a>
                @if($prm->new==1)
                {!! Form::button('<i class="fa fa-save"> Guardar</i>', ['type' => 'submit', 'class' => 'btn btn-primary pull-right']) !!}
                @endif
            </td>
        </tr>
    </table>
    <div class="col-sm-12">
        <h4 class="bg-primary text-center" style="font-weight:bolder;  ">SEGUIMIENTO REALIZADO AL ESTUDIANTE</h4>
    </div> 
    <table class="table pull-left" style="width:45%; ">
        <thead class="bg-warning">
        <tr>
            <th colspan="4" class="text-center">DECE</th>
        </tr>
        <tr>
            <th class="text-center">Fecha</th>
            <th class="text-center">Area Trabajada</th>
            <th class="text-center">Detalle</th>
            <th class="text-center">Psicólogo</th>
        </tr>
        </thead>
        @foreach($acc as $a)
            @if($a->departamento==0)
            <tr> 
                <td>{{$a->fecha}}</td>
                <td>{{$a->area_trabajada}}</td>
                <td>{{$a->seguimiento}}</td>
                <td>
                    {{$a->usu_apellidos.' '.$a->name}}
                    @if($prm->del==1)
                    <i class="btn btn-danger btn-xs fa fa-minus btn_eliminar" data="{{$a->accid}}" ></i>
                    @endif
                </td>
            </tr>
            @endif
        @endforeach
    </table>
    <table class="table" style="width:45%; ">
        <thead class="bg-aqua">
        <tr>
            <th colspan="4" class="text-center">CAPELLANÍA</th>
        </tr>
        <tr>
            <th class="text-center">Fecha</th>
            <th class="text-center">Area Trabajada</th>
            <th class="text-center">Detalle</th>
            <th class="text-center">Capellán</th>
        </tr>
    </thead>
        @foreach($acc as $a)
            @if($a->departamento==1)
            <tr> 
                <td>{{$a->fecha}}</td>
                <td>{{$a->area_trabajada}}</td>
                <td>{{$a->seguimiento}}</td>
                <td>{{$a->usu_apellidos.' '.$a->name}}
                    @if($prm->del==1)
                    <i class="btn btn-danger btn-xs fa fa-minus btn_eliminar" data="{{$a->accid}}" ></i>
                    @endif
                </td>
            </tr>
            @endif
        @endforeach
    </table>
</div>
<div class="col-sm-12">
<!--     <i class="btn btn-primary fa fa-share" id="btn_continuar" hidden=""> Continuar</i> -->
    <!-- <a href="{!! route('seguimientoDeces.index') !!}" class="btn btn-danger pull-right" >SALIR</a> -->
</div>     
