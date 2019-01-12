@extends('layouts.app')

@section('content')

<div class="wrapper">
    <div class="panel-body">            
        {!! $chart->container() !!}
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
{!! $chart->script() !!}
<input type="button" value="Print" onclick="window.print();">
@endsection

