$(document).ready(function() {

    $('.js-change-btn').on('click', function() {
        $(this).parent().parent().find('select[name=user]').attr('disabled', false);
        $(this).parent().parent().find('button[name=save_btn]').show();
        $(this).hide();
    })

    $('.js-submit-btn').on('click', function(e) {
        var device_id = e.target.getAttribute('data-device-id')
        console.log(device_id)
        var host_id = document.getElementById('device-host-' + device_id).value
        console.log(host_id)
        $.ajax({
            url: '/device/updateDeviceHost',
            type: 'PUT',
            data: {
                user_id: host_id,
                device_id,
            },
            success: function(data) {
                if (data.success) {
                    swal.fire('success')
                }
            }
        });

    })
});
