@if($qm=='Q1' || $qm=='Q2')
    @include("reportes.cuadros_culturales_excelqm");
@else
    @include("reportes.cuadros_culturales_excelfinal");
@endif