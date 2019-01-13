@extends('layouts.app')

@section('content')
<input type="button" value="Print" onclick="window.print();">
<div class="pagebreak" style="page-break-before: always;"> </div>
<div class="wrapper">
    <div class="panel-body">   
        <h5>Debtors</h5><br>
        <table class="table table-striped task-table" id="table">
            <thead>
            <th>street</th><th>block</th><th>flat</th><th>owner</th><th>debt</th></thead>
            <tbody class="tbody">     
                @foreach ($flatsDebtors as $flat)
                <tr class="table-text">
                    <td><div>{{ $flat->block->street->name }}</div></td> 
                    <td><div>{{ $flat->block->number }}</div></td>
                    <td><div>{{ $flat->number }}</div></td>
                    <td><div>{{ $flat->owner->name }}</div></td>    
                    <td><div>{{ $flat->debt }}</div></td>
                </tr> 
                @endforeach  
            </tbody>
        </table>       
        
    </div>
</div>
@endsection

