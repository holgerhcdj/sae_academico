<script>
    $(document).on("click",".btn_ticket",function(){
         var url=window.location;
         var pro_id=$(this).attr('data');
         $("#frm_ticket").attr('src',url+'/'+pro_id);
        $("#btn_modal").click();
        
    })
</script>


<button type="button" style="visibility:hidden " class="btn btn-primary"  data-toggle="modal" id="btn_modal" data-target=".bd-example-modal-sm">Large modal</button>

<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

        <iframe src=""  id="frm_ticket" style="width:400px;height:400px;  " frameborder="0"></iframe>

    </div>
  </div>
</div>



<table class="table table-responsive" id="productos-table">
    <thead>
        <tr>
        <th>#</th>
        <th>Laboratorio/Actual</th>
        <th>Codigo</th>
        <th>Descripcion</th>
        <th>Marca</th>
        <th>Serie</th>
        <th>Estado</th>
            <th colspan="3">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $x=1;
         ?>
    @foreach($productos as $productos)
        <tr>
            <td>{{$x++}}</td>
            <td>{!! $productos->division !!}</td>
            <td>{!! $productos->pro_codigo !!}</td>
            <td>{!! $productos->pro_descripcion !!}</td>
            <td>{!! $productos->pro_marca !!}</td>
            <td>{!! $productos->pro_serie !!}</td>
            <td>@if($productos->estado==0)
                {{'Activo'}}
                @elseif($productos->estado==1)
                {{'Inactivo'}}   
                @endif</td>
            <td>
                {!! Form::open(['route' => ['productos.destroy', $productos->proid], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <i data="{{$productos->proid}}" class='btn btn-default btn-xs btn_ticket glyphicon glyphicon-barcode' ></i>
                    <a href="{!! route('productos.edit', [$productos->proid]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-pencil"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>