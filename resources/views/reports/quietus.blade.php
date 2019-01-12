@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="panel-body">            
        <h3>Report {{ $month }}/{{ $year }}</h3>
        @if (count($ServeTotals) > 0)        
        <table class="table table-striped task-table" id="table">
            <thead>
            <th>serve</th>
            @foreach ($serves as $serve)
            <th>{{ $serve->name }}</th>
            @endforeach  
            <th>summary</th>
            </thead>
            <tbody class="tbody">                
                <tr class="table-text">
                    <td><div>total</div></td>
                    @foreach ($ServeTotals as $key => $ServeTotal)   
                    <td>
                        <div>{{ $ServeTotal }}</div>                     
                    </td>
                    @endforeach   
                </tr>               
            </tbody>
        </table>
        @endif  
    </div>
</div>
<div class="pagebreak" style="page-break-before: always;"> </div>
<input type="button" value="Print" onclick="window.print();">
@endsection

