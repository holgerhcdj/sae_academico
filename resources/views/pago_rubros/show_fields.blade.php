<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="{{asset('css/print_style.css')}}">
    <style>
body { width: 8.5in;height: 11in}

.mrg_salto{
    width:130%;
    margin-left:-100px;
    background: #888;
}
.cont_table{
    height: 11in;
}
/* cuando vayamos a imprimir ... */
@media print{
    *{ -webkit-print-color-adjust: exact; }
    html{ background: none; padding: 0; }
    body{ box-shadow: none; margin: 0; }
    .mrg_salto{
        display:none; 
    }
    /* indicamos el salto de pagina */
    .saltoDePagina{
        display:block;
        page-break-before:always;
    }
}
@page { margin: 0;}
</style>    
</head>
<body>
            <span><img width="50px" src="{{ asset('img/logo_institucional_sae.png') }}"></span>
        <header>
            <h3 style="padding:5px;text-align:center;">RESUMEN POR JORNADAS</h3>
            <h1>{{ $rubro[0]->rub_descripcion }} </h1>
            <label style="font-size:10px; "><?php echo "Fecha Impresión: ".date("d-m-Y H:i")?></label>
        </header>

    <div class="cont_table">
        <table width="100%">
            <thead>
                <tr>
                    <th style="font-weight:bolder;">JORNADA</th>
                    <th style="font-weight:bolder;">N_EST</th>
                    <th style="font-weight:bolder;text-align:center; ">VALOR $</th>
                </tr>
            </thead>
            <tbody>
                <?php $t=0;?>
                @foreach($prubros as $p)
                <?php $t+=$p->v?>
                <tr>
                    <td>{{$p->jor_descripcion}}</td>
                    <td>{{$p->nest}}</td>
                    <td style="text-align:right; ">{{number_format($p->v,2)}} </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"  style="text-align:right; " >Total</td>
                    <td style="text-align:right;color: brown;font-weight:bolder  " >{{ number_format($t,2) }}</td>
                </tr>
            </tfoot>

        </table>
    </div>
</body>
</html>
