@extends('layouts.app')

@section('content')
<script>
    $(document).on("change","select[name=jor_id],select[name=esp_id]",function() {
        
        
    })
</script>
    <section class="content-header">
        <h1 class="text-center bg-primary">Registrar Asistencia</h1>
        <table>
            <td hidden id='td_perid'>
                {!! Form::select('per_id',$per,null,['class'=>'form-control']) !!}    
            </td>
            <td hidden>
                {!! Form::text('anl_id',$anl,null,['class'=>'form-control']) !!}    
            </td>
            <td>
                {!! Form::select('jor_id',$jor,null,['class'=>'form-control']) !!}    
            </td>
            <td>
                {!! Form::select('esp_id',$esp,null,['class'=>'form-control']) !!}    
            </td>
            <td>
                {!! Form::select('cur_id',$cur,null,['class'=>'form-control']) !!}    
            </td>
            <td>
                {!! Form::select('mtr_id',$mtr,null,['class'=>'form-control','id'=>'mtr_id']) !!}    
            </td>            
            <td>
                {!! Form::select('par_id',[
                'A'=>'A',
                'B'=>'B',
                'D'=>'D',
                'E'=>'E',
                'F'=>'F',
                'G'=>'G',
                'H'=>'H',
                'I'=>'I',
                'J'=>'J',
                ],null,['class'=>'form-control','id'=>'mtr_id']) !!}    
            </td>            

            <td>
                <button class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>

            </td>
        </table>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'asistencias.store']) !!}
                        @include('asistencias.fields')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
