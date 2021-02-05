$(document).ready(function() {
    $('#sort-table').sortable();
    // type對應到的element
    const typeElementMap = {
        origin: 'select',
        upload: '.imgHolder',
        youtube: '.url_input',
        website: '.url_input',
    }

    $('.js-change-btn').on('change', function() {
        var type = $(this).val();
        var chooseElement = typeElementMap[type];
        $(this).parent().parent().find('input').eq(1).val(type);
        $(this).parent().parent().find('td').eq(3).hide();
        for (var property in typeElementMap) {
            if (typeElementMap.hasOwnProperty(property)) {
                if (chooseElement === typeElementMap[property]) {
                    $(this).parent().parent().find('td').eq(2).find(chooseElement).show();
                    if (chooseElement === '.url_input') {
                        $(this).parent().parent().find('td').eq(3).show();
                    }
                } else {
                    $(this).parent().parent().find('td').eq(2).find(typeElementMap[property]).hide();
                }
            }
        }
    });

    $('.upload-image').on('change', function(e) {
        var _this = $(this);
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
                    _this.parent().parent().parent().find('.image_id').val(msg.data.image_id);
                    _this.parent().parent().find('.image_name').html(msg.data.name);
                    _this.parent().parent().parent().find('.hidden_name').val(msg.data.name);
                    _this.parent().parent().parent().find('.image_url').val(msg.data.url);
                } else {
                    alert('Data save error: ' + msg.message)
                }

            }
        });
    })


});
