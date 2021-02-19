@extends('backend.layouts.app')
@section('content')
    <!-- begin:: Content Head -->
    <div class="kt-subheader  kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">圖資時間設定</h3>
                <span class="kt-subheader__separator kt-subheader__separator--v"></span>
                <a href="{{route('dashboard.index', [])}}">Dashboard </a><span> / 圖資時間設定</span>
            </div>
        </div>
    </div>
    <!-- end:: Content Head -->
    <!-- begin:: Content -->
    <form class="kt-form kt-form--label-right" id="edit-form" method="post"
          action="{{route('dashboard.updateImageTime', ['device' => $device->id])}}">
        @csrf
{{--        <input type="hidden" name="_method" value="put"/>--}}
        {{--        <input type="hidden" name="pic_type" value="{{$pic_type}}"/>--}}

        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">


            <div class="row">
                <div class="col-12">
                    <div class="kt-form__actions">
                        <div class="form-group row">
                            <div class="col-6">
                                <a href="{{route('dashboard.index', [])}}" class="btn btn-secondary">回上一頁</a>
                            </div>
                            <div class="col-6">

                            </div>
                        </div>
                    </div>

                    <div class="kt-portlet">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <h3 class="kt-portlet__head-title">
                                    主播：{{$device->user->name ?? '不指定'}}
                                </h3>
                            </div>
                        </div>

                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary" id="edit-btn">儲存變更</button>
                                </div>
                                <div class="col-6">

                                </div>
                            </div>
                            <table id="card_table"
                                   class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline"
                                   query-device-id="{{$device->id}}">
                                <thead>
                                <tr>
                                    <th style="width:150px;">圖資名稱</th>
                                    <th style="width:50px;">預設</th>
                                    <th>起始時間</th>
                                    <th>結束時間</th>
                                </tr>
                                </thead>
                                <tbody id="sort-table">
                                @foreach($generals as $general)
                                    <tr>
                                        <input type="hidden" name="general_id[]" value="{{$general['id']}}">
                                        <td>{{$general['display_name']}}</td>
                                        <td>
                                            <label class="checkbox">
                                                <input type="checkbox" name="is_default[]" value="{{$general['id']}}" {{($userImageData[$general['id']]->is_default ?? true) ? 'checked' : ''}}>
                                                <span>預設</span>
                                            </label>
                                        </td>
                                        <td>
                                            <select class="form-control js-change-btn" name="start_file[]">
                                                @foreach($general['options'] as $option)
                                                    <option value="{{$option}}" {{($userImageData[$general['id']] ?? null) ? ($userImageData[$general['id']]->start_file === $option ? 'selected' : '') : ($option === '' ? 'selected' : '')}}>{{$option}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="form-control js-change-btn" name="end_file[]">
                                                @foreach($general['options'] as $option)
                                                    <option value="{{$option}}" {{($userImageData[$general['id']] ?? null) ? ($userImageData[$general['id']]->end_file === $option ? 'selected' : '') : ($option === '' ? 'selected' : '')}}>{{$option}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
    <!-- end:: Content -->

@endsection

@section('pages_scripts')
    {!! Html::script('js/vendor/jquery-ui.js') !!}
@endsection
