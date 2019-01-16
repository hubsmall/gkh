@extends('layouts.app')

@section('content')
<input type="button" value="Print" onclick="window.print();">
<div class="pagebreak" style="page-break-before: always;"> </div> 
<div class="wrapper">
    <div class="panel-body">   
        <div class="col-md-auto">
            <div><span style="font-weight: bold;">date:</span> {{ $quietu->date }}</div>
            <div><span style="font-weight: bold;">flat:</span> {{ $quietu->flat->number }}, {{ $quietu->flat->block->number }}, {{ $quietu->flat->block->street->name }} st.</div>
            <div><span style="font-weight: bold;">owner:</span> {{ $quietu->flat->owner->name }}</div>
            <div><span style="font-weight: bold;">area:</span> {{ $quietu->flat->area }} m2</div>
        </div>
        <br>
        <h5>Indication serves</h5>
        <table class="table table-striped task-table" id="table">           
            <thead>
            <th>serve</th><th>tariff</th><th>indication</th><th>summary</th></thead>
            <tbody class="tbody">     
                @foreach ($indicationServes as $serve)
                <tr class="table-text">
                    <td><div>{{ $serve->name }}</div></td> 
                    <td><div>{{ $serve->tariff }}</div></td>
                    <td><div>{{ $quietu->getIndicationForServe($serve) }}</div></td>
                    <td><div>{{ $quietu->calculateForIndicationServe($serve) }}</div></td>                  
                </tr> 
                @endforeach  
            </tbody>
        </table>
        <br/>
        <h5>Area serves</h5>
        <table class="table table-striped task-table" id="table">         
            <thead>
            <th>serve</th><th>tariff</th><th>summary</th></thead>
            <tbody class="tbody">     
                @foreach ($areaServes as $serve)
                <tr class="table-text">
                    <td><div>{{ $serve->name }}</div></td> 
                    <td><div>{{ $serve->tariff }}</div></td>
                    <td><div>{{ $quietu->calculateForAreaServe($serve) }}</div></td>                  
                </tr> 
                @endforeach  
            </tbody>
        </table>
        <br/>
        @if (count($quietu->flat->owner->privileges) > 0)  
        <h5>Privileges</h5>
        <table class="table table-striped task-table" id="table">          
            <thead>
            <th>privilege</th><th>percent</th></thead>
            <tbody class="tbody">     
                @foreach ($quietu->flat->owner->privileges as $privilege)
                <tr class="table-text">
                    <td><div>{{ $privilege->advantage->name }}</div></td> 
                    <td><div>{{ $privilege->advantage->percent }}</div></td>                 
                </tr> 
                @endforeach  
            </tbody>
        </table>
        @endif  
        <div class="col-md-auto">
            <div><span style="font-weight: bold;">total:</span> {{ $quietu->calculate }}</div>
            <br>
            @if (count($quietu->flat->owner->privileges) > 0)  
            <div><span style="font-weight: bold;">total with privileges:</span> {{ $quietu->getCalculationWithPrivileges() }}</div>
            <br>
            @endif  
        </div>
    </div>
</div>
@endsection

