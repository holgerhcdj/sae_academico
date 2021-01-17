@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Reg Disciplina
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($regDisciplina, ['route' => ['regDisciplinas.update', $regDisciplina->dsc_id], 'method' => 'patch']) !!}

                        @include('reg_disciplinas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection