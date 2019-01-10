@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="panel-body"> 
        <div class="form-group">
            <label for="chanel-name" class="col-sm-3 control-label">               
                {{ __('enter tenat surname') }}
            </label>
            <div class="col-sm-3">
                <input type="text" name="name" id="nameSearch" class="form-control">
                <input type="hidden" name="_tokenSearch" value="{{ csrf_token() }}">
            </div> 
            <div class="col-sm-3">
                <label class="mr-sm-2" for="passportSearch">Passport</label>
                <input type="number" min="1" name="passport" id="passportSearch" class="form-control">              
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <button type="submit" class="btn btn-default search">
                    <i class="fa fa-plus">Search tenat</i>
                </button>
                <button type="submit" class="btn btn-default addElement">
                    <i class="fa fa-plus">+  tenat</i>
                </button>
            </div>
            </div>
            <h3>Current Tenats</h3>
            @if (count($tenants) > 0)        
            <table class="table table-striped task-table" id="table">
                <thead>
                <th>Name</th><th>Passport</th>
                </thead>
                <tbody class="tbody">
                    @foreach ($tenants as $tenant)
                    <tr class="table-text rowInList{{$tenant->id}}">
                        <td>
                            <div>{{ $tenant->name }}</div>                     
                        </td>
                        <td>
                            <div>{{ $tenant->passport }}</div>                     
                        </td>
                        <td>                   
                            <button data-id="{{$tenant->id}}" data-name="{{$tenant->name}}" 
                                    data-passport="{{$tenant->passport}}"
                                   
                                    type="submit" class="btn btn-danger deleteElement">
                                <i class="fa fa-btn fa-trash"></i>Delete
                            </button>                       
                        </td>
                        <td>                               
                           <button data-id="{{$tenant->id}}" data-name="{{$tenant->name}}" 
                                    data-passport="{{$tenant->passport}}"
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
                                <input type="text" name="name" class="form-control inputValidation" id="N">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                            <label class="control-label col-sm-2" for="P">Passport</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" name="passport" id="P" class="form-control inputValidation">                               
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
    <script src="{{ asset('js/tenants.js') }}" defer></script>
    @endsection
