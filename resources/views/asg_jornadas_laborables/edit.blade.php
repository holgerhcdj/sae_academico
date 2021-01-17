@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Asg Jornadas Laborables
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($asgJornadasLaborables, ['route' => ['asgJornadasLaborables.update', $asgJornadasLaborables->asg_jrl_id], 'method' => 'patch']) !!}

                        @include('asg_jornadas_laborables.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection