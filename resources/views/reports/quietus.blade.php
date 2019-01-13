@extends('layouts.app')

@section('content')
<input type="button" value="Print" onclick="window.print();">
<div class="pagebreak" style="page-break-before: always;"> </div>
@foreach ($flats as $flat) 
<div class="wrapper">
    <div class="panel-body">   
        <div class="col-md-auto">
            <div><span style="font-weight: bold;">date:</span> {{ $flat->DateOfLatestIndication }}</div>
            <div><span style="font-weight: bold;">flat:</span> {{ $flat->number }}, {{ $flat->block->number }}, {{ $flat->block->street->name }} st.</div>
            <div><span style="font-weight: bold;">owner:</span> {{ $flat->owner->name }}</div>
            <div><span style="font-weight: bold;">area:</span> {{ $flat->area }} m2</div>
        </div>
        <br>
        <table class="table table-striped task-table" id="table">
            <thead>
            <th>serve</th><th>tariff</th><th>indication</th><th>summary</th></thead>
            <tbody class="tbody">     
                @foreach ($indicationServes as $serve)
                <tr class="table-text">
                    <td><div>{{ $serve->name }}</div></td> 
                    <td><div>{{ $serve->tariff }}</div></td>
                    <td><div>{{ $flat->getIndicationForServe($serve) }}</div></td>
                    <td><div>{{ $flat->calculateForIndicationServe($serve) }}</div></td>                  
                </tr> 
                @endforeach  
            </tbody>
        </table>
        <br/>
        <table class="table table-striped task-table" id="table">
            <thead>
            <th>serve</th><th>tariff</th><th>summary</th></thead>
            <tbody class="tbody">     
                @foreach ($areaServes as $serve)
                <tr class="table-text">
                    <td><div>{{ $serve->name }}</div></td> 
                    <td><div>{{ $serve->tariff }}</div></td>
                    <td><div>{{ $flat->calculateForAreaServe($serve) }}</div></td>                  
                </tr> 
                @endforeach  
            </tbody>
        </table>
        <div class="col-md-auto">
            <div><span style="font-weight: bold;">total:</span> {{ $flat->calculate }}</div>
            <br>
        </div>
    </div>
</div>
<div class="pagebreak" style="page-break-before: always;"> </div>
@endforeach 
@endsection

