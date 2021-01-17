@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sms Mail
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($smsMail, ['route' => ['smsMails.update', $smsMail->sms_id], 'method' => 'patch']) !!}

                        @include('sms_mails.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection