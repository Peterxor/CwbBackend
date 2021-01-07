@extends('backend.layouts.app')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">設定颱風動態</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <a href="{{route('typhoon.index', [])}}">颱風預報圖資</a><span> / 設定颱風動態</span>
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
                                    <label for="example-search-input" class="col-2 col-form-label">
                                        <span class="kt-font-danger">*</span>颱風座標資料來源 (檔案)
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control" type="text" value="{{$data->content['typhoon-dynamics']['origin'] ?? ''}}"
                                               name="typhoon-dynamics[origin]" required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    圖資顯示樣式
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body">
                            <div class="kt-section kt-section--first">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <span class="kt-font-danger">*</span>
                                        <label>颱風IR (東亞) 資料來源</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-2 col-form-label">
                                        來源 (資料夾)
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control" type="text"
                                               value="{{$data->content['typhoon-ir']['origin'] ?? ''}}" name="typhoon-ir[origin]" required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-2 col-form-label">
                                        動態組圖張數
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control" type="text"
                                               value="{{$data->content['typhoon-ir']['amount'] ?? 1}}" name="typhoon-ir[amount]"
                                               required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                        <label>張</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-2 col-form-label">
                                        換圖速率
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control" type="text"
                                               value="{{$data->content['typhoon-ir']['interval'] ?? 1000}}"
                                               name="typhoon-ir[interval]" required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                        <label>張/毫秒</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <span class="kt-font-danger">*</span>
                                        <label>颱風MB (東亞) 資料來源</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-2 col-form-label">
                                        來源 (資料夾)
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control" type="text"
                                               value="{{$data->content['typhoon-mb']['origin'] ?? ''}}" name="typhoon-mb[origin]" required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-2 col-form-label">
                                        動態組圖張數
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control" type="text"
                                               value="{{$data->content['typhoon-mb']['amount'] ?? 1}}" name="typhoon-mb[amount]"
                                               required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                        <label>張</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-2 col-form-label">
                                        換圖速率
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control" type="text"
                                               value="{{$data->content['typhoon-mb']['interval'] ?? 1000}}"
                                               name="typhoon-mb[interval]" required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                        <label>張/毫秒</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <span class="kt-font-danger">*</span>
                                        <label>颱風VIS (東亞) 資料來源</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-2 col-form-label">
                                        來源 (資料夾)
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control" type="text"
                                               value="{{$data->content['typhoon-vis']['origin'] ?? ''}}" name="typhoon-vis[origin]"
                                               required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-2 col-form-label">
                                        動態組圖張數
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control" type="text"
                                               value="{{$data->content['typhoon-vis']['amount'] ?? 1}}" name="typhoon-vis[amount]"
                                               required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                        <label>張</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-search-input" class="col-2 col-form-label">
                                        換圖速率
                                    </label>
                                    <div class="col-7">
                                        <input class="form-control" type="text"
                                               value="{{$data->content['typhoon-vis']['interval'] ?? 1000}}"
                                               name="typhoon-vis[interval]" required>
                                    </div>
                                    <div class="col-3 pt-3 col-form-label">
                                        <label>張/毫秒</label>
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
