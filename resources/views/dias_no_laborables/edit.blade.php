@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Dias No Laborables
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($diasNoLaborables, ['route' => ['diasNoLaborables.update', $diasNoLaborables->dnlid], 'method' => 'patch']) !!}

                        @include('dias_no_laborables.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection