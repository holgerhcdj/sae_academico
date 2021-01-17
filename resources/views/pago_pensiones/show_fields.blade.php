<script>
$(document).ready(function () {
   $('#entradafilter').keyup(function () {
      var rex = new RegExp($(this).val(), 'i');
        $('.contenidobusqueda tr').hide();
        $('.contenidobusqueda tr').filter(function () {
            return rex.test($(this).text());
        }).show();
        })
});    
</script>

<div class="row">
  <div class="col-sm-6">
      <div class="input-group "> 
        <span class="input-group-addon">BUSCAR EN LISTA</span>
        <input id="entradafilter" type="text" class="form-control">
    </div>
  </div>
  <div class="col-sm-6">
      <a href="{!! route('pagoPensiones.index') !!}" class="btn btn-warning pull-right">Regresar</a>    
  </div>
</div>
<table class="table table-responsive" id="pagoPensiones-table">
        <caption>
            
        </caption>
    <thead>
        <tr>
        <th>No</th>
        <th>Cedula</th>
        <th>Estudiante</th>
        <th>Valor Pagar</th>
        <th>Fecha Pago</th>
        <th>Valor Pagado</th>
        <th>Cod Orden</th>
        <th>Responsable</th>
        </tr>
    </thead>
    <tbody class="contenidobusqueda">
        <?php $c=1;?>
    @foreach($pagoPensiones as $pagoPensiones)
        <tr>
            <td>{{ $c++ }}</td>
            <td>{!! $pagoPensiones->est_cedula !!}</td>
            <td>{!! $pagoPensiones->est_apellidos." ".$pagoPensiones->est_nombres !!}</td>
            <td>{!! $pagoPensiones->valor !!}</td>
            <td>{!! $pagoPensiones->fecha_pago !!}</td>
            <td>{!! $pagoPensiones->vpagado !!}</td>
            <td>{!! $pagoPensiones->codigo !!}</td>
            <td>{!! $pagoPensiones->responsable !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>