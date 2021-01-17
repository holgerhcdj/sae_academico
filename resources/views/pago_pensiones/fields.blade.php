<table class="table" style="width:50%">
    <thead>
        <th class="text-center">No</th>
        <th class="text-center">Valor Pagado</th>
        <th class="text-center">Personas</th>
    </thead>
    <?php $c=1?>
    @foreach($ordenes as $ord)
    <tr>
        <th>{{$c++}}</th>
        <th class="text-right">
            @if($ord->vpagado=='')
            {{'Impagos'}}
            @else
            {{number_format($ord->vpagado,2)." $"}}
            @endif
        </th>        
        <th class="text-right">{{$ord->count}}</th>
    </tr>
    @endforeach
</table>