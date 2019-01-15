@extends('layouts.app')

@section('content')
<div class="list-group">
    <a href="{{url('streets') }}" class="list-group-item list-group-item-action list-group-item-primary">УЛИЦЫ</a>
    <a href="{{url('blocks') }}" class="list-group-item list-group-item-action list-group-item-primary">ДОМА</a>
    <a href="{{url('flats') }}" class="list-group-item list-group-item-action list-group-item-primary">КВАРТИРЫ</a>
    <a href="{{url('tenants') }}" class="list-group-item list-group-item-action list-group-item-primary">ЖИТЕЛИ</a>
    <a href="{{url('serves') }}" class="list-group-item list-group-item-action list-group-item-info">УСЛУГИ / ТАРИФЫ</a>
    <a href="{{url('indications') }}" class="list-group-item list-group-item-action list-group-item-info">ПОКАЗАНИЯ</a>
    <a href="{{url('privileged') }}" class="list-group-item list-group-item-action list-group-item-info">ЛЬГОТНИКИ</a>
    <a href="{{url('quietus') }}" class="list-group-item list-group-item-action list-group-item-info">КВИТАНЦИИ</a>
    <a href="{{url('advantages') }}" class="list-group-item list-group-item-action list-group-item-info">ЛЬГОТЫ</a>
    <a href="{{url('reports') }}" class="list-group-item list-group-item-action list-group-item-secondary">ОТЧЕТНОСТЬ</a>
    <a href="#" id="archive" class="list-group-item list-group-item-action list-group-item-secondary">АРХИВАЦИЯ</a>
    <a href="{{url('reports/about') }}" class="list-group-item list-group-item-action list-group-item-success">О ПРОГРАММЕ</a>
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
                <div class="deleteContent">
                    This action will archivate all last year quietus. Continue? <span style="display: none;"
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
<script src="{{ asset('js/archivation.js') }}" defer></script>
@endsection
