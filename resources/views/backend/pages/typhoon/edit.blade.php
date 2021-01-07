@extends('backend.layouts.app')
@section('content')
    @switch($data->name ?? '')
        @case('typhoon-dynamics')
        @include('backend.pages.typhoon.typhoon_dynamics')
        @break
        @case('typhoon-potential')
        @include('backend.pages.typhoon.typhoon_potential')
        @break
        @case('wind-observation')
        @include('backend.pages.typhoon.wind_observation')
        @break
        @case('wind-forecast')
        @include('backend.pages.typhoon.wind_forecast')
        @break
        @case('rainfall-observation')
        @include('backend.pages.typhoon.rainfall_observation')
        @break
        @case('rainfall-forecast')
        @include('backend.pages.typhoon.rainfall_forecast')
        @break
        @default
    @endswitch

@endsection

@section('pages_scripts')

@endsection
