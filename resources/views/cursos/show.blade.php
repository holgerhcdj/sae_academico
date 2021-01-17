@extends('layouts.app')

@section('content')

<?php
$cursos->id>3?$hdBS='hidden':$hdBS='';
$cursos->id<4?$hdBG='hidden':$hdBG='';

?>

<script>
    $(function(){
        var tipo='<?php echo $tp?>';
        $("#tp").val(tipo);
    })
    $(document).on("click",".btn_asg",function(){

                     var url=window.location;
                     var token=$("#token").val();
                     var btn=$(this);
                     var dat=$(this).attr('data').split('&');
                     var obj=dat[1];
                     var usu=$("#"+dat[1]+dat[0]).attr('data');
                     var cur=$("#cur_id").val();
                     var par=obj;
                     var jor=dat[0];
                     var dirid=$(btn).attr('lang');
                     var tp=$("#tp").val();

                    $.ajax({
                        url: url+'/asg_dirgente',//CursosController@asg_dirgente
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {usu:usu,cur:cur,par:par,dirid:dirid,jor,tp},
                        beforeSend:function(){
                            if(usu==undefined){
                                alert('Debe elegir un nuevo docente');
                                return false;
                            }
                        },
                        success:function(dt){
                            if(dt>0){
                                $(btn).attr('lang',dt);
                                alert("Registro Correcto")
                            }else if(dt==0){
                                alert("Registro Eliminado Correctamente")
                            }else{
                                alert("Error: Intente Nuevamente")
                            }
                        }
                    });
                
    });

    $(document).on("change",".txt_user",function(){
        var val=$(this).val();
        $(this).attr('data',val);
        var txt = $("#users").find('option[value="'+val+'"]').data('user');
        $(this).val(txt);
    });        
 



</script>
    <section class="content-header">
        <h1>
            Curso {{$cursos->cur_descripcion}}
            <select name="tp" id="tp" hidden >
                <option value="0">Cultural</option>
                <option value="5">Técnico</option>
            </select>
            <input type="hidden" id="cur_id" value="{{$cursos->id}}">
            <input type="hidden" value="{{csrf_token()}}" id='token'>
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                 <table class="table">
                     <tr>
                         <th style="width:100px ">Paralelo:</th>
                         <th colspan="2">MATUTINA</th>
                         <th colspan="2">VESPERTINA</th>
                         <th colspan="2">NOCTURNA</th>
                         <th colspan="2">SEMI-PRE</th>
                     </tr>
                     <tr>
                        <td class='text-center'>A</td>
                        <td><input id="A1" value="{{$dt['umA']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='1&A' lang="{{$dt['idmA']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="A4" value="{{$dt['uvA']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='4&A' lang="{{$dt['idvA']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="A2" value="{{$dt['unA']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='2&A' lang="{{$dt['idnA']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="A3" value="{{$dt['usA']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='3&A' lang="{{$dt['idsA']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                    </tr>
                     <tr>
                        <td class='text-center'>B</td>
                        <td><input id="B1" value="{{$dt['umB']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='1&B' lang="{{$dt['idmB']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="B4" value="{{$dt['uvB']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='4&B' lang="{{$dt['idvB']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="B2" value="{{$dt['unB']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='2&B' lang="{{$dt['idnB']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="B3" value="{{$dt['usB']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='3&B' lang="{{$dt['idsB']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                    </tr>

                     <tr>
                        <td class='text-center'>C</td>
                        <td><input id="C1" value="{{$dt['umC']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='1&C' lang="{{$dt['idmC']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="C4" value="{{$dt['uvC']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='4&C' lang="{{$dt['idvC']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="C2" value="{{$dt['unC']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='2&C' lang="{{$dt['idnC']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="C3" value="{{$dt['usC']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='3&C' lang="{{$dt['idsC']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                    </tr>

                     <tr>
                        <td class='text-center'>D</td>
                        <td><input id="D1" value="{{$dt['umD']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='1&D' lang="{{$dt['idmD']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="D4" value="{{$dt['uvD']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='4&D' lang="{{$dt['idvD']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="D2" value="{{$dt['unD']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='2&D' lang="{{$dt['idnD']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="D3" value="{{$dt['usD']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='3&D' lang="{{$dt['idsD']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                    </tr>

                     <tr>
                        <td class='text-center'>E</td>
                        <td><input id="E1" value="{{$dt['umE']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='1&E' lang="{{$dt['idmE']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="E4" value="{{$dt['uvE']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='4&E' lang="{{$dt['idvE']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="E2" value="{{$dt['unE']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='2&E' lang="{{$dt['idnE']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="E3" value="{{$dt['usE']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='3&E' lang="{{$dt['idsE']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                    </tr>

                     <tr>
                        <td class='text-center'>F</td>
                        <td><input id="F1" value="{{$dt['umF']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='1&F' lang="{{$dt['idmF']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="F4" value="{{$dt['uvF']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='4&F' lang="{{$dt['idvF']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="F2" value="{{$dt['unF']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='2&F' lang="{{$dt['idnF']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="F3" value="{{$dt['usF']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='3&F' lang="{{$dt['idsF']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                    </tr>

                     <tr>
                        <td class='text-center'>G</td>
                        <td><input id="G1" value="{{$dt['umG']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='1&G' lang="{{$dt['idmG']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="G4" value="{{$dt['uvG']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='4&G' lang="{{$dt['idvG']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="G2" value="{{$dt['unG']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='2&G' lang="{{$dt['idnG']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="G3" value="{{$dt['usG']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='3&G' lang="{{$dt['idsG']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                    </tr>

                     <tr>
                        <td class='text-center'>H</td>
                        <td><input id="H1" value="{{$dt['umH']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='1&H' lang="{{$dt['idmH']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="H4" value="{{$dt['uvH']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='4&H' lang="{{$dt['idvH']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="H2" value="{{$dt['unH']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='2&H' lang="{{$dt['idnH']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>

                        <td><input id="H3" value="{{$dt['usH']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                        <td><i data='3&H' lang="{{$dt['idsH']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                    </tr>

                 </table>

                 </div>

                 <div class="row" style="padding-left:20px;width:60%" {{$hdBS}}>
                    <table border="0" class="table">
                        <tr>
                            <th colspan="6" class="text-center">BASICA-FLEXIBLE</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th class="text-center" colspan="2">NOCTURNA</th>
                            <th class="text-center" colspan="2">SEMI-PRE</th>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td><input id="ABS2" value="{{$dt['unABS']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='2&ABS' lang=" {{$dt['idnABS']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                            <td><input id="ABS3" value="{{$dt['usABS']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='3&ABS' lang=" {{$dt['idsABS']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                        </tr>
                        <tr>
                            <td>B</td>
                            <td><input id="BBS2" value="{{$dt['unBBS']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='2&BBS' lang=" {{$dt['idnBBS']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                            <td><input id="BBS3" value="{{$dt['usBBS']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='3&BBS' lang=" {{$dt['idsBBS']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                        </tr>
                        <tr>
                            <td>C</td>
                            <td><input id="CBS2" value="{{$dt['unCBS']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='2&CBS' lang=" {{$dt['idnCBS']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                            <td><input id="CBS3" value="{{$dt['usCBS']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='3&CBS' lang=" {{$dt['idsCBS']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                        </tr>
                    </table>
                 </div>

                 <div class="row" style="padding-left:20px;width:60% " {{$hdBG}}>
                    <table border="0" class="table">
                        <tr>
                            <th colspan="6" class="text-center">BGU</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th class="text-center" colspan="2">NOCTURNA</th>
                            <th class="text-center" colspan="2">SEMI-PRE</th>
                        </tr>
                        <tr>
                            <td>A</td>
                            <td><input id="ABG2" value="{{$dt['unABG']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='2&ABG' lang=" {{$dt['idnABG']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                            <td><input id="ABG3" value="{{$dt['usABG']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='3&ABG' lang=" {{$dt['idsABG']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                        </tr>
                        <tr>
                            <td>B</td>
                            <td><input id="BBG2" value="{{$dt['unBBG']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='2&BBG' lang=" {{$dt['idnBBG']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                            <td><input id="BBG3" value="{{$dt['usBBG']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='3&BBG' lang=" {{$dt['idsBBG']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                        </tr>
                        <tr>
                            <td>C</td>
                            <td><input id="CBG2" value="{{$dt['unCBG']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='2&CBG' lang=" {{$dt['idnCBG']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                            <td><input id="CBG3" value="{{$dt['usCBG']}}"  type="text"  autocomplete="off" class="form-control txt_user" list='users' placeholder="No Asignado" ></td>
                            <td><i data='3&CBG' lang=" {{$dt['idsCBG']}}" class="btn btn-primary fa fa-save btn_asg"></i></td>
                        </tr>
                    </table>
                 </div>


            </div>
        </div>
    </div>
    <datalist id="users">
        @foreach($users as $u)
        <option value="{{$u->id}}" data-user="{{$u->usu_apellidos.' '.$u->name}}">{{$u->usu_apellidos.' '.$u->name}}</option>
        @endforeach
    </datalist>
@endsection
