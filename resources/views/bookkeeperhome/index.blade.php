@extends('layouts.app')

@section('content')
<div class="list-group">
  <a href="{{url('streets') }}" class="list-group-item list-group-item-action list-group-item-primary">УЛИЦЫ</a>
  <a href="{{url('blocks') }}" class="list-group-item list-group-item-action list-group-item-primary">ДОМА</a>
  <a href="{{url('flats') }}" class="list-group-item list-group-item-action list-group-item-primary">КВАРТИРЫ</a>
  <a href="{{url('tenants') }}" class="list-group-item list-group-item-action list-group-item-primary">ЖИТЕЛИ</a>
  <a href="{{url('serves') }}" class="list-group-item list-group-item-action list-group-item-info">УСЛУГИ / ТАРИФЫ</a>
  <a href="#" class="list-group-item list-group-item-action list-group-item-info">ПОКАЗАНИЯ</a>
  <a href="#" class="list-group-item list-group-item-action list-group-item-info">КВИТАНЦИИ</a>
  <a href="#" class="list-group-item list-group-item-action list-group-item-info">ЛЬГОТЫ</a>
  <a href="#" class="list-group-item list-group-item-action list-group-item-secondary">ОТЧЕТНОСТЬ</a>
  <a href="#" class="list-group-item list-group-item-action list-group-item-secondary">АРХИВАЦИЯ</a>
  <a href="#" class="list-group-item list-group-item-action list-group-item-success">О ПРОГРАММЕ</a>
</div>
@endsection
