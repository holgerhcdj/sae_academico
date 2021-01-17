<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SAE</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <script src="{{asset('js/annyang.min.js')}}"></script>

<script>
if (annyang) {
  var commands = {
    'nuevo': function() {
      $('#ingreso').click();
    }
  };
  annyang.addCommands(commands);
  annyang.start();
}
</script>

        <style>
            html, body {
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                top: 180px;
                text-align:center;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height" >
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}"  >Home</a>
                    @else
                        <a href="{{ url('/login') }}" id="ingreso" class="text-danger" ><i class="btn btn-primary">INGRESAR AL SISTEMA</i></a>
                        <!-- <a href="{{ url('/register') }}">Register</a> -->
                    @endif
                </div>
            @endif

            <div class="content" style="border:solid 2px #ccc;padding:20px;border-radius:10px; "  >
                <div class="title m-b-md">
                    <img src="{{asset('img/colegio.png')}}" width="100px"> 
                    <img src="{{asset('img/logo_institucional_sae.png')}}" width="350px"> 
                </div>
            </div>
        </div>
    </body>
</html>

