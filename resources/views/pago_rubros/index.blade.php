@extends('layouts.app')

@section('content')
<script>
    $(function(){
        $("#lbl_total").text("Recaudado: "+$("#th_total").text()+" $");
    })
    $(document).on("click",".chk_excluir",function(){
        var obj=this;
        var matid=this.id;
        var rbid=$("#rub_id").val();
        var url=window.location;
        var token=$("#_token").val();
        var pgid=$(obj).attr("lang");
        if($(this).prop("checked")==true){
        var op=1;//Si excluye    
        }else{
        var op=0;//No excluye    
        }

        $.ajax({
            url: url+'/excluye_pago',
            headers:{'X-CSRF-TOKEN':token},
            type: 'POST',
            dataType: 'json',
            data: {'matid':matid,'rbid':rbid,'op':op,'pgid':pgid},
            beforeSend:function(){

            },
            success:function(dt){
                $(obj).attr('lang',dt);
            }
        })        


    })
</script>
    <section class="content-header">
        <div class="row">
            <h4 class="col-sm-12 bg-primary text-center">Pagos de {{$rubro[0]->rub_descripcion}}
            </h4>
        </div>
            <form action="pagoRubros.index" method="POST" >
                <input type="hidden" name="_token" id="_token" value="{{ csrf_token()}}">
                <input type="hidden" name="rub_id" id="rub_id" value="{{ $rubro[0]->rub_id }}" />
                <div class="form-group col-sm-2">
                    {!! Form::label('jor_id', 'Jornada:') !!}
                    {!! Form::select('jor_id',$jor,null,['class'=>'form-control']) !!}    
                </div>                

                <div class="form-group col-sm-2">
                    {!! Form::label('esp_id', 'Jornada:') !!}
                    {!! Form::select('esp_id',['10'=>'Cultural','7'=>'BGU'],null,['class'=>'form-control']) !!}    
                </div>                

                <div class="form-group col-sm-2">
                    {!! Form::label('cur_id', 'Curso:') !!}
                    {!! Form::select('cur_id',$cur,null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group col-sm-2">
                    {!! Form::label('par_id', 'Paralelo:') !!}
                    {!! Form::select('par_id',[
                '0'=>'Todos',
                'A'=>'A',
                'B'=>'B',
                'C'=>'C',
                'D'=>'D',
                'E'=>'E',
                'F'=>'F',
                'G'=>'G',
                'H'=>'H',
                'I'=>'I'],null,['class'=>'form-control']) !!}    
                </div>
                <div class="input-group col-sm-2">
                    <button style="margin-top:25px" class="btn btn-warning" value="search" type="submit" name="search" >
                        <i class="fa fa-search"></i>
                    </button>
                </div>

                <div class="input-group col-sm-2">
                    <button style="margin-top:-55px;margin-left:50px " class="btn btn-primary" value="search_impr" type="submit" name="search_impr" >
                        <i class="fa fa-print"></i>
                    </button>
                </div>
            </form>
            <h4>
                <label id="lbl_total" class="pull-right text-danger" style="margin-top:-40px; " ></label>
            </h4>
    </section>
    <div class="content" style="margin-top:-20px">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body" >
                    @include('pago_rubros.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

