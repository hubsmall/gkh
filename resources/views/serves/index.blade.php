@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="panel-body"> 
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                
                <button type="submit" class="btn btn-default addElement">
                    <i class="fa fa-plus">+  serve</i>
                </button>
            </div>
            </div>
            <h3>Current Serves</h3>
            @if (count($serves) > 0)        
            <table class="table table-striped task-table" id="table">
                <thead>
                <th>Name</th><th>Unit</th><th>Tariff</th>
                </thead>
                <tbody class="tbody">
                    @foreach ($serves as $serve)
                    <tr class="table-text rowInList{{$serve->id}}">
                        <td>
                            <div>{{ $serve->name }}</div>                     
                        </td>
                        <td>
                            <div>{{ $serve->unit }}</div>                     
                        </td>
                        <td>
                            <div>{{ $serve->tariff }}</div>                     
                        </td>
                        <td>                   
                            <button data-id="{{$serve->id}}" data-name="{{$serve->name}}" 
                                    data-unit="{{$serve->unit}}"
                                    data-tariff="{{$serve->tariff}}"
                                    type="submit" class="btn btn-danger deleteElement">
                                <i class="fa fa-btn fa-trash"></i>Delete
                            </button>                       
                        </td>
                        <td>                               
                           <button data-id="{{$serve->id}}" data-name="{{$serve->name}}" 
                                    data-unit="{{$serve->unit}}"
                                    data-tariff="{{$serve->tariff}}"
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
                            <label class="control-label col-sm-2" for="U">Unit</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" id="U">
                                    <option value="m^2">m^2</option>
                                    <option value="kilovatt">kilovatt</option>
                                    <option value="m^3">m^3</option>
                                </select>
                            </div>
                            <label class="control-label col-sm-2" for="T">Tariff</label>
                            <div class="col-sm-10">
                                <input type="number" min="0" step="0.1" name="tariff" id="T" class="form-control inputValidation">                               
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
    <script src="{{ asset('js/serves.js') }}" defer></script>
    @endsection
