@extends('backend.layouts.app')
@section('content')
    @switch($data->name ?? '')
        @case('typhoon_dynamics')
        @include('backend.pages.typhoon.typhoon_dynamics')
        @break
        @case('typhoon_potential')
        @include('backend.pages.typhoon.typhoon_potential')
        @break
        @case('wind_observation')
        @include('backend.pages.typhoon.wind_observation')
        @break
        @case('wind_forecast')
        @include('backend.pages.typhoon.wind_forecast')
        @break
        @case('rainfall_observation')
        @include('backend.pages.typhoon.rainfall_observation')
        @break
        @case('rainfall_forecast')
        @include('backend.pages.typhoon.rainfall_forecast')
        @break
        @default
    @endswitch

@endsection

@section('pages_scripts')

@endsection
