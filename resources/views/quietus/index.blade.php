@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="panel-body"> 
        <div class="form-group">
            <label for="chanel-name" class="col-sm-3 control-label">               
                {{ __('Date') }}
            </label>
            <div class="col-sm-3">
                <input type="date" id="dateSearch" class="form-control">
                <input type="hidden" name="_tokenSearch" value="{{ csrf_token() }}">
            </div> 
            <div class="col-sm-3">
                <label class="mr-sm-2" for="streetIdSearch">Streets</label>
                <select class="custom-select mr-sm-2" id="streetIdSearch">
                    <option value="" selected>Choose...</option>
                    @foreach ($streets as $street)
                    <option value="{{$street->id}}">{{$street->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                <label class="mr-sm-2" for="blockIdSearch">Blocks</label>
                <select class="custom-select mr-sm-2" id="blockIdSearch">
                    <option value="" selected>Choose...</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label class="mr-sm-2" for="flatIdSearch">Flats</label>
                <select class="custom-select mr-sm-2" id="flatIdSearch">
                    <option value="" selected>Choose...</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <button type="submit" class="btn btn-default search">
                    <i class="fa fa-plus">Search quietus</i>
                </button>
                <form action="{{ url('quietus/createQuietusForMonth') }}" method="GET">
                    <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus">+  quietus for current month</i>
                </button>
                </form>               
            </div>
        </div>
        <h3>Current Quietus</h3>
        @if (count($quietus) > 0)        
        <table class="table table-striped task-table" id="table">
            <thead>
            <th>Paid</th><th>Flat</th><th>Block</th><th>Street</th><th>Date</th>
            </thead>
            <tbody class="tbody">
                @foreach ($quietus as $quietu)
                <tr class="table-text rowInList{{$quietu->id}}">
                    <td>
                        <div>{{ $quietu->pay_status }}</div>                     
                    </td>                       
                    <td>
                        <div>{{ $quietu->flat->number }}</div>                     
                    </td>
                    <td>
                        <div>{{ $quietu->flat->block->number }}</div>                     
                    </td>
                    <td>
                        <div>{{ $quietu->flat->block->street->name }}</div>                     
                    </td>
                    <td>
                        <div>{{ $quietu->created_at }}</div>                     
                    </td>
                    <td>                   
                        <button data-id="{{$quietu->id}}"                               
                                type="submit" class="btn btn-danger deleteElement">
                            <i class="fa fa-btn fa-trash"></i>Delete
                        </button>                       
                    </td>
                    <td>                               
                        <button data-id="{{$quietu->id}}" data-paystatus="{{$quietu->pay_status}}"                                
                                type="submit" class="btn btn-info updateElement">
                            <i class="fa fa-btn fa-trash"></i>Update
                        </button>                    
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif  
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>           
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">                    
                    <div class="form-group" id="Addform">
                        <input type="text" name="id" hidden=""  id="I">                          
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label class="control-label col-sm-2" for="P">Paid</label>
                        <div class="col-sm-10">                      
                            <select class="custom-select mr-sm-2" id="P"> 
                                <option selected="" value="0">false</option>
                                <option selected="" value="1">true</option>
                            </select>
                        </div>
                    </div>        
                </form>
                <div class="deleteContent">
                    Are you Sure you want to delete <span class="dname"></span> ? <span style="display: none;"
                                                                                        class="hidden did"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class='glyphicon'> </span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/quietus.js') }}" defer></script>
@endsection
