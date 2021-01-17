<?php

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SAE-VN</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">    

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!--         <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"> -->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/ionicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/_all.css')}}">

        <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker3.css')}}">
<!--         <script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
        <script src="{{asset('js/bootstrap-datepicker.es.min.js')}}"></script>
 -->        <script type="text/javascript" src="{{asset('chart.js/Chart.js')}}" ></script>        
        <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.css')}}">
        <link rel="stylesheet" href="{{asset('css/personal_style.css')}}">
        <link rel="stylesheet" href="{{asset('sweetalert/dist/sweetalert2.min.css')}}">
        <script src="{{asset('sweetalert/dist/sweetalert2.all.min.js')}}"></script>
<!--         <script src="{{asset('js/annyang.min.js')}}"></script> -->
        <script src="{{asset('js/jquery.min.js')}}"></script>
<!--         <script src="{{asset('js/jquery-1.11.3.min.js')}}"></script> -->

<!--<script src="{{asset('js/jquery.ba-throttle-debounce.min.js')}} "></script>
    <script src="{{asset('js/jquery.stickyheader.js')}} "></script>
    <script src="{{asset('js/contextmenu.js')}}"></script>  -->

<script>
/*
        if (annyang) {
          var commands = {
            'mami': function() {
              $('#logout-form').submit();
            }
          };
          annyang.addCommands(commands);
          annyang.start();
        }
*/
</script>



        @yield('css')
    </head>
<style>
    .treeview{
        /*background:#fff; 
        color:#000;*/    
    }
    .navbar-static-top,.logo{
/*        background:#008bbc !important; /*Azul*/
/*        background:#34a6ed !important; /*Azul Claro*/
        background:#043643 !important; /*Azul Obscuro*/
/*        background:#75c3ad !important;  /*Verde Claro*/
/*        background:#4d5d6d !important;/*Azul Obscuro 2*/ 
/*        background:#eb5309 !important;/*Tomate*/ 
/*        background:#3e3f3a !important;/*Gris Obscuro*/ 
/*        background:#ed6761 !important; /*Rosado Claro*/

/*        background:#3e979f !important; /*Aqua*/
/*        background:#a8412b !important; /*Brown*/

    }
</style>

<div class="modal" tabindex="-1" role="dialog" id="modal_bgu">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-center text-bold bg-primary">
          <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </h4>
      </div>
      <div class="modal-body">
        <table id="tbl_bgu" class="table table-hover">

        </table>
      </div>
      <div class="modal-footer">
        <button type="button" name="" class="btn btn-danger pull-right" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

                <?php 
                $cls_anio='skin-blue';
                $sms_anio="";
                if(Session::get('anio')!='2020-2021'){
                    $cls_anio='skin-red ';
                    $sms_anio="<h1 class='alert alert-danger' >Cuidado!!! Este año lectivo no es el actual</h1>";
                }
                ?>

    <body class="{{$cls_anio}} sidebar-mini">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">
                <b class="logo" style="font-weight:bolder; ">
                    {{Session::get('anio')}}
                </b>
                <nav class="navbar navbar-static-top p-0" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"></a>
                    <div style="margin-top:10px;" class="text-center">
                        <span class="label label-default" style="font-size:14px " >
                            {{Session::get('periodo_descripcion')}}
                            <i class="btn btn-primary btn-xs fa fa-exchange" id="btn_modal_bgu"  data-toggle="modal" data-target="#modal_bgu" ></i>
                        </span>               
                        <span class="label label-danger"  >SOPORTE ( 0999255331 Holger Caiza )</span>
                    </div>
                    <div class="navbar-custom-menu" style="margin-top:-40px ">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{asset('img/escudo.png')}}"
                                         class="user-image" alt="User Image"/>
                                    <span class="hidden-xs">
                                        {!! Auth::user()->username !!}
                                    </span>
                                </a>

                                <ul class="dropdown-menu">

                                    <li class="user-header">
                                        <img src="{{asset('img/escudo.png')}}" class="img-circle" alt="User Image"/>
                                        <p>
                                            {!! Auth::user()->name." ".Auth::user()->usu_apellidos !!}
                                            <small>Registrado desde {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a title="Editar Perfil" href="{!! route('usuarios.edit',[Auth::user()->id,'op'=>1]) !!}" class='btn btn-default btn-flat'><i class='glyphicon glyphicon-user text-blue' ></i></a>
                                        </div>
                                        <div class="pull-left" style="margin-left:25%; ">
                                            <a title="Cambiar Contraseña" href="{!! route('usuarios.edit',[Auth::user()->id,'op'=>2]) !!}" class='btn btn-default btn-flat'><i class='glyphicon glyphicon-lock text-yellow'  ></i></a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{!! url('/logout') !!}" title="Salir del Sistema" class="btn btn-default btn-flat"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class='glyphicon glyphicon-off text-red' ></i>
                                            </a>
                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                                  style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </li>
                                    
                                </ul>

                            </li>
                        </ul>
                    </div>

                </nav>

            </header>

            <!-- Left side column. contains the logo and sidebar -->
            @include('layouts.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                {!!$sms_anio!!}
                @yield('content')
                
            </div>

            <!-- Main Footer -->
            <footer class="main-footer" style="max-height: 100px;text-align: center">
                <strong>Copyright © 2017-{{date('Y')}} <a href="#" target="_blank">GRUPO G-BYTE-</a>.</strong> All rights reserved.
            </footer>

        </div>
{{csrf_field()}}
        <!-- jQuery 3.1.1 -->
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/select2.min.js')}}"></script>
        <script src="{{asset('js/icheck.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('js/app.min.js')}}"></script>
        <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
        @yield('scripts')
        <script>
            $(function () {
            })
            $(document).on("click","#btn_modal_bgu",function(){
                     var token=$("input[name=_token]").val();
                     var op=0;
                    $.ajax({
                        url: 'periodos_bgu',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {op:op},
                        beforeSend:function(){

                        },
                        success:function(dt){
                            $("#tbl_bgu").html(dt);
                        }
                    })
            })

            $(document).on("click",".rd_periodo",function(){
                     var token=$("input[name=_token]").val();
                     var vl=$(this).attr('data');
                    $.ajax({
                        url: 'cambia_periodos_bgu',
                        headers:{'X-CSRF-TOKEN':token},
                        type: 'POST',
                        dataType: 'json',
                        data: {vl:vl},
                        beforeSend:function(){

                        },
                        success:function(dt){
                            if(dt==0){
                                location.reload();
                            }
                        }
                    })
            })
        </script>
    </body>
</html>
