@extends('layouts.app')
@section('content')
<?php
$today=date('Y-m-d');
?>
    <section class="content-header">
        <h1>
            Tareas y Actividades
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">

<link href="{{asset('packages/core/main.css')}}" rel='stylesheet' />
<link href="{{asset('packages/daygrid/main.css')}}" rel='stylesheet' />
<link href="{{asset('packages/timegrid/main.css')}}" rel='stylesheet' />

<script src="{{asset('packages/core/main.js')}}"></script>
<script src="{{asset('packages/interaction/main.js')}}"></script>
<script src="{{asset('packages/daygrid/main.js')}}"></script>
<script src="{{asset('packages/timegrid/main.js')}}"></script>

<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
      locale:'es',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },

      defaultDate: '{{$today}}',
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      select: function(arg) {

        $("#btn_modal_tareas").click();

        //var title = prompt('Event Title:');
        // if (title) {
        //   calendar.addEvent({
        //     title: title,
        //     start: arg.start,
        //     end: arg.end,
        //     allDay: arg.allDay
        //   })
        // }
        calendar.unselect()

      },
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
        {
          title: 'Prueba',
          start: '2020-03-15'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2020-04-15'
        }
      ],
      eventClick: function(arg) {
        if (confirm('Eliminar tarea?')) {
          arg.event.remove()
        }
      }      
    });

    calendar.render();
  });

</script>
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

  .label{
    font-weight:border; 
  }

</style>

  <div id='calendar'></div>
               </div>
           </div>
       </div>
   </div>

<!-- VENTANA MODAL -->

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" id="btn_modal_tareas" data-toggle="modal" data-target="#modal_tareas" hidden  >
  modal
</button>

<!-- Modal -->
<div class="modal fade" id="modal_tareas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title bg-primary text-center" id="exampleModalLabel">
          Nueva Tarea
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </h5>
      </div>
      <div class="modal-body">

        <div class="col-md-3">
          {!! Form::select('jor_id',$jor,null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4">
          {!! Form::select('esp_id',$esp,null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-3">
          {!! Form::select('cur_id',$cur,null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-2">
          {!! Form::select('paralelo',['A'=>'A','B'=>'B','C'=>'C','D'=>'D','E'=>'E','F'=>'F','G'=>'G','H'=>'H',],null, ['class' => 'form-control']) !!}
        </div>
<div class='row'>
  <hr size="20">
</div>
        <div class="form-group col-sm-12">
          <div class="input-group">
            {!! Form::label('tar_tipo', 'Tipo de Actividad:',['class'=>'input-group-addon']) !!}
            {!! Form::select('tar_tipo',['0'=>'Tarea','1'=>'Cuestionario','2'=>'Evaluación',],null, ['class' => 'form-control']) !!}
          </div>
        </div>
        <div class="col-md-12">
          {!! Form::text('tar_titulo',null, ['class' => 'form-control','placeholder'=>'Título de la tarea']) !!}
        </div>
        <div class="col-md-12">
          {!! Form::textarea('tar_descripción',null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-12">
          {!! Form::file('tar_adjunto',null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-12">
          <div class="input-group">
            {!! Form::label('tar_finicio', 'Inicia:',['class'=>'input-group-addon']) !!}
            {!! Form::date('tar_finicio',null, ['class' => 'form-control ']) !!}
            {!! Form::label('tar_hinicio', 'Hora:',['class'=>'input-group-addon']) !!}
            {!! Form::select('tar_hinicio',[
            '07'=>'07',
            '08'=>'08',
            '09'=>'09',
            '10'=>'10',
            '11'=>'11',
            '12'=>'12',
            '13'=>'13',
            '14'=>'14',
            '15'=>'15',
            '16'=>'16',
            '17'=>'17',
            '18'=>'18',
            '19'=>'19',
            '20'=>'20',
            '21'=>'21',
            '22'=>'22',
            '23'=>'23',
            ],null, ['class' => 'form-control ']) !!}
            {!! Form::label('tar_minini', ':',['class'=>'input-group-addon']) !!}
            {!! Form::select('tar_minini',[
            '00'=>'00',
            '15'=>'15',
            '30'=>'30',
            '45'=>'45',
            ],null, ['class' => 'form-control ']) !!}

          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="input-group">
            {!! Form::label('tar_ffin', 'Finaliza:',['class'=>'input-group-addon']) !!}
            {!! Form::date('tar_ffin',null, ['class' => 'form-control ']) !!}
            {!! Form::label('tar_hfin', 'Hora:',['class'=>'input-group-addon']) !!}
            {!! Form::select('tar_hfin',[
            '07'=>'07',
            '08'=>'08',
            '09'=>'09',
            '10'=>'10',
            '11'=>'11',
            '12'=>'12',
            '13'=>'13',
            '14'=>'14',
            '15'=>'15',
            '16'=>'16',
            '17'=>'17',
            '18'=>'18',
            '19'=>'19',
            '20'=>'20',
            '21'=>'21',
            '22'=>'22',
            '23'=>'23',
            ],null, ['class' => 'form-control ']) !!}
            {!! Form::label('tar_minfin', ':',['class'=>'input-group-addon']) !!}
            {!! Form::select('tar_minfin',[
            '00'=>'00',
            '15'=>'15',
            '30'=>'30',
            '45'=>'45',
            ],null, ['class' => 'form-control ']) !!}

          </div>
        </div>
        <div class="col-md-4">
          {!! Form::select('tar_estado',['0'=>'Activo','1'=>'InActivo',],null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-8">

      </div>
      <br>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left">Guardar</button>
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

@endsection