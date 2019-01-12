@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="panel-body"> 
        <div class="form-group">
            <form action="{{ url('reports/crossCalculte') }}" method="GET">
            <label for="dateSearch" class="col-sm-3 control-label">               
                {{ __('enter date') }}
            </label>
            <div class="col-sm-3">
                <input type="date" name="date" id="dateSearch" class="form-control">
                <input type="hidden" name="_tokenSearch" value="{{ csrf_token() }}">
            </div> 
                <div class="col-sm-offset-3 col-sm-3">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus">Show report</i>
                </button>
            </div>
            </form>
        </div>            
    </div>
</div>

<script src="{{ asset('js/reports.js') }}" defer></script>
@endsection

