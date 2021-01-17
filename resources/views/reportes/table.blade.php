<style>
    div .cont{
/*        border:solid 1px red;         */
    }
    table tr th, table tr td{
        padding:5px; 
        border:solid 1px burlywood; 
    }
    table tr td{
        text-align:right; 
    }
    table tr th{
        background:teal;
        color:white; 
    }

    table{
        float:left;
        margin-left:1%; 
    }
    .total{
        background:darkgray;

    }
    .final{
        font-weight:bolder;   
    }    
</style>
<div class="form-group cont col-sm-6">
<table  class=''>
        <thead>
            <tr>
                <th colspan="10" style="text-align:center" >MATUTINA</th>
            </tr>
            <tr>
                <th></th>
                <th colspan="4">BASICA REGULAR</th>
                <th colspan="4">BACHILLERATO TÉCNICO</th>
                <th></th>
            </tr>
            <tr>
                <th>ESPECIALIDADES</th>
                <th>8vo</th>
                <th>9no</th>
                <th>10mo</th>
                <th>Total</th>
                <th>1ro</th>
                <th>2do</th>
                <th>3ro</th>
                <th>Total</th>
                <th>Total</th>
            </tr>
        </thead>
        <?php
        $t8 = 0;
        $t9 = 0;
        $t10 = 0;
        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        $t_basicog = 0;
        $t_bachg = 0;
        $t_gegm = 0;
        ?>    
        <tbody>
            @foreach ($matutina as $r)
            <?php
            $t_basico = ($r->octavo + $r->noveno + $r->decimo);
            $t_bach = ($r->primero + $r->segundo + $r->tercero);
            $t_gen = ($t_basico + $t_bach);
            $t8 = $t8 + $r->octavo;
            $t9 = $t9 + $r->noveno;
            $t10 = $t10 + $r->decimo;
            $t1 = $t1 + $r->primero;
            $t2 = $t2 + $r->segundo;
            $t3 = $t3 + $r->tercero;
            $t_basicog = $t_basicog + $t_basico;
            $t_bachg = $t_bachg + $t_bach;
            $t_gegm = $t_gegm + $t_gen;
            ?>
            <tr>
                <td style="text-align:left ">{{$r->esp}}</td>
                <td>{{$r->octavo}}</td>
                <td>{{$r->noveno}}</td>
                <td>{{$r->decimo}}</td>
                <td class="total">{{$t_basico}}</td>
                <td>{{$r->primero}}</td>
                <td>{{$r->segundo}}</td>
                <td>{{$r->tercero}}</td>
                <td class="total">{{$t_bach}}</td>
                <td class="total final">{{$t_gen}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="final">
                <td class="total">Totales</td>
                <td class="total">{{$t8}}</td>
                <td class="total">{{$t9}}</td>
                <td class="total">{{$t10}}</td>
                <td class="total">{{$t_basicog}}</td>
                <td class="total">{{$t1}}</td>
                <td class="total">{{$t2}}</td>
                <td class="total">{{$t3}}</td>
                <td class="total">{{$t_bachg}}</td>
                <td class="total" style="font-size:18px; ">{{$t_gegm}}</td>
            </tr>
        </tfoot>
</table>
</div>
<div class="form-group cont col-sm-6">
    <table  id="retirados">
        <thead>
            <tr>
                <th colspan="10" style="text-align:center" >RETIRADOS</th>
            </tr>
            <tr>
                <th>ESPECIALIDADES</th>
                <th>8vo</th>
                <th>9no</th>
                <th>10mo</th>
                <th>1ro</th>
                <th>2do</th>
                <th>3ro</th>
                <th>Total</th>
            </tr>
        </thead>
        <?php
        $t8 = 0;
        $t9 = 0;
        $t10 = 0;
        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        $tesp = 0;
        $tgm = 0;
        ?>    
        <tbody>
            @foreach ($retiradosm as $r)
            <?php
            $t8 = $t8 + $r->octavo;
            $t9 = $t9 + $r->noveno;
            $t10 = $t10 + $r->decimo;
            $t1 = $t1 + $r->primero;
            $t2 = $t2 + $r->segundo;
            $t3 = $t3 + $r->tercero;
            $tesp = ($r->octavo + $r->noveno + $r->decimo + $r->primero + $r->segundo + $r->tercero);
            $tgm = ($t8 + $t9 + $t10 + $t1 + $t2 + $t3);
            ?>
            <tr>
                <td style="text-align:left ">{{$r->esp}}</td>
                <td>{{$r->octavo}}</td>
                <td>{{$r->noveno}}</td>
                <td>{{$r->decimo}}</td>
                <td>{{$r->primero}}</td>
                <td>{{$r->segundo}}</td>
                <td>{{$r->tercero}}</td>
                <td>{{$tesp}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="final">
                <td class="total">Total</td>
                <td class="total">{{$t8}}</td>
                <td class="total">{{$t9}}</td>
                <td class="total">{{$t10}}</td>
                <td class="total">{{$t1}}</td>
                <td class="total">{{$t2}}</td>
                <td class="total">{{$t3}}</td>
                <td class="total">{{$tgm}}</td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="form-group col-sm-12"></div>
<!-- VESPERTINA -->
    <div class="form-group cont col-sm-6">
        <table  class=''>
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center" >VESPERTINA</th>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="4">BASICA REGULAR</th>
                    <th colspan="4">BACHILLERATO TÉCNICO</th>
                    <th></th>
                </tr>
                <tr>
                    <th>ESPECIALIDADES</th>
                    <th>8vo</th>
                    <th>9no</th>
                    <th>10mo</th>
                    <th>Total</th>
                    <th>1ro</th>
                    <th>2do</th>
                    <th>3ro</th>
                    <th>Total</th>
                    <th>Total</th>
                </tr>
            </thead>
            <?php
            $t8 = 0;
            $t9 = 0;
            $t10 = 0;
            $t1 = 0;
            $t2 = 0;
            $t3 = 0;
            $t_basicog = 0;
            $t_bachg = 0;
            $t_gegv = 0;
            ?>    
            <tbody>
                @foreach ($vespertina as $r)
                <?php
                $t_basico = ($r->octavo + $r->noveno + $r->decimo);
                $t_bach = ($r->primero + $r->segundo + $r->tercero);
                $t_gen = ($t_basico + $t_bach);
                $t8 = $t8 + $r->octavo;
                $t9 = $t9 + $r->noveno;
                $t10 = $t10 + $r->decimo;
                $t1 = $t1 + $r->primero;
                $t2 = $t2 + $r->segundo;
                $t3 = $t3 + $r->tercero;
                $t_basicog = $t_basicog + $t_basico;
                $t_bachg = $t_bachg + $t_bach;
                $t_gegv = $t_gegv + $t_gen;
                ?>
                <tr>
                    <td style="text-align:left ">{{$r->esp}}</td>
                    <td>{{$r->octavo}}</td>
                    <td>{{$r->noveno}}</td>
                    <td>{{$r->decimo}}</td>
                    <td class="total">{{$t_basico}}</td>
                    <td>{{$r->primero}}</td>
                    <td>{{$r->segundo}}</td>
                    <td>{{$r->tercero}}</td>
                    <td class="total">{{$t_bach}}</td>
                    <td class="total final">{{$t_gen}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="final">
                    <td class="total">Totales</td>
                    <td class="total">{{$t8}}</td>
                    <td class="total">{{$t9}}</td>
                    <td class="total">{{$t10}}</td>
                    <td class="total">{{$t_basicog}}</td>
                    <td class="total">{{$t1}}</td>
                    <td class="total">{{$t2}}</td>
                    <td class="total">{{$t3}}</td>
                    <td class="total">{{$t_bachg}}</td>
                    <td class="total" style="font-size:18px; ">{{$t_gegv}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="form-group cont col-sm-6">
        <table  id="retirados">
            <thead>
                <tr>
                    <th colspan="10" style="text-align:center" >RETIRADOS</th>
                </tr>
                <tr>
                    <th>ESPECIALIDADES</th>
                    <th>8vo</th>
                    <th>9no</th>
                    <th>10mo</th>
                    <th>1ro</th>
                    <th>2do</th>
                    <th>3ro</th>
                    <th>Total</th>
                </tr>
            </thead>
            <?php
            $t8 = 0;
            $t9 = 0;
            $t10 = 0;
            $t1 = 0;
            $t2 = 0;
            $t3 = 0;
            $tesp = 0;
            $tgv = 0;
            ?>    
            <tbody>
                @foreach ($retiradosv as $r)
                <?php
                $t8 = $t8 + $r->octavo;
                $t9 = $t9 + $r->noveno;
                $t10 = $t10 + $r->decimo;
                $t1 = $t1 + $r->primero;
                $t2 = $t2 + $r->segundo;
                $t3 = $t3 + $r->tercero;
                $tesp = ($r->octavo + $r->noveno + $r->decimo + $r->primero + $r->segundo + $r->tercero);
                $tgv = ($t8 + $t9 + $t10 + $t1 + $t2 + $t3);
                ?>
                <tr>
                    <td style="text-align:left ">{{$r->esp}}</td>
                    <td>{{$r->octavo}}</td>
                    <td>{{$r->noveno}}</td>
                    <td>{{$r->decimo}}</td>
                    <td>{{$r->primero}}</td>
                    <td>{{$r->segundo}}</td>
                    <td>{{$r->tercero}}</td>
                    <td>{{$tesp}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="final">
                    <td class="total">Total</td>
                    <td class="total">{{$t8}}</td>
                    <td class="total">{{$t9}}</td>
                    <td class="total">{{$t10}}</td>
                    <td class="total">{{$t1}}</td>
                    <td class="total">{{$t2}}</td>
                    <td class="total">{{$t3}}</td>
                    <td class="total">{{$tgv}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
<!-- NOCTURNA -->
<div class="form-group col-sm-12"></div>
<div class="form-group cont col-sm-6">
    <table  class=''>
        <thead>
            <tr>
                <th colspan="14" style="text-align:center" >NOCTURNA</th>
            </tr>
            <tr>
                <th></th>
                <th colspan="4">BASICA INTENSIVA</th>
                <th colspan="4">BACHILLERATO INTENSIVO</th>
                <th colspan="4">BACHILLERATO TÉCNICO</th>
                <th></th>
            </tr>
            <tr>
                <th>ESPECIALIDADES</th>
                <th>8vo</th>
                <th>9no</th>
                <th>10mo</th>
                <th>Total</th>
                <th>1ro</th>
                <th>2do</th>
                <th>3ro</th>
                <th>Total</th>
                <th>1ro</th>
                <th>2do</th>
                <th>3ro</th>
                <th>Total</th>
                <th>Total</th>
            </tr>
        </thead>
        <?php
        $t8 = 0;
        $t9 = 0;
        $t10 = 0;
        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        $tbi1=0;
        $tbi2=0;
        $tbi3=0;
        $t_bi_g=0;
        $t_basicog = 0;
        $t_bachg = 0;
        $t_gegn = 0;
        ?>       
        <tbody>
            @foreach ($nocturna as $r)
            <?php
            if($r->esp=="BGU"){
                $tbi1=$r->primero;
                $tbi2=$r->segundo;
                $tbi3=$r->tercero;
                $t_bi_g=($r->primero + $r->segundo + $r->tercero);
            }

            $t_basico = ($r->octavo + $r->noveno + $r->decimo);
            $t_bach = ($r->primero + $r->segundo + $r->tercero);
            $t_gen = ($t_basico + $t_bach);
            $t8 = $t8 + $r->octavo;
            $t9 = $t9 + $r->noveno;
            $t10 = $t10 + $r->decimo;
            $t1 = $t1 + $r->primero;
            $t2 = $t2 + $r->segundo;
            $t3 = $t3 + $r->tercero;
            $t_basicog = $t_basicog + $t_basico;
            $t_bachg = $t_bachg + $t_bach;
            $t_gegn = $t_gegn + $t_gen;
            ?>
            <tr>
                <td style="text-align:left ">{{$r->esp}}</td>
                <td>{{$r->octavo}}</td>
                <td>{{$r->noveno}}</td>
                <td>{{$r->decimo}}</td>
                <td class="total">{{$t_basico}}</td>

                @if($r->esp=="BGU")
                    <td>{{$r->primero}}</td>
                    <td>{{$r->segundo}}</td>
                    <td>{{$r->tercero}}</td>
                    <td class="total">{{$t_bach}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="total"></td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="total"></td>
                    <td>{{$r->primero}}</td>
                    <td>{{$r->segundo}}</td>
                    <td>{{$r->tercero}}</td>
                    <td class="total">{{$t_bach}}</td>
                @endif
                <td class="total final">{{$t_gen}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="final">
                <td class="total">Totales</td>
                <td class="total">{{$t8}}</td>
                <td class="total">{{$t9}}</td>
                <td class="total">{{$t10}}</td>
                <td class="total">{{$t_basicog}}</td>

                <td class="total">{{$tbi1}}</td>
                <td class="total">{{$tbi2}}</td>
                <td class="total">{{$tbi3}}</td>
                <td class="total">{{$t_bi_g}}</td>

                <td class="total">{{($t1-$tbi1)}}</td>
                <td class="total">{{($t2-$tbi2)}}</td>
                <td class="total">{{($t3-$tbi3)}}</td>
                <td class="total">{{($t_bachg-$t_bi_g)}}</td>

                <td class="total" style="font-size:18px; ">{{$t_gegn}}</td>
            </tr>
        </tfoot>
    </table>

</div>
<div class="form-group cont col-sm-6">
    <table  id="retirados">
        <thead>
            <tr>
                <th colspan="10" style="text-align:center" >RETIRADOS</th>
            </tr>
            <tr>
                <th>ESPECIALIDADES</th>
                <th>8vo</th>
                <th>9no</th>
                <th>10mo</th>
                <th>1ro</th>
                <th>2do</th>
                <th>3ro</th>
                <th>Total</th>
            </tr>
        </thead>
        <?php
        $t8 = 0;
        $t9 = 0;
        $t10 = 0;
        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        $tesp = 0;
        $tgn = 0;
        ?>    
        <tbody>
            @foreach ($retiradosn as $r)
            <?php
            $t8 = $t8 + $r->octavo;
            $t9 = $t9 + $r->noveno;
            $t10 = $t10 + $r->decimo;
            $t1 = $t1 + $r->primero;
            $t2 = $t2 + $r->segundo;
            $t3 = $t3 + $r->tercero;
            $tesp = ($r->octavo + $r->noveno + $r->decimo + $r->primero + $r->segundo + $r->tercero);
            $tgn = ($t8 + $t9 + $t10 + $t1 + $t2 + $t3);
            ?>
            <tr>
                <td style="text-align:left ">{{$r->esp}}</td>
                <td>{{$r->octavo}}</td>
                <td>{{$r->noveno}}</td>
                <td>{{$r->decimo}}</td>
                <td>{{$r->primero}}</td>
                <td>{{$r->segundo}}</td>
                <td>{{$r->tercero}}</td>
                <td>{{$tesp}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="final">
                <td class="total">Total</td>
                <td class="total">{{$t8}}</td>
                <td class="total">{{$t9}}</td>
                <td class="total">{{$t10}}</td>
                <td class="total">{{$t1}}</td>
                <td class="total">{{$t2}}</td>
                <td class="total">{{$t3}}</td>
                <td class="total">{{$tgn}}</td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="form-group col-sm-12"></div>
<div class="form-group cont col-sm-6">
    <table  class=''>
        <thead>
            <tr>
                <th colspan="14" style="text-align:center" >SEMI PRESENCIAL</th>
            </tr>
            <tr>
                <th></th>
                <th colspan="4">BASICA INTENSIVA</th>
                <th colspan="4">BACHILLERATO INTENSIVO</th>
                <th colspan="4">BACHILLERATO TÉCNICO</th>
                <th></th>
            </tr>
            <tr>
                <th>ESPECIALIDADES</th>
                <th>8vo</th>
                <th>9no</th>
                <th>10mo</th>
                <th>Total</th>
                <th>1ro</th>
                <th>2do</th>
                <th>3ro</th>
                <th>Total</th>
                <th>1ro</th>
                <th>2do</th>
                <th>3ro</th>
                <th>Total</th>
                <th>Total</th>
            </tr>
        </thead>
        <?php
        $t8 = 0;
        $t9 = 0;
        $t10 = 0;
        $t1 = 0;
        $t2 = 0;
        $t3 = 0;

        $tbi1 = 0;
        $tbi2 = 0;
        $tbi3 = 0;
        $t_bi_g=0;

        $t_basicog = 0;
        $t_bachg = 0;
        $t_gegd = 0;
        ?>       
        <tbody>
            @foreach ($distancia as $r)
            <?php
            if($r->esp=="BGU"){
                $tbi1=$r->primero;
                $tbi2=$r->segundo;
                $tbi3=$r->tercero;
                $t_bi_g=($r->primero + $r->segundo + $r->tercero);
            }
            $t_basico = ($r->octavo + $r->noveno + $r->decimo);
            $t_bach = ($r->primero + $r->segundo + $r->tercero);
            $t_gen = ($t_basico + $t_bach);
            $t8 = $t8 + $r->octavo;
            $t9 = $t9 + $r->noveno;
            $t10 = $t10 + $r->decimo;
            $t1 = $t1 + $r->primero;
            $t2 = $t2 + $r->segundo;
            $t3 = $t3 + $r->tercero;
            $t_basicog = $t_basicog + $t_basico;
            $t_bachg = $t_bachg + $t_bach;
            $t_gegd = $t_gegd + $t_gen;

            ?>
            <tr>
                <td style="text-align:left ">{{$r->esp}}</td>
                <td>{{$r->octavo}}</td>
                <td>{{$r->noveno}}</td>
                <td>{{$r->decimo}}</td>
                <td class="total">{{$t_basico}}</td>
                @if($r->esp=="BGU")
                    <td>{{$r->primero}}</td>
                    <td>{{$r->segundo}}</td>
                    <td>{{$r->tercero}}</td>
                    <td class="total">{{$t_bach}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="total"></td>
                @else
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="total"></td>
                    <td>{{$r->primero}}</td>
                    <td>{{$r->segundo}}</td>
                    <td>{{$r->tercero}}</td>
                    <td class="total">{{$t_bach}}</td>
                @endif
                <td class="total final">{{$t_gen}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="final">
                <td class="total">Totales</td>
                <td class="total">{{$t8}}</td>
                <td class="total">{{$t9}}</td>
                <td class="total">{{$t10}}</td>
                <td class="total">{{$t_basicog}}</td>
                <td class="total">{{$tbi1}}</td>
                <td class="total">{{$tbi2}}</td>
                <td class="total">{{$tbi3}}</td>
                <td class="total">{{$t_bi_g}}</td>
                <td class="total">{{($t1-$tbi1)}}</td>
                <td class="total">{{($t2-$tbi2)}}</td>
                <td class="total">{{($t3-$tbi3)}}</td>
                <td class="total">{{($t_bachg-$t_bi_g)}}</td>

                <td class="total" style="font-size:18px; ">{{$t_gegd}}</td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="form-group cont col-sm-6">
    <table  id="retirados">
        <thead>
            <tr>
                <th colspan="10" style="text-align:center" >RETIRADOS</th>
            </tr>
            <tr>
                <th>ESPECIALIDADES</th>
                <th>8vo</th>
                <th>9no</th>
                <th>10mo</th>
                <th>1ro</th>
                <th>2do</th>
                <th>3ro</th>
                <th>Total</th>
            </tr>
        </thead>
        <?php
        $t8 = 0;
        $t9 = 0;
        $t10 = 0;
        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        $tesp = 0;
        $tgd = 0;
        ?>    
        <tbody>
            @foreach ($retiradosd as $r)
            <?php
            $t8 = $t8 + $r->octavo;
            $t9 = $t9 + $r->noveno;
            $t10 = $t10 + $r->decimo;
            $t1 = $t1 + $r->primero;
            $t2 = $t2 + $r->segundo;
            $t3 = $t3 + $r->tercero;
            $tesp = ($r->octavo + $r->noveno + $r->decimo + $r->primero + $r->segundo + $r->tercero);
            $tgd = ($t8 + $t9 + $t10 + $t1 + $t2 + $t3);
            ?>
            <tr>
                <td style="text-align:left ">{{$r->esp}}</td>
                <td>{{$r->octavo}}</td>
                <td>{{$r->noveno}}</td>
                <td>{{$r->decimo}}</td>
                <td>{{$r->primero}}</td>
                <td>{{$r->segundo}}</td>
                <td>{{$r->tercero}}</td>
                <td>{{$tesp}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="final">
                <td class="total">Total</td>
                <td class="total">{{$t8}}</td>
                <td class="total">{{$t9}}</td>
                <td class="total">{{$t10}}</td>
                <td class="total">{{$t1}}</td>
                <td class="total">{{$t2}}</td>
                <td class="total">{{$t3}}</td>
                <td class="total">{{$tgd}}</td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="form-group col-sm-12"></div>
<div class="form-group cont col-sm-12" >
    <table  id="Totales" style="margin-left:20% ">
        <thead>
            <tr>
                <th colspan="5" style="text-align:center;">TOTALES MATRICULADOS</th>
                <th colspan="5" style="text-align:center;"></th>
            </tr>
            <tr>
                <th>Matituna</th>
                <th>Vespertina</th>
                <th>Nocturna</th>
                <th>Semi Precencial</th>
                <th>Total</th>
                <th>Retirados</th>
                <th>Inscritos</th>
                <th>Anulados</th>
                <th>Otros</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="total" style="font-weight:bolder; ">{{$t_gegm}}</td>
                <td class="total" style="font-weight:bolder; ">{{$t_gegv}}</td>
                <td class="total" style="font-weight:bolder; ">{{$t_gegn}}</td>
                <td class="total" style="font-weight:bolder; ">{{$t_gegd}}</td>
                <td class="total" style="font-weight:bolder; font-size:18px;">{{($t_gegm+$t_gegv+$t_gegn+$t_gegd)}}</td>
                <td class="total" style="font-weight:bolder; ">{{$tgm+$tgv+$tgn+$tgd}}</td>
                <?php $totros=0;?>
                @foreach($otros as $o)
                <?php
                $totros+=$o->cant;
                ?>
                <td class="total" style="font-weight:bolder; ">{{$o->cant}}</td>
                @endforeach
                <td class="total" style="font-weight:bolder; font-size:18px;  ">{{($t_gegm+$t_gegn+$t_gegd+$tgm+$tgn+$tgd+$totros)}}</td>
            </tr>        
        </tbody>

    </table>  
</div>

<div class="form-group cont col-sm-6">
<table  class=''>
        <thead>
            <tr>
                <th colspan="10" style="text-align:center" >CONSOLIDADO POR ESPECIALIDAD</th>
            </tr>
            <tr>
                <th></th>
                <th colspan="4">BASICA REGULAR</th>
                <th colspan="4">BACHILLERATO TÉCNICO</th>
                <th></th>
            </tr>
            <tr>
                <th>ESPECIALIDADES</th>
                <th>8vo</th>
                <th>9no</th>
                <th>10mo</th>
                <th>Total</th>
                <th>1ro</th>
                <th>2do</th>
                <th>3ro</th>
                <th>Total</th>
                <th>Total</th>
            </tr>
        </thead>
        <?php
        $t8 = 0;
        $t9 = 0;
        $t10 = 0;
        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        $t_basicog = 0;
        $t_bachg = 0;
        $t_gegm = 0;
        ?>    
        <tbody>
            @foreach ($consolidado as $r)
            <?php
            $t_basico = ($r->octavo + $r->noveno + $r->decimo);
            $t_bach = ($r->primero + $r->segundo + $r->tercero);
            $t_gen = ($t_basico + $t_bach);
            $t8 = $t8 + $r->octavo;
            $t9 = $t9 + $r->noveno;
            $t10 = $t10 + $r->decimo;
            $t1 = $t1 + $r->primero;
            $t2 = $t2 + $r->segundo;
            $t3 = $t3 + $r->tercero;
            $t_basicog = $t_basicog + $t_basico;
            $t_bachg = $t_bachg + $t_bach;
            $t_gegm = $t_gegm + $t_gen;
            ?>
            <tr>
                <td style="text-align:left ">{{$r->esp}}</td>
                <td>{{$r->octavo}}</td>
                <td>{{$r->noveno}}</td>
                <td>{{$r->decimo}}</td>
                <td class="total">{{$t_basico}}</td>
                <td>{{$r->primero}}</td>
                <td>{{$r->segundo}}</td>
                <td>{{$r->tercero}}</td>
                <td class="total">{{$t_bach}}</td>
                <td class="total final">{{$t_gen}}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="final">
                <td class="total">Totales</td>
                <td class="total">{{$t8}}</td>
                <td class="total">{{$t9}}</td>
                <td class="total">{{$t10}}</td>
                <td class="total">{{$t_basicog}}</td>
                <td class="total">{{$t1}}</td>
                <td class="total">{{$t2}}</td>
                <td class="total">{{$t3}}</td>
                <td class="total">{{$t_bachg}}</td>
                <td class="total" style="font-size:18px; ">{{$t_gegm}}</td>
            </tr>
        </tfoot>
</table>
</div>


<div class="form-group cont col-sm-6">
    <table  id="noasignados">
        <thead>
            <tr>
                <th colspan="2">Sin Asignar Paralelos</th>
            </tr>
            <tr>
                <th>Cultural</th>
                <th>Tecnico</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $nasignados[0] ?></td>
                <td><?php echo $nasignados[1] ?></td>
            </tr>        
        </tbody>
    </table>
</div>