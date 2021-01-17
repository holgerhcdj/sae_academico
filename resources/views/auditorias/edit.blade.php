@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Auditoria
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($auditoria, ['route' => ['auditorias.update', $auditoria->id], 'method' => 'patch']) !!}

                        @include('auditorias.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection