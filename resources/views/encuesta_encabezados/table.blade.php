<script>
// $(window).load(function() {
//    Swal.showLoading();
// });
$(document).on("click",".btn_report",function(){
    //Swal.showLoading();
let timerInterval
Swal.fire({
  title: 'Cargando...',
  html: 'Espere porfavor..',
  timer: 20000,
  timerProgressBar: true,
  onBeforeOpen: () => {
    Swal.showLoading()
    timerInterval = setInterval(() => {
      const content = Swal.getContent()
      if (content) {
        const b = content.querySelector('b')
        if (b) {
          b.textContent = Swal.getTimerLeft()
        }
      }
    }, 100)
  },
  onClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  /* Read more about handling dismissals below */
  if (result.dismiss === Swal.DismissReason.timer) {
    console.log('I was closed by the timer')
  }

})

})

</script>

<table class="table table-responsive" id="encuestaEncabezados-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Descripcion</th>
            <th>Para:</th>
            <th>F.Reg</th>
            <th>Estado</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($encuesta as $enc)
        <tr>
            <td>1</td>
            <td>{!! $enc->ecb_descripcion !!}</td>
            <td>
                @if($enc->ecb_tipo==0)
                {{'Estudiantes'}}
                @else
                {{'Docentes'}}
                @endif                
            </td>
            <td>{!! $enc->ecb_freg !!}</td>
            <td>
                @if($enc->ecb_estado==0)
                {{'Activo'}}
                @else
                {{'--'}}
                @endif                
            </td>

            <td>
                <div class='btn-group' title="Lista de Preguntas">
                    <a href="{!! route('encuestaEncabezados.edit', [$enc->ecb_id]) !!}" class='btn btn-info btn-xs' ><i class="fa fa-list-ul"> Preguntas</i></a>
                    <a href="{!! route('encuestaEncabezados.show', [$enc->ecb_id]) !!}" class='btn btn-success btn-xs btn_report' style="margin-left:5px " ><i class="fa fa-bar-chart"> Reporte</i></a>
                </div>
<!--                 {!! Form::open(['route' => ['encuestaEncabezados.destroy', $enc->ecb_id], 'method' => 'delete']) !!}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs','onclick' => "return confirm('Are you sure?')"]) !!}
                {!! Form::close() !!}
 -->            </td>
        </tr>
    @endforeach
    </tbody>
</table>