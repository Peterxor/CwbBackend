@extends('backend.layouts.app')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">設定雨量預測</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <a href="{{route('typhoon.index', [])}}">颱風預報圖資</a><span> / 設定雨量預測</span>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!-- begin:: Content -->
    <form class="kt-form kt-form--label-right" id="edit-form"
          action="{{route('typhoon.update', ['typhoon' => $data->id ?? 0])}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="put"/>

        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-12">
                    <div class="kt-form__actions">
                        <div class="form-group row">
                            <div class="col-6">
                                <a href="{{route('typhoon.index', [])}}" class="btn btn-secondary">回上一頁</a>
                            </div>
                            <div class="col-6 kt-align-right">

                            </div>
                        </div>
                    </div>

                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    圖資資訊
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-section kt-section--first">
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-3 col-form-label">
                                        <span class="kt-font-danger">*</span>總雨量預測資料來源 (資料夾)
                                    </label>
                                    <div class="col-6">
                                        <input class="form-control" type="text" value="{{$data->content['all-rainfall']['origin'] ?? ''}}" name="all-rainfall[origin]" required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-3 col-form-label">
                                        <span class="kt-font-danger">*</span>總雨量預測警戒值
                                    </label>
                                    <div class="col-6">
                                        <input class="form-control" type="text" value="{{$data->content['all-rainfall']['alert_value'] ?? 0}}" name="all-rainfall[alert_value]" required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-3 col-form-label">
                                        <span class="kt-font-danger">*</span>24h雨量預測資料來源 (資料夾)
                                    </label>
                                    <div class="col-6">
                                        <input class="form-control" type="text" value="{{$data->content['24h-rainfall']['origin'] ?? ''}}" name="24h-rainfall[origin]" required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-3 col-form-label">
                                        <span class="kt-font-danger">*</span>24h雨量預測警戒值
                                    </label>
                                    <div class="col-6">
                                        <input class="form-control" type="text" value="{{$data->content['24h-rainfall']['alert_value'] ?? 0}}" name="24h-rainfall[alert_value]" required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                </div>
                <div class="col-6 kt-align-right">
                    <button type="submit" class="btn btn-primary" id="edit-btn">儲存</button>
                </div>
            </div>
        </div>
    </form>
    <!-- end:: Content -->

@endsection

@section('pages_scripts')
@endsection
