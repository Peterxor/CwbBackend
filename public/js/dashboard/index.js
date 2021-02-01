$(document).ready(function() {

    // 記者會時間設定
    $('#news-time').timepicker().on('show.timepicker', function() {});
    $('#next-news-time').timepicker().on('show.timepicker', function() {});

    // modal更換版型
    $('input[name=edition_type]').on('change', function() {
        var display_block = $(this).val();
        $('.js-display-block').hide();
        $('.js-' + display_block).show();
    })

    // modal更換記者會狀態
    $('.js-news-status').on('change', function() {
        var type = $(this).val() == '1' ? false : true;
        $(this).parent().next().find('.js-news').attr('disabled', type);
    })

    // 上傳image顯示檔名
    $('#board_image').on('change', function() {
        var _this = $(this)
        var file_name = _this.val().split('\\')[_this.val().split('\\').length - 1]

        // console.log(_this.val().split('\\')[_this.val().split('\\').length - 1])
        _this.parent().find('span[class=image_name]').text(file_name);
    })

    // modal顯示
    $('#edit-modal').on('shown.bs.modal', function(e) {
        // 先拿觸動modal的按鈕
        var button = $('#' + e.relatedTarget.id)
        var modal_title = button.parent().find('input[name=modal_title]').val();
        var board_id = button.parent().find('input[name=board_id]').val();
        var board_device_id = button.parent().find('input[name=board_device_id]').val();
        var modal_type = button.parent().find('input[name=modal_type]').val();
        var board_background = button.parent().find('input[name=board_background]').val();
        var people_1 = button.parent().find('input[name=people_1]').val();
        var people_2 = button.parent().find('input[name=people_2]').val();
        var news_status = button.parent().find('input[name=news_status]').val();
        var next_news_status = button.parent().find('input[name=next_news_status]').val();
        var news_time = button.parent().find('input[name=news_time]').val();
        var next_news_time = button.parent().find('input[name=next_news_time]').val();
        var media_name = button.parent().find('input[name=media_name]').val();
        // 將上面的值塞modal
        var _this = $(this);
        var edition_1 = $('#edition_1');
        var edition_2 = $('#edition_2');
        if (+modal_type === 2) {
            edition_2.attr('checked', true)
            edition_1.attr('checked', false)
        } else {
            edition_2.attr('checked', false)
            edition_1.attr('checked', true)
        }
        var display_block = +modal_type === 2 ? edition_2.val() : edition_1.val()
        $('.js-display-block').hide();
        $('.js-' + display_block).show();

        $('#label-title').text(modal_title);
        var news_time_disabled = news_status !== '1';
        var next_news_time_disabled = next_news_status !== '1';
        _this.find('input[name=board_id]').val(board_id);
        _this.find('input[name=board_device_id]').val(board_device_id);
        _this.find('input[name=news_time]').val(news_time);
        _this.find('input[name=news_time]').attr('disabled', news_time_disabled);
        _this.find('input[name=next_news_time]').val(next_news_time);
        _this.find('input[name=next_news_time]').attr('disabled', next_news_time_disabled);
        _this.find('select[name=board_background]').val(board_background);
        _this.find('select[name=people_1]').val(people_1);
        _this.find('select[name=people_2]').val(people_2);
        _this.find('select[name=news_status]').val(news_status);
        _this.find('select[name=next_news_status]').val(next_news_status);
        $('#board_image').parent().find('span[class=image_name]').text(media_name);
    });

    $("#edit-modal").on("hidden.bs.modal", function() {
        $(this).find('form')[0].reset();
    });

    // 儲存看板
    $('#edit-submit-btn').on('click', function() {
        var _this = $(this);
        var ajaxSend = {
            url: '/dashboard/updateBoard',
            type: 'POST',
            success: function(res) {
                if (res.success) {
                    var result = res.data
                    var button = $('#device_board_' + result.device_id)
                    button.parent().find('input[name=board_device_id]').val(result.device_id);
                    button.parent().find('input[name=board_id]').val(result.id);
                    button.parent().find('input[name=modal_type]').val(result.type)
                    button.parent().find('input[name=news_time]').val(result.conference_time);
                    button.parent().find('input[name=next_news_time]').val(result.next_conference_time);
                    button.parent().find('input[name=board_background]').val(result.background);
                    button.parent().find('input[name=people_1]').val(result.personnel_id_a);
                    button.parent().find('input[name=people_2]').val(result.personnel_id_b);
                    button.parent().find('input[name=news_status]').val(result.conference_status);
                    button.parent().find('input[name=next_news_status]').val(result.next_conference_status);
                    button.parent().find('input[name=media_name]').val(result.media_name);
                    $('#edit-modal').modal('hide');
                    toastr.success("Success!");
                } else {
                    toastr.error('error: ' + data.message);
                }
            },
            error: function() {
                toastr.error('error');
            }
        }
        var edition_type = _this.parent().parent().find('input[name=edition_type]:checked').val();
        var device_id = _this.parent().parent().find('input[name=board_device_id]').val();
        var board_id = _this.parent().parent().find('input[name=board_id]').val();
        var data = null;
        if (edition_type === 'default') {
            data = {
                edition_type,
                device_id,
                board_id,
                news_time: _this.parent().parent().find('input[name=news_time]').val(),
                next_news_time: _this.parent().parent().find('input[name=next_news_time]').val(),
                board_background: _this.parent().parent().find('select[name=board_background]').val(),
                people_1: _this.parent().parent().find('select[name=people_1]').val(),
                people_2: _this.parent().parent().find('select[name=people_2]').val(),
                news_status: _this.parent().parent().find('select[name=news_status]').val(),
                next_news_status: _this.parent().parent().find('select[name=next_news_status]').val(),
            }
        } else {
            data = new FormData();
            var file = $('#board_image').prop('files')[0];
            data.append('edition_type', edition_type);
            data.append('device_id', device_id);
            data.append('board_id', board_id);
            data.append('file', file);
            ajaxSend.processData = false;
            ajaxSend.contentType = false;
        }
        ajaxSend.data = data;
        $.ajax(ajaxSend);
    });

    // 變更佈景主題
    $('button[name=change_layout_btn]').on('click', function() {
        $(this).parent().parent().find('select[name=theme]').attr('disabled', false);
        $(this).parent().parent().find('button[name=save_layout_btn]').show();
        $(this).hide();
    })

    // 儲存佈景主題
    $('button[name=save_layout_btn]').on('click', function(e) {
        var _this = $(this);
        var device_id = e.target.getAttribute('data-device-id')
        var theme = document.getElementById('theme-select-' + device_id).value
        $.ajax({
            url: '/dashboard/updateDeviceTheme',
            type: 'PUT',
            data: {
                theme,
                device_id,
            },
            success: function(data) {
                if (data.success) {
                    toastr.success("Success!");
                    _this.parent().parent().find('select[name=theme]').attr('disabled', true);
                    _this.parent().parent().find('button[name=change_layout_btn]').show();
                    _this.hide();
                } else {
                    toastr.error('error: ' + data.message);
                }
            },
            error: function() {
                toastr.error('error');
            }
        });
    })

    // 變更預報主播
    $('button[name=change_user_btn]').on('click', function() {
        $(this).parent().parent().find('select[name=user]').attr('disabled', false);
        $(this).parent().parent().find('button[name=save_user_btn]').show();
        $(this).hide();
    })

    // 儲存預報主播
    $('button[name=save_user_btn]').on('click', function(e) {
        var _this = $(this);
        var device_id = e.target.getAttribute('data-device-id')
        var host_id = document.getElementById('device-host-' + device_id).value

        $.ajax({
            url: '/dashboard/updateDeviceHost',
            type: 'PUT',
            data: {
                user_id: host_id,
                device_id,
            },
            success: function(data) {
                if (data.success) {
                    toastr.success("Success!");
                    _this.parent().parent().find('select[name=user]').attr('disabled', true);
                    _this.parent().parent().find('button[name=change_user_btn]').show();
                    _this.hide();

                    var device_typhoon = $('.device-typhoon-json-' + data.data.device_id);
                    var device_forecast = $('.device-forecast-json-' + data.data.device_id);
                    device_typhoon.empty();
                    device_forecast.empty();
                    var typhoon_json = data.data.typhoon_json;
                    var forecast_json = data.data.forecast_json;

                    jsonToHtml(device_typhoon, typhoon_json);
                    jsonToHtml(device_forecast, forecast_json);
                } else {
                    toastr.error('error: ' + data.message);
                }
            },
            error: function() {
                toastr.error('error');
            }
        });
    })

    function jsonToHtml (device_html, json) {
        for (var index in json) {
            var html = '';
            if (index % 3 === 0) {
                html += '<div class="col-empty"></div>'
            }
            var img_url = json[index].img_url ? json[index].img_url : '';
            var img_name = (img_url.split('/')[img_url.split('/').length - 1]).split('.')[0]
            html +=
                '<div class="col-4 layout-container" style="background-image:url(' + img_url +');">\n' +
                '<div class="row layout-text">\n' +
                '<label>' + (index + 1) + '. ' + img_name + '</label>\n' +
                '</div>\n' +
                '</div>'
            device_html.append(html);
        }
    }
});
