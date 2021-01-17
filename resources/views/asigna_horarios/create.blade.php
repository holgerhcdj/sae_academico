@extends('layouts.app')

@section('content')
<style>
    .tbl tr td, .tbl tr th{
        padding:5px; 
    }
    .materia{
        font-weight:bolder;
        color:darkslategray; 
    }
    .curso{
        color:teal; 
    }
    .glyphicon-remove{
        color:#eee; 
    }
    .btn-xs:hover{
        background:red !important; 
    }
    #tbl_mat{
        background:#E3F9FD; 
    }
    #tbl_noc{
        background:#FEF7DD; 
    }
    #tbl_sp{
       background:#F8D1D1; 
    }
    #tbl_noc_bgu{
        background:#FEF7DD; 
    }
    #tbl_sp_bgu{
       background:#F8D1D1; 
    }
</style>

    <section class="content-header">
        <h1 style="background:#122b40;color:white;padding:5px;text-align:center;border-radius:5px;   ">
            Carga Horaria: {{$usr->name." ".$usr->usu_apellidos." "}} <spam style="color:#EEDA00 " >{{$usr->materia}}</spam>
        </h1>
    </section>

    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">

                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#madre">Horario Regular</a></li>
                  <li ><a data-toggle="tab" href="#est_familiar">BGU-INTENSIVO</a></li>
              </ul>
              <div class="tab-content">
                <div id="madre" class="tab-pane fade in active">
                    {!! Form::open(['route' => 'asignaHorarios.store']) !!}
                        @include('asigna_horarios.fields')
                    {!! Form::close() !!}
                    @if($usr->jor1==1)
                        @include('asigna_horarios.tbl_matutina')
                    @endif
                    @if($usr->jor2==1)
                        @include('asigna_horarios.tbl_noche')
                    @endif
                    @if($usr->jor3==1)
                        @include('asigna_horarios.tbl_semip')
                    @endif
                    @if($usr->jor4==1)
                        @include('asigna_horarios.tbl_vespertina')
                    @endif
                </div>
                <div id="est_familiar" class="tab-pane fade">
                    {!! Form::open(['route' => 'asignaHorarios.store']) !!}
                        @include('asigna_horarios.fields_bgu')
                    {!! Form::close() !!}

                    @include('asigna_horarios.tbl_noche_bgu')

                    @include('asigna_horarios.tbl_semip_bgu')
                </div>
            </div>


            </div>
        </div>
    </div>
@endsection
