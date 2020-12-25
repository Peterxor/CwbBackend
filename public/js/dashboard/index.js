$(document).ready(function() {

    $('.js-change-btn').on('click', function() {
        $(this).parent().parent().find('select[name=user]').attr('disabled', false);
        $(this).parent().parent().find('button[name=save_btn]').show();
        $(this).hide();
    })
});