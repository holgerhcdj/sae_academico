@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Horas Extras
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($horasExtras, ['route' => ['horasExtras.update', $horasExtras->heid], 'method' => 'patch']) !!}

                        @include('horas_extras.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection