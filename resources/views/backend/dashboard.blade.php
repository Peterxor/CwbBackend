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
                        <label for="example-search-input" class="col-12 col-form-label">
                            <span class="kt-badge kt-badge--lg kt-badge--rounded" style="font-size: 22px"><i class="la la-user"></i></span>預報主播
                        </label>
                        <div class="col-3">
                            <select class="form-control" name="category" id="dish-category">
            					{{ Widget::UserSelect()}}
                            </select>
                        </div>
                        <div class="col-3 kt-align-left">
                            <button type="submit" class="btn btn-primary">儲存
                            </button>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label for="example-search-input" class="col-4 col-form-label">
                                <span class="kt-badge kt-badge--lg kt-badge--rounded" style="font-size: 22px"><i class="la la-desktop"></i></span>颱風主播圖卡
                            </label>
                            <button type="submit" class="btn btn-primary">編輯主播圖卡
                            </button>
                        </div>
                        <div class="col-6">
                            <label for="example-search-input" class="col-4 col-form-label">
                                <span class="kt-badge kt-badge--lg kt-badge--rounded" style="font-size: 22px"><i class="la la-desktop"></i></span>天氣預報排程
                            </label>
                            <button type="submit" class="btn btn-primary">編輯預報排程
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">

                        <div class="col-6 row">
                            <div class="col-empty"></div>
                            <div class="col-4 layout-container" style="background-image:url(/images/login/logo.png);">

                                <div class="row layout-text">
                                    <label>1. 東亞IR</label>
                                </div>
                            </div>
                            <div class="col-4 layout-container" style="background-image:url(/images/login/logo.png);">
                                <div class="row layout-text">
                                    <label>2. 東亞MB</label>
                                </div>
                            </div>
                            <div class="col-4 layout-container" style="background-image:url(/images/login/logo.png);">
                                <div class="row layout-text">
                                    <label>3. 雨量</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 row">
                            <div class="col-empty"></div>
                            <div class="col-4 layout-container" style="background-image:url(/images/login/logo.png);">

                                <div class="row layout-text">
                                    <label>1. 東亞IR</label>
                                </div>
                            </div>
                            <div class="col-4 layout-container" style="background-image:url(/images/login/logo.png);">
                                <div class="row layout-text">
                                    <label>2. 東亞MB</label>
                                </div>
                            </div>
                            <div class="col-4 layout-container" style="background-image:url(/images/login/logo.png);">
                                <div class="row layout-text">
                                    <label>3. 雨量</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<style>
    .col-empty{
        flex:0 0 50%;max-width:5%;
    }

    .layout-container {
        max-width:30%;
        height: 100px;
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        margin-bottom: 50px;
        margin-left:5px;
        border-style:solid;
        border-color:black;
        border-width:1px;
    }

    .layout-text{
        margin-top: 110px;
    }

</style>
    <!-- end:: Content -->
@endsection
