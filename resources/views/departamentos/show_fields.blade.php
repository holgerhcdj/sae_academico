<script>
    $(document).on("click","input[name=especial]",function(){
        if($(this).prop('checked')==true){
            vl=true;
        }else{
            vl=false;
        }
            $('input[name=new]').prop('checked',vl);
            $('input[name=edit]').prop('checked',vl);
            $('input[name=del]').prop('checked',vl);
            $('input[name=show]').prop('checked',vl);
    }); 
    $(document).on("click","#btn_actualiza_perfiles",function(){
        var ps=prompt("Clave de Autorizacion");

                //         Swal.fire({
                //           title: 'Submit your Github username',
                //           input: 'text',
                //           inputAttributes: {
                //             autocapitalize: 'off'
                //         },
                //         showCancelButton: true,
                //         confirmButtonText: 'Look up',
                //         showLoaderOnConfirm: true,
                //         preConfirm: (login) => {

                //             return fetch(`//api.github.com/users/${login}`)
                //             .then(response => {
                //                 if (!response.ok) {
                //                   throw new Error(response.statusText)
                //               }
                //               return response.json()
                //           })
                //             .catch(error => {
                //                 Swal.showValidationMessage(
                //                   `Request failed: ${error}`
                //                   )
                //             })
                //         }
                //         ,
                //         allowOutsideClick: () => !Swal.isLoading()
                //     }).then((result) => {
                //       if (result.value) {
                //         Swal.fire({
                //           title: `${result.value.login}'s avatar`,
                //           imageUrl: result.value.avatar_url
                //       })
                //     }
                // })


        if(ps=='<?php echo $pas?>'){
             var url=window.location;
             var token=$("input[name=_token]").val();
             var dep_id=$("#departamento_id").val();
             $.ajax({
                url: url+'/actualizar_perfiles',
                headers:{'X-CSRF-TOKEN':token},
                type: 'POST',
                dataType: 'json',
                data: {'dep':dep_id},
                beforeSend:function(){
                },
                success:function(dt){
                    if(dt==0){

                        Swal.fire({
                            type: 'success',
                          title: 'ACTUALIZACIÓN CORRECTA',
                          text: 'LOS DATOS FUERON ACTUALIZADOS CORRECTAMENTE'
                      })

                        //alert("Actualizacion Correcta");
                    }else{
                        Swal.fire({
                            type: 'danger',
                          title: 'ACTUALIZACIÓN INCORRECTA',
                          text: 'Algún problema sucedió al realizar la acción'
                      })
                    }
                }
            })
        }else{
            //alert('Calve incorrecta');
                        Swal.fire({
                            type: 'danger',
                          title: 'CLAVE INCORRECTA',
                          text: 'Clave Incorrecta'
                      })            
        }


    })
</script>
    <i class="btn btn-warning fa fa-warning" id='btn_actualiza_perfiles' style="float:right; "> Actualizar perfiles de los Usuarios</i>

<table class="table" style="width:50%; ">
    <thead>
        <tr>
            <th>No</th>
            <th>Modulo</th>
            <th>Total</th>
            <th>Agregar</th>
            <th>Editar</th>
            <th>Eliminar</th>
            <th>Ver</th>
            <th>...</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            {!! Form::open(['route' => 'departamentos.store','id'=>'frm_asigna_permisos']) !!}
            <td>
                <input type="hidden" name="departamento_id" id="departamento_id" value="{!! $departamentos->id !!}" />
            </td>
            <td>
                <select name="mod_id" id="mod_id" class="form-control">
                    <option value="0">Todos</option>
                    @foreach($modulos as $m)
                    <option value="{{$m->id}}">{{$m->menu.' / '}} {{$m->submenu}}</option>
                    @endforeach
                </select>
            </td>
            <td class="text-center">
                {{ Form::checkbox('especial', 1, false) }}
            </td>
            <td class="text-center">
                {{ Form::checkbox('new', 1, false) }}
            </td>
            <td class="text-center">
                {{ Form::checkbox('edit', 1, false) }}
            </td>
            <td class="text-center">
                {{ Form::checkbox('del', 1, false) }}
            </td>
            <td class="text-center">
                {{ Form::checkbox('show', 1, false) }}
            </td>

            <td align='center'>
                {!! Form::submit('+', ['class' => 'btn btn-primary','id'=>'btn_add']) !!}
            </td>
            {!! Form::close() !!}   
        </tr>
        <?php
        $n = 1;
        ?>
        @foreach($permisos as $p)
        <tr>
            <td>{{$n++}}</td>
            <td>{{$p->menu }} {{'/'}} {{$p->submenu}}</td>
            <td align='center'>
                @if($p->especial==1)
                {{'x'}}
                @else    
                {{'-'}}
                @endif
            </td>
            <td align='center'>
                @if($p->new==1)
                {{'x'}}
                @else    
                {{'-'}}
                @endif
            </td>
            <td align='center'>
                @if($p->edit==1)
                {{'x'}}
                @else    
                {{'-'}}
                @endif
            </td>
            <td align='center'>
                @if($p->del==1)
                {{'x'}}
                @else    
                {{'-'}}
                @endif
            </td>
            <td align='center'>
                @if($p->show==1)
                {{'x'}}
                @else    
                {{'-'}}
                @endif
            </td>
            <td>
            {!! Form::open(['route' => ['departamentos.destroy',$p->id], 'method' => 'delete']) !!}
            <div class='btn-group'>
                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Desea Eliminar el Item?')"]) !!}
            </div>
            {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

