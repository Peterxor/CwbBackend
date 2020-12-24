$(document).ready(function() {

    $('input[name=display_type]').on('change', function() {
        var _id = $(this).attr('id');
        $('.js-info-group').hide();
        $('.js-' + _id).show();
    })
});