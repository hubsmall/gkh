@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="panel-body"> 
        <div class="form-group">
            <label for="ownerIdSearch" class="col-sm-3 control-label">               
                {{ __('Owner') }}
            </label>
            <div class="col-sm-3">
                <input type="hidden" name="_tokenSearch" value="{{ csrf_token() }}">
                <select class="custom-select mr-sm-2" id="ownerIdSearch">
                    <option value="" selected>Choose...</option>
                    @foreach ($owners as $owner)
                    <option value="{{$owner->id}}">{{$owner->name}}</option>
                    @endforeach
                </select>
            </div> 
            <div class="col-sm-3">
                <label class="mr-sm-2" for="advantageIdSearch">Advantages</label>
                <select class="custom-select mr-sm-2" id="advantageIdSearch">
                    <option value="" selected>Choose...</option>
                    @foreach ($advantages as $advantage)
                    <option value="{{$advantage->id}}">{{$advantage->name}}</option>
                    @endforeach
                </select>
            </div>   
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <button type="submit" class="btn btn-default search">
                    <i class="fa fa-plus">Search privilege</i>
                </button>
                <button type="submit" class="btn btn-default addElement">
                    <i class="fa fa-plus">+  privilege</i>
                </button>
            </div>
            </div>
            <h3>Current Privileges</h3>
            @if (count($privileges) > 0)        
            <table class="table table-striped task-table" id="table">
                <thead>
                <th>Owner</th><th>Advantage</th>
                </thead>
                <tbody class="tbody">
                    @foreach ($privileges as $privilege)
                    <tr class="table-text rowInList{{$privilege->id}}">
                        <td>
                            <div>{{ $privilege->owner->name }}</div>                     
                        </td>
                        <td>
                            <div>{{ $privilege->advantage->name }}</div>                     
                        </td>                     
                        <td>                   
                            <button data-id="{{$privilege->id}}" data-ownerid="{{$privilege->owner->id}}" 
                                    data-advantageid="{{$privilege->advantage->id}}"                                    
                                    type="submit" class="btn btn-danger deleteElement">
                                <i class="fa fa-btn fa-trash"></i>Delete
                            </button>                       
                        </td>
                        <td>                               
                            <button data-id="{{$privilege->id}}" data-ownerid="{{$privilege->owner->id}}" 
                                    data-advantageid="{{$privilege->advantage->id}}"
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
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="text" name="id" hidden=""  id="I"> 
                        <div class="form-group" id="Addform">                           
                            <label class="control-label col-sm-2" for="A">Advantages</label>
                            <div class="col-sm-10">                      
                                <select class="custom-select mr-sm-2" id="A"> 
                                    <option selected="">choose</option>
                                    @foreach ($advantages as $advantage)
                                    <option value="{{$advantage->id}}">{{$advantage->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="control-label col-sm-2" for="O">Owners</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" id="O"> 
                                    <option selected="">choose</option>
                                    @foreach ($owners as $owner)
                                    <option value="{{$owner->id}}">{{$owner->name}}</option>
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
    <script src="{{ asset('js/privileged.js') }}" defer></script>
    @endsection
