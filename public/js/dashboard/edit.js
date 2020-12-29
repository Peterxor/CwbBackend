$(document).ready(function() {
    $('#sort-table').sortable();

    $('.js-change-btn').on('change', function() {
        var type = $(this).val();
        var type_name = type == 'weather' ? 'select' : '.imgHolder';
        var hide_name = type_name == 'select' ? '.imgHolder': 'select';
        var data_type = type_name == 'select' ? 'origin' : 'upload';

        // $('.js-ref').hide();
        console.log($(this).parent().parent().find('input').eq(1).val())
        $(this).parent().parent().find('input').eq(1).val(data_type)
        $(this).parent().parent().find('td').eq(2).find(type_name).show();
        $(this).parent().parent().find('td').eq(2).find(hide_name).hide();
        // $(this).parent().parent().find('td').eq(2).find(type_name).show();
    });

    $('.upload-image').on('change', function(e) {
        // console.log(e.target.files[0])
        var form = new FormData();
        form.append('file', e.target.files[0])
        var parentElement = this.parentElement
        $.ajax({
            type: 'POST',
            url: '/media/upload',
            processData: false, //prevents jQuery from parsing the data and throwing an Illegal Invocation error. JQuery does this when it encounters a file in the form and can not convert it to string
            contentType: false, //prevents ajax sending the content type header. The content type header make Laravel handel the FormData Object as some serialized string.
            data: form,
            success: function(msg) {
                if (msg.success) {
                    parentElement.querySelector('.image_id').setAttribute('value', msg.data.image_id);
                    parentElement.querySelector('.image_name').setAttribute('value', msg.data.name);
                    parentElement.querySelector('.hidden_name').setAttribute('value', msg.data.name);
                    parentElement.querySelector('.image_url').setAttribute('value', msg.data.url);
                    console.log(msg.data.name)
                    // parentElement.querySelector('.image_show').setAttribute('src', msg.data.url)
                } else {
                    alert('Data save error: ' + msg.message)
                }

            }
        });
    })


});
