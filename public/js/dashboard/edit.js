$(document).ready(function() {

    $('.js-change-btn').on('change', function() {
        var type = $(this).val();
        var type_name = type == 'weather' ? 'select' : 'input';

        $('.js-ref').hide();
        $(this).parent().parent().find('td').eq(2).find(type_name).show();
    });
});