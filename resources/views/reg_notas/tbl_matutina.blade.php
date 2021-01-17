@foreach($cm as $c)
<div class="form-group col-sm-3">
    <button type="button" class="btn btn-success">
        <small class="materia">{{$c->mtr_descripcion ." ".$c->cur_descripcion ." ".$c->paralelo}}</small>
    </button>    

</div>
@endforeach
