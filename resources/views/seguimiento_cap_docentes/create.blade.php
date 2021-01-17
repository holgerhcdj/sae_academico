@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Seguimiento a {{$docente}}
        </h1>
    </section>
    <script>
        $(function(){
            $('input[name=usu_id2]').val('<?php echo $docid ?>');
        })
    </script>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'seguimientoCapDocentes.store','onsubmit'=>'return validar()']) !!}

                        @include('seguimiento_cap_docentes.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
