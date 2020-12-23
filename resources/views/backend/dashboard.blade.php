@extends('backend.layouts.app')
@section('content')

    <!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Dashboard</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!-- begin:: Content -->
    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <div class="row">
            <div class="kt-portlet">
                <div class="kt-portlet__head kt-portlet__head--lg">
                    <div class="kt-portlet__head-label">
                        <div class="kt-portlet__head-wrapper">

                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <p>目前登入帳號：{{Auth::user() ? Auth::user()->email : ''}}</p>
                    <p>使用者名稱：{{Auth::user() ? Auth::user()->name : ''}}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Content -->
@endsection
