@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Seguimiento a {{$docente}}
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($seguimientoCapDocentes, ['route' => ['seguimientoCapDocentes.update', $seguimientoCapDocentes->segid], 'method' => 'patch', 'onsubmit'=>'return validar()']) !!}

                        @include('seguimiento_cap_docentes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection