@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Enc Grupos
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($encGrupos, ['route' => ['encGrupos.update', $encGrupos->grp_id], 'method' => 'patch']) !!}

                        @include('enc_grupos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection