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
                <label class="mr-sm-2" for="inlineFormStreetsSelect">Streets</label>
                <select class="custom-select mr-sm-2" id="streetIdSearch">
                    <option value="" selected>Choose...</option>
                    @foreach ($streets as $street)
                    <option value="{{$street->id}}">{{$street->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                <label class="mr-sm-2" for="inlineFormBlocksSelect">Blocks</label>
                <select class="custom-select mr-sm-2" id="blockIdSearch">
                    <option value="" selected>Choose...</option>
                </select>
            </div>
            <div class="col-sm-3">
                <label class="mr-sm-2" for="inlineFormFlatsSelect">Flats</label>
                <select class="custom-select mr-sm-2" id="flatIdSearch">
                    <option value="" selected>Choose...</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <button type="submit" class="btn btn-default search">
                    <i class="fa fa-plus">Search indication</i>
                </button>
                <button type="submit" class="btn btn-default addElement">
                    <i class="fa fa-plus">+  indication</i>
                </button>
            </div>
            </div>
            <h3>Current Indications</h3>
            @if (count($indications) > 0)        
            <table class="table table-striped task-table" id="table">
                <thead>
                <th>Indication</th><th>Serve</th><th>Flat</th><th>Block</th><th>Street</th><th>Date</th>
                </thead>
                <tbody class="tbody">
                    @foreach ($indications as $indication)
                    <tr class="table-text rowInList{{$indication->id}}">
                        <td>
                            <div>{{ $indication->indication }}</div>                     
                        </td>
                        <td>
                            <div>{{ $indication->serve->name }}</div>                     
                        </td>
                        <td>
                            <div>{{ $indication->flat->number }}</div>                     
                        </td>
                        <td>
                            <div>{{ $indication->flat->block->number }}</div>                     
                        </td>
                        <td>
                            <div>{{ $indication->flat->block->street->name }}</div>                     
                        </td>
                        <td>
                            <div>{{ $indication->created_at }}</div>                     
                        </td>
                        <td>                   
                            <button data-id="{{$indication->id}}" data-name="{{$indication->indication}}" 
                                    data-serveid="{{$indication->serve->id}}"
                                    data-flatid="{{$indication->flat->id}}"
                                    data-flatnumber="{{$indication->flat->number}}"
                                    data-blockid="{{$indication->flat->block->id}}"
                                    data-blocknumber="{{$indication->flat->block->number}}"
                                    data-streetid="{{$indication->flat->block->street->id }}"
                                    type="submit" class="btn btn-danger deleteElement">
                                <i class="fa fa-btn fa-trash"></i>Delete
                            </button>                       
                        </td>
                        <td>                               
                            <button data-id="{{$indication->id}}" data-name="{{$indication->indication}}" 
                                    data-serveid="{{$indication->serve->id}}"
                                    data-flatid="{{$indication->flat->id}}"
                                    data-flatnumber="{{$indication->flat->number}}"
                                    data-blockid="{{$indication->flat->block->id}}"
                                    data-blocknumber="{{$indication->flat->block->number}}"
                                    data-streetid="{{$indication->flat->block->street->id }}"
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
                            <label class="control-label col-sm-2" for="N">Indication</label>
                            <div class="col-sm-10">
                                <input type="text" name="id" hidden=""  id="I">                          
                                <input type="number" min="0" name="name" class="form-control inputValidation" id="N">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                            <label class="control-label col-sm-2" for="S">Serves</label>
                            <div class="col-sm-10">                      
                                <select class="custom-select mr-sm-2" id="S"> 
                                    <option selected="">choose</option>
                                    @foreach ($serves as $serve)
                                    <option value="{{$serve->id}}">{{$serve->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="control-label col-sm-2" for="Str">Streets</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" id="Str"> 
                                    <option selected="">choose</option>
                                    @foreach ($streets as $street)
                                    <option value="{{$street->id}}">{{$street->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="control-label col-sm-2" for="B">Blocks</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" id="B"> 
                                    <option>choose</option>
                                </select>
                            </div>
                            <label class="control-label col-sm-2" for="F">Flats</label>
                            <div class="col-sm-10">
                                <select class="custom-select mr-sm-2" id="F"> 
                                    <option>choose</option>
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
    <script src="{{ asset('js/indications.js') }}" defer></script>
    @endsection
