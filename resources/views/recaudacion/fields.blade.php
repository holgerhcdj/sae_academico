    <div class="form-group col-sm-6" hidden >
        {!! Form::label('fac_id', 'fac_id:') !!}
        {!! Form::text('fac_id', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-6"  >
        {!! Form::label('cli_ruc', 'Ruc:') !!}
        {!! Form::text('cli_ruc', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-6"  >
        {!! Form::label('cli_nombre', 'Nombre:') !!}
        {!! Form::text('cli_nombre', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-6"  >
        {!! Form::label('cli_direccion', 'Direccion:') !!}
        {!! Form::text('cli_direccion', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-6"  >
        {!! Form::label('cli_telefono', 'Telefono:') !!}
        {!! Form::text('cli_telefono', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-6"  >
    	{!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    </div>

    