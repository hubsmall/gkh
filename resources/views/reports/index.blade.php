@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="panel-body"> 
        <div class="form-group">
            <h3>Перекрестная таблица</h3>
            <form action="{{ url('reports/crossCalculte') }}" method="GET">
                <label for="dateSearch" class="col-sm-3 control-label">               
                    {{ __('enter date') }}
                </label>
                <div class="col-sm-3">
                    <input type="date" name="date" id="dateSearch" class="form-control">
                    <input type="hidden" name="_tokenSearch" value="{{ csrf_token() }}">
                </div>                            
                <div class="form-group">
                    <br>
                    <div class="col-sm-offset-3 col-sm-3">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-plus">Show report</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>   
        
        
        <div class="form-group">
            <h3>Диаграмма</h3>
            <form action="{{ url('reports/diagramm') }}" method="GET">
                <label for="dateSearch" class="col-sm-3 control-label">               
                    {{ __('enter date') }}
                </label>
                <div class="col-sm-3">
                    <input type="date" name="date" id="dateSearch" class="form-control">
                    <input type="hidden" name="_tokenSearch" value="{{ csrf_token() }}">
                </div> 
                <div class="col-sm-3">
                    <label class="mr-sm-2" for="streetIdSearch">Streets</label>
                    <select class="custom-select mr-sm-2" name="street_id" id="streetIdSearch">
                        <option value="" selected>Choose...</option>
                        @foreach ($streets as $street)
                        <option value="{{$street->id}}">{{$street->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label class="mr-sm-2"  for="blockIdSearch">Blocks</label>
                    <select class="custom-select mr-sm-2" name="block_id" id="blockIdSearch">
                        <option value="" selected>Choose...</option>
                    </select>
                </div>             
                <div class="form-group">
                    <br>
                    <div class="col-sm-offset-3 col-sm-3">
                        <button type="submit" class="btn btn-default ">
                            <i class="fa fa-plus">Show report</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>  
        
        
        
        
        <div class="form-group">
            <h3>Кооперативная ведомость</h3>
            <form action="{{ url('reports/cooperativeCalculate') }}" method="GET">
                <label for="dateSearch" class="col-sm-3 control-label">               
                    {{ __('enter date') }}
                </label>
                <div class="col-sm-3">
                    <input type="date" name="date" id="dateSearch" class="form-control">
                    <input type="hidden" name="_tokenSearch" value="{{ csrf_token() }}">
                </div>                                       
                <div class="form-group">
                    <br>
                    <div class="col-sm-offset-3 col-sm-3">
                        <button type="submit" class="btn btn-default ">
                            <i class="fa fa-plus">Show report</i>
                        </button>
                    </div>
                </div>
            </form>
        </div> 
        
        
        <div class="form-group">
            <h3>Должники</h3>
            <form action="{{ url('reports/debtors') }}" method="GET">  
                <label for="dateSearch" class="col-sm-3 control-label">               
                    {{ __('enter date') }}
                </label>
                <div class="col-sm-3">
                    <input type="date" name="date" id="dateSearch" class="form-control">
                    <input type="hidden" name="_tokenSearch" value="{{ csrf_token() }}">
                </div>
                <div class="form-group">
                    <br>
                    <div class="col-sm-offset-3 col-sm-3">
                        <button type="submit" class="btn btn-default ">
                            <i class="fa fa-plus">Show report</i>
                        </button>
                    </div>
                </div>
            </form>
        </div> 
        
        
        
    </div>
</div>


<script src="{{ asset('js/reports.js') }}" defer></script>
@endsection

