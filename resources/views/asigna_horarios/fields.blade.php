<!-- Usu Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('usu_id', 'Usu Id:') !!}
    {!! Form::number('usu_id',null, ['class' => 'form-control']) !!}
</div>
<!-- Suc Id Field -->
<div class="form-group col-sm-6" hidden>
    {!! Form::label('suc_id', 'Suc Id:') !!}
    {!! Form::number('suc_id', 1, ['class' => 'form-control']) !!}
</div>
<!-- Tipo Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('tipo', 'Tipo:') !!}
  {!! Form::number('horas',0, ['class' => 'form-control']) !!}
</div>
<!-- Obs Field -->
<div class="form-group col-sm-3" hidden>
    {!! Form::label('obs', 'Obs:') !!}
    {!! Form::text('obs', null, ['class' => 'form-control']) !!}
</div>
<!-- ESPECIALIDAD YA SEA CULTURAL O ESPECIAL BGU O BASICA FLEXBLE -->
<div class="form-group col-sm-12" >
    <table class="table">
        <th>Tipo</th>
        <th>Jornada</th>
        <th>Día</th>
        <th>Materia</th>
        <th>Curso</th>
        <th>Paralelo</th>
        <th>Horas</th>
        <tr>
            <td>
                {!! Form::select('esp_id',['10'=>'REGULAR','8'=>'BASICA ACELERADA'],null,['class' => 'form-control']) !!}                
            </td>
            <td hidden>
                {!! Form::number('anl_id', $anl, ['class' => 'form-control']) !!}
            </td>
            <td>{!! Form::select('jor_id',$jornadas,null,['class'=>'form-control']) !!}</td>
            <td>
             {{ Form::select('dia', [
             '1' => 'LUNES',
             '2' => 'MARTES',
             '3' => 'MIERCOLES',
             '4' => 'JUEVES',
             '5' => 'VIERNES',
             '6' => 'SABADO',
             ],null,['class' => 'form-control']) }}                     
         </td>
            <td>{!! Form::select('mtr_id',$materias,null,['class'=>'form-control']) !!}</td>
            <td>{!! Form::select('cur_id',$cursos,null,['class'=>'form-control']) !!}</td>
            <td>
                {{ Form::select('paralelo', [
                'A' => 'A',
                'B' => 'B',
                'C' => 'C',
                'D' => 'D',
                'E' => 'E',
                'F' => 'F',
                'G' => 'G',
                'H' => 'H',
                'I' => 'I',
                'J' => 'J',
                ],null,['class' => 'form-control']) }}
            </td>
            <td>
             {{ Form::select('horas', [
             '1' => '1 PRIMERA',
             '2' => '2 SEGUNDA',
             '3' => '3 TERCERA',
             '4' => '4 CUARTA',
             '5' => '5 QUINTA',
             '6' => '6 SEXTA',
             '7' => '7 SEPTIMA',
             '8' => '8 OCTAVA',
             '9' => '9 NOVENA',
             '10' => '10 DECIMA',
             '11' => '11 ONCEAVA',
             '12' => '12 DOCEAVA',
             '13' => '13 TRECEAVA',
             ],null,['class' => 'form-control']) }}       
            </td>
            <td>{!! Form::submit('+', ['class' => 'btn btn-danger']) !!}</td>
        </tr>
    </table>
</div>



