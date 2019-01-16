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
                @foreach ($unpaidQuietus as $unpaidQuietu)
                <tr class="table-text">
                    <td><div>{{ $unpaidQuietu->flat->block->street->name }}</div></td> 
                    <td><div>{{ $unpaidQuietu->flat->block->number }}</div></td>
                    <td><div>{{ $unpaidQuietu->flat->number }}</div></td>
                    <td><div>{{ $unpaidQuietu->flat->owner->name }}</div></td>    
                    <td><div>{{ $unpaidQuietu->getCalculationWithPrivileges() }}</div></td>
                </tr> 
                @endforeach  
            </tbody>
        </table>       
        
    </div>
</div>
@endsection

