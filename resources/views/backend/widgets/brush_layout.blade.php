    <div class="kt-portlet kt-portlet--collapse" data-ktportlet="true">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    畫筆色盤
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <div class="kt-portlet__head-group">
                    <a href="#" data-ktportlet-tool="toggle" class="btn btn-sm btn-icon btn-clean btn-icon-md"><i
                            class="la la-angle-down"></i></a>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body" style="display: none; overflow: hidden; padding-top: 0; padding-bottom: 0;">
            <form class="kt-form kt-form--label-right" action="{{$update_url}}" method="post">
                @csrf
                <input type="hidden" name="_method" value="put"/>
                <div class="kt-section">
                    <div class="kt-section__content">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class=""><label>1</label></th>
                                    <td>
                                        <label><input class="form-control js-picker" type="text" style="border-color:#435e70;"></label>
                                    </td>
                                    <th class=""><label>2</label></th>
                                    <td>
                                        <label><input class="form-control js-picker" type="text"></label>
                                    </td>
                                    <th class=""><label>3</label></th>
                                    <td>
                                        <label><input class="form-control js-picker" type="text"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <th class=""><label>4</label></th>
                                    <td>
                                        <label><input class="form-control js-picker" type="text"></label>
                                    </td>
                                    <th class=""><label>5</label></th>
                                    <td>
                                        <label><input class="form-control js-picker" type="text"></label>
                                    </td>
                                    <th class=""><label>6</label></th>
                                    <td>
                                        <label><input class="form-control js-picker" type="text"></label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6 kt-align-right">
                                <button type="submit" class="btn btn-primary">儲存</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
