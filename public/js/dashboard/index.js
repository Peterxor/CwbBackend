$(document).ready(function() {

    $('button[name=change_btn]').on('click', function() {
        $(this).parent().parent().find('select[name=user]').attr('disabled', false);
        $(this).parent().parent().find('button[name=save_btn]').show();
        $(this).hide();
    })

    $('button[name=save_btn]').on('click', function(e) {
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
                    _this.parent().parent().find('button[name=change_btn]').show();
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
