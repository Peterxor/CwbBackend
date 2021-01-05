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

    // modal顯示
    $('button[name=edit_btn]').on('click', function() {
        var people_1 = $(this).parent().find('input[name=people_1]').val();
        var people_2 = $(this).parent().find('input[name=people_2]').val();
        var news_status = $(this).parent().find('input[name=news_status]').val();
        var next_news_status = $(this).parent().find('input[name=next_news_status]').val();
        var news_time = $(this).parent().find('input[name=news_time]').val();
        var next_news = $(this).parent().find('input[name=next_news_time]').val();

        $('#edit-modal').on('shown.bs.modal', function(e) {
            var _this = $(this);
            _this.find('input[name=news_time]').val(news_time);
        });

        $("#edit-modal").on("hidden.bs.modal", function() {
            $(this).find('form')[0].reset();
        });
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

                } else {
                    toastr.error('error: ' + data.message);
                }
            },
            error: function() {
                toastr.error('error');
            }
        });
    })
});
