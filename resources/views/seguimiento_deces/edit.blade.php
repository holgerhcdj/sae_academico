@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Seguimiento Dece
        </h1>
   </section>
   <form action="seguimientoAccionesDeces.destroy" method="POST" id="frm_elimina_accdece">
     {{csrf_field()}}
     <input type="hidden" name="accid" id="accid" value="">
   </form>

   <script>
     $(document).on("click",".btn_eliminar", function(){
       accid=$(this).attr('data');
       $("#accid").val(accid);
       $("#frm_elimina_accdece").submit();
     })
   </script>

   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($seguimientoDece, ['route' => ['seguimientoDeces.update', $seguimientoDece->segid], 'method' => 'patch', 'onsubmit'=>'return validar()']) !!}

                        @include('seguimiento_deces.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection