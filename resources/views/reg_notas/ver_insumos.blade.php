@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Reg Notas
        </h1>
   </section>
   <style type="text/css">
     #tbl_insumos tr td{
      padding:2px 0px 0px 2px;
      text-align:center;  
      border:solid 1px #ccc;   
     }
     #tbl_insumos tr th{
      padding:5px 15px 5px 15px;
      text-align:center;
      border:solid 1px #ccc;   
     }
     *{
      font-size:12px;  
     }
     .rotate_tx{
      writing-mode: vertical-lr;
      transform: rotate(180deg);
      padding: 5px 0px 5px 0px;/*top right boottom left*/
    }     
  </style>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">

          <table id="tbl_insumos" >
            <thead class="bg-info">
              <tr>
                <th>#</th>
                <th>Estudiante</th>
                <th class="rotate_tx">Insumo 1</th>
                <th class="rotate_tx">Insumo 2</th>
                <th class="rotate_tx">Insumo 3</th>
                <th class="rotate_tx">Insumo 4</th>
                <th class="rotate_tx">Insumo 5</th>
                <th class="rotate_tx">Insumo 6</th>
              </thead>
              <tbody>
                <?php $x=1?>
                @foreach($notas as $n)
                <tr>
                  <td>{{$x++}}</td>
                  <td style="text-align:left; ">{!! $n->est !!}</td>
                  <td>{!! $n->i1 !!}</td>
                  <td>{!! $n->i2 !!}</td>
                  <td>{!! $n->i3 !!}</td>
                  <td>{!! $n->i4 !!}</td>
                  <td>{!! $n->i5 !!}</td>
                  <td>{!! $n->i6 !!}</td>
                </tr>
                @endforeach
              </tbody>
            </table>

               </div>
           </div>

       </div>
   </div>
@endsection