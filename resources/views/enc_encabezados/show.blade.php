@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Enc Encabezado
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <table class="table">
                        <tr>
                            <th>PREGUNTAS</th>
                        </tr>
                        <tr>
                            <th>Num</th>
                            <th>Grupo</th>
                            <th>Pregunta</th>
                            <th></th>
                        </tr>
                        <form action="grabar_preguntas" method="POST">
                            {{csrf_field()}}
                            {!! Form::hidden('enc_id',$encEncabezado->enc_id, ['class' => 'form-control']) !!}
                        <tr>
                            <th></th>
                            <th>
                                {!! Form::select('grp_id',$grupos,null, ['class' => 'form-control']) !!}
                            </th>
                            <th>
                                {!! Form::text('prg_pregunta',null, ['class' => 'form-control']) !!}
                            </th>
                            <th>
                                <button class="btn btn-primary" name="btn_grabar" value="btn_grabar">Agregar</button>
                            </th>
                        </tr>   
                        </form>
                        <tbody>
                            <?php $x=1;?>
                            @foreach($preg as $p)
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$p->grp_descripcion}}</td>
                                <td>{{$p->prg_pregunta}}</td>
                                <td>
                                    <form action="eliminar_preguntas" method="POST">
                                        {{csrf_field()}}
                                        {!! Form::hidden('prg_id',$p->prg_id, ['class' => 'form-control']) !!}
                                        {!! Form::hidden('enc_id',$p->enc_id, ['class' => 'form-control']) !!}
                                        <button class="btn btn-danger btn-xs" name="btn_del" value="btn_del">X</button>
                                        
                                    </form>
                                        
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{!! route('encEncabezados.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
