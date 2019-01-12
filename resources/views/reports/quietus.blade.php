@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="panel-body">            
        @foreach ($flats as $flat)   
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
                    <td><div>{{ $serve->name }}</div></td>
                    <td><div>{{ $flat->calculateForAreaServe($serve) }}</div></td>                  
                </tr> 
                @endforeach  
            </tbody>
        </table>
        @endforeach 
    </div>
</div>
<div class="pagebreak" style="page-break-before: always;"> </div>
<input type="button" value="Print" onclick="window.print();">
@endsection

