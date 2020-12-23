@extends('backend.layouts.app')
@section('content')
    @switch($sort)
        @case(1)
        @include('backend.pages.typhoon.motive')
        @break
        @case(2)
        @include('backend.pages.typhoon.potential')
        @break
        @case(3)
        @include('backend.pages.typhoon.wind_observe')
        @break
        @case(4)
        @include('backend.pages.typhoon.wind_predict')
        @break
        @case(5)
        @include('backend.pages.typhoon.rain_observe')
        @break
        @case(6)
        @include('backend.pages.typhoon.rain_predict')
        @break
        @default
    @endswitch

@endsection

@section('pages_scripts')

@endsection
