@extends('layouts.app')

@section('content')
<style>
    table tr td{
        padding:2px;
        border: solid 1px;
    }
</style>

    <section class="content-header">
        <h1>
            Estudiantes Cedula Erronea
        </h1>
                
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
               @include('flash::message')
            <div class="box-body">
                <div class="row">
                    <table>
                        <tbody>
                            <?php $x=1;?>
                            @foreach ($resultado as $r)
                            <tr>
                                <td>{{$x++}}</td>
                                <td>{{$r}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
