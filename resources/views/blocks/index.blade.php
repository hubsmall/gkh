@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="panel-body"> 
        <div class="form-group">
            <label for="chanel-name" class="col-sm-3 control-label">               
                {{ __('enter block number') }}
            </label>
            <div class="col-sm-3">
                <input type="number" min="1" name="name" id="nameSearch" class="form-control">
                <input type="hidden" name="_tokenSearch" value="{{ csrf_token() }}">
            </div> 
            <div class="col-sm-3">
                <label class="mr-sm-2" for="inlineFormCustomSelect">Streets</label>
                <select class="custom-select mr-sm-2" id="streetIdSearch">
                    <option value="" selected>Choose...</option>
                    @foreach ($streets as $street)
                    <option value="{{$street->id}}">{{$street->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <button type="submit" class="btn btn-default search">
                    <i class="fa fa-plus">Search block</i>
                </button>
                <button type="submit" class="btn btn-default addElement">
                    <i class="fa fa-plus">+  block</i>
                </button>
            </div>
            </div>
            <h3>Current Blocks</h3>
            @if (count($blocks) > 0)        
            <table class="table table-striped task-table" id="table">
                <thead>
                <th>Number</th><th>Street</th>
                </thead>
                <tbody class="tbody">
                    @foreach ($blocks as $block)
                    <tr class="table-text rowInList{{$block->id}}">
                        <td>
                            <div>{{ $block->number }}</div>                     
                        </td>
                        <td>
                            <div>{{ $block->street->name }}</div>                     
                        </td>
                        <td>                   
                            <button data-id="{{$block->id}}" data-name="{{$block->number}}" 
                                    data-streetid="{{$block->street->id}}"
                                    data-streetname="{{$block->street->name}}"
                                    type="submit" class="btn btn-danger deleteElement">
                                <i class="fa fa-btn fa-trash"></i>Delete
                            </button>                       
                        </td>
                        <td>                               
                            <button data-id="{{$block->id}}" data-name="{{$block->number}}"
                                    data-streetid="{{$block->street->id}}"
                                    data-streetname="{{$block->street->name}}"
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
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="chanelname">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" name="id" hidden=""  id="I">                          
                                <input type="number" min="1" name="name" class="form-control inputValidation" id="N">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                            <label class="control-label col-sm-2" for="S">Streets</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2 inputValidation" id="S">
                                    <option selected="" value="">choose</option>
                                    @foreach ($streets as $street)
                                    <option value="{{$street->id}}">{{$street->name}}</option>
                                    @endforeach
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
    <script src="{{ asset('js/blocks.js') }}" defer></script>
    @endsection
