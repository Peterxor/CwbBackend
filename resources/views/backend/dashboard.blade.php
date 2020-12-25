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

        {{-- <div class="row">
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
        </div> --}}

        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        防災視訊室多螢幕輸出（21:9）
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                    <div class="form-group row">
                        <label for="example-search-input" class="col-2 col-form-label">
                            <span class="kt-badge kt-badge--lg kt-badge--rounded"><i class="la la-user"></i></span>預報主播
                        </label>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <select class="form-control" name="category" id="dish-category">
            					{{-- {{ Widget::UserSelect()}} --}}
                            </select>
                        </div>
                        <div class="col-3 kt-align-left">
                            <button type="submit" class="btn btn-success">儲存
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="example-search-input" class="col-4 col-form-label">
                                <span class="kt-badge kt-badge--lg kt-badge--rounded"><i class="la la-user"></i></span>颱風主播圖卡
                            </label>
                            <button type="submit" class="btn btn-success">編輯主播圖卡
                            </button>
                        </div>
                        <div class="col-6">
                            <label for="example-search-input" class="col-4 col-form-label">
                                <span class="kt-badge kt-badge--lg kt-badge--rounded"><i class="la la-user"></i></span>颱風主播圖卡
                            </label>
                            <button type="submit" class="btn btn-success">天氣預報排程
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">

                        <div class="col-6">
                            <div class="col-1 layout-container" style="background-image:url(/images/login/logo.png);">
                                <div class="row" style="margin-top: 160px">
                                    <label>東亞IR</label>
                                </div>
                            </div>
                            <div class="col-1 layout-container" style="background-image:url(/logo_large.png);">
                                <div class="row" style="margin-top: 160px">
                                    <label>東亞MB</label>
                                </div>
                            </div>
                            <div class="col-1 layout-container" style="background-image:url(/logo_large.png);">
                                <div class="row" style="margin-top: 160px">
                                    <label>雨量</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
    .layout-container {
        width: 100px;
        height: 150px;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        margin-bottom: 100px;
        margin-left:10px;
        border-style:solid;
        border-color:black;
        border-width:1px;
    }
    </style>
    <!-- end:: Content -->
@endsection
