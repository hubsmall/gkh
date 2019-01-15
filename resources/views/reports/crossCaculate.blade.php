@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="panel-body">            
        <h3>Cross-calculate report</h3>
        @if (count($table) > 0)        
        <table class="table table-striped task-table" id="table">
            <thead>
            <th>serve<br>flat</th>
            @foreach ($serves as $serve)
            <th>{{ $serve->name }}</th>
            @endforeach  
            <th>summary</th>
            </thead>
            <tbody class="tbody">
                @foreach ($table as $key => $tableArray)
                <tr class="table-text">
                    <td>
                        <div>{{ $key }}</div>                     
                    </td>
                     @foreach ($tableArray as $tableArrayElement)
                     <td>
                        <div>{{ $tableArrayElement }}</div>                     
                    </td>
                     @endforeach                                                
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif  
    </div>
</div>

<script src="{{ asset('js/reports.js') }}" defer></script>
@endsection

