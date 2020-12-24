@extends('backend.layouts.app')
@section('content')
<!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">設定雨量觀測</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <a href="{{route('typhoon.index', [])}}">颱風預報圖資</a><span> / 設定雨量觀測</span>
            </div>
        </div>
    </div>
<!-- end:: Content Head -->
<!-- begin:: Content -->
    <form class="kt-form kt-form--label-right" id="edit-form" method="post" enctype="multipart/form-data">
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
                                    <span class="kt-font-danger">*</span>今日雨量資料來源 (文字)
                                </label>
                    			<div class="col-6">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
                                <div class="col-3 pt-3 col-form-label">
                                </div>
            		        </div>
                            <div class="form-group row">
                    			<label for="example-search-input" class="col-3 col-form-label">
                                    <span class="kt-font-danger">*</span>今日雨量資料來源 (圖片)
                                </label>
                    			<div class="col-6">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
                                <div class="col-3 pt-3 col-form-label">
                                </div>
            		        </div>
                            <div class="form-group row">
                    			<label for="example-search-input" class="col-2 col-form-label">
                                    <span class="kt-font-danger">*</span>動態組圖張數
                                </label>
                    			<div class="col-7">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
                                <div class="col-3 pt-3 col-form-label">
                                    <span>張</span>
                                </div>
            		        </div>
                            <div class="form-group row">
                    			<label for="example-search-input" class="col-2 col-form-label">
                                    <span class="kt-font-danger">*</span>換圖速率 (秒/張)
                                </label>
                    			<div class="col-7">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
                                <div class="col-3 pt-3 col-form-label">
                                    <span>張/秒</span>
                                </div>
            		        </div>
                        </div>
                	</div>
                </div>
                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                分時雨量
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="form-group row">
                    			<label for="example-search-input" class="col-3 col-form-label">
                                    <span class="kt-font-danger">*</span>前一日雨量觀測
                                </label>
                                <div class="col-2">
                                    <select class="form-control" name="">
                    					<option value="1">啟用</option>
                                        <option value="2">停用</option>
                                    </select>
                    			</div>
            		        </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    文字
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
		                    </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    圖片
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
		                    </div>

                            <div class="form-group row">
                    			<label for="example-search-input" class="col-3 col-form-label">
                                    <span class="kt-font-danger">*</span>前二日雨量觀測
                                </label>
                                <div class="col-2">
                                    <select class="form-control" name="">
                    					<option value="1">啟用</option>
                                        <option value="2">停用</option>
                                    </select>
                    			</div>
            		        </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    文字
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
		                    </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    圖片
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
		                    </div>

                            <div class="form-group row">
                    			<label for="example-search-input" class="col-3 col-form-label">
                                    <span class="kt-font-danger">*</span>前三日雨量觀測
                                </label>
                                <div class="col-2">
                                    <select class="form-control" name="">
                    					<option value="1">啟用</option>
                                        <option value="2">停用</option>
                                    </select>
                    			</div>
            		        </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    文字
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
		                    </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    圖片
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
		                    </div>

                            <div class="form-group row">
                    			<label for="example-search-input" class="col-3 col-form-label">
                                    <span class="kt-font-danger">*</span>前四日雨量觀測
                                </label>
                                <div class="col-2">
                                    <select class="form-control" name="">
                    					<option value="1">啟用</option>
                                        <option value="2">停用</option>
                                    </select>
                    			</div>
            		        </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    文字
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
		                    </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    圖片
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
		                    </div>

                        </div>
                	</div>
                </div>

                <div class="kt-portlet">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                分區雨量
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="form-group row">
                    			<label for="example-search-input" class="col-3 col-form-label">
                                    <span class="kt-font-danger">*</span>前一日雨量觀測
                                </label>
                                <div class="col-2">
                                    <select class="form-control" name="">
                    					<option value="1">啟用</option>
                                        <option value="2">停用</option>
                                    </select>
                    			</div>
            		        </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    文字
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
		                    </div>

                            <div class="form-group row">
                    			<label for="example-search-input" class="col-3 col-form-label">
                                    <span class="kt-font-danger">*</span>前二日雨量觀測
                                </label>
                                <div class="col-2">
                                    <select class="form-control" name="">
                    					<option value="1">啟用</option>
                                        <option value="2">停用</option>
                                    </select>
                    			</div>
            		        </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    文字
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
		                    </div>

                            <div class="form-group row">
                    			<label for="example-search-input" class="col-3 col-form-label">
                                    <span class="kt-font-danger">*</span>前三日雨量觀測
                                </label>
                                <div class="col-2">
                                    <select class="form-control" name="">
                    					<option value="1">啟用</option>
                                        <option value="2">停用</option>
                                    </select>
                    			</div>
            		        </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    文字
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
                                </div>
		                    </div>

                            <div class="form-group row">
                    			<label for="example-search-input" class="col-3 col-form-label">
                                    <span class="kt-font-danger">*</span>前四日雨量觀測
                                </label>
                                <div class="col-2">
                                    <select class="form-control" name="">
                    					<option value="1">啟用</option>
                                        <option value="2">停用</option>
                                    </select>
                    			</div>
            		        </div>

                            <div class="form-group row">
                                <div class="col-1">
                    			</div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    文字
                                </label>
                    			<div class="col-5">
                                    <input class="form-control" type="text" value="" name="" required>
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
                <button type="submit" class="btn btn-success ld-over" id="edit-btn">儲存
                    <div class="ld ld-ring ld-spin"></div>
                </button>
            </div>
        </div>
    </div>
    </form>
<!-- end:: Content -->

@endsection

@section('pages_scripts')
@endsection
