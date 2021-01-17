@extends('layouts.app')
@section('content')
<?php
        $from=date('Y-m-d');
        $to=date('Y-m-d');
        if(isset($_POST['btn_search'])){
            $usu_id=$_POST['usu_id'];
        }else{
            $usu_id=0;
        }
?>
<script>
    $( window ).on( "load", function() {
        $("#usu_id").val('<?php echo $usu_id?>');
    });

    $(document).ready(function() {
  $(".sel-status").select2();
});
</script>
    <section class="content-header">
        <h1 class="pull-left">Lista de Auditoria</h1>
        <h1 class="">
            <form action="adt_search" method="POST"  accept-charset="utf-8">
                {{ csrf_field() }}
                <div class="form-group col-sm-2">
                    {!! Form::select('usu_id', $usuarios,null, ['class' => 'form-control sel-status','id'=>'usu_id']) !!}
                </div>
                <div class="form-group col-sm-2">
                    {!! Form::date('from', $from, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-sm-2">
                    {!! Form::date('to', $to, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-sm-2">
                    {!! Form::button('<i class="glyphicon glyphicon-search"></i>', ['type' => 'submit', 'name'=>'btn_search','class' => 'btn btn-primary']) !!}
                </div>

            </form>

        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('auditorias.table')
            </div>
        </div>
        <div class="text-center">
        
        </div>
    </div>
@endsection

