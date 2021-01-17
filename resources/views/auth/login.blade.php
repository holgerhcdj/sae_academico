<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}"> 
        <title>SAE-VN</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{asset('css/ionicons.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/_all.css')}}">

        <script src="{{asset('js/annyang.min.js')}}"></script>



<script>
if (annyang) {
  var commands = {
    'ingresar': function() {
      $('#anl_id').val(3);
      $('#username').val('SuperAdmin');
      $('#password').val('mabelitacaiza2003');
      $('#btn_ingresar').click();
      
    }
  };
  annyang.addCommands(commands);
  annyang.start();
}
</script>


    </head>
    <body class="hold-transition login-page">
        <div class="login-box" style="padding:15px;border-radius:10px;border:solid 2px #043643;background:#fff     ">
            <div class="login-logo">
                <b>
                    <img src="img/escudo.png" width="170px;" >
                </b>
            </div>
                <p class="login-box-msg label-default" >INGRESO AL SISTEMA</p>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <form method="post" id="frm_login" action="{{ url('/login') }}" autocomplete="off" >
                    {!! csrf_field() !!}

                    <div class="form-group" >

                        <select class="form-control" name="anl_id" id="anl_id">
                            <option value="0">Año Lectivo</option>
                            @foreach($anios as $a)
                                        @if($a->anl_selected==1)
                                            <option value="{{$a->id}}" selected>{{$a->anl_descripcion}}</option>
                                        @else
                                            <option value="{{$a->id}}">{{$a->anl_descripcion}}</option>
                                        @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="{{ old('username') }}" required="" autocomplete="off" >
                        @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" autocomplete="off">
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif

                    </div>
                    <div class="row">
                            <button type="submit" id="btn_ingresar" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                    </div>
                </form>


            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->

        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/icheck.min.js')}}"></script>

        <!-- AdminLTE App -->
        <script src="{{asset('js/app.min.js')}}"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });

                $("#frm_login").submit(function(e) {
                    
                    if($("#anl_id").val()==0){
                        $("#anl_id").css("border","solid 2px brown");
                        return false;
                    }else{
                        return true;
                    }
                });

            });
        </script>
    </body>
</html>
