$(document).ready(function() {

    var searchForm = $('#search-form');
    var searchUrl = searchForm.attr('action');
    var typhoonTable = $('#typhoon-table');
    var _typhoonTable;
    var editUrl = typhoonTable.attr('data-edit-url');
    var queryUrl = typhoonTable.attr('data-query-url');

    $.fn.dataTable.ext.errMode = 'none';
    var dataTableSettings = {
        stateSave: false,
        processing: true,
        serverSide: true,
        searching: false,
        destroy: true,
        autoWidth: true,
        ordering: false,
        paging: false,
        info: false,
        language: datatable_lang_tw,
        ajax: {
            url: queryUrl,
            type: 'GET',
            data: function(aoData) {
                //把分頁的參數與自訂的搜尋結合
                $.each(searchForm.serializeArray(), function(key, value) {
                    aoData[value.name] = value.value;
                });
                return aoData;
            },
            dataSrc: 'data',
            error: function(xhr, error, code) {
                // console.log('xhr',xhr);
                // console.log('code',code);
                // console.log('error',error);
                if (code == 'Forbidden') {
                    location.reload();
                } else if (xhr.status == 419) {
                    location.reload();
                }
            }
        },
        columns: [{
                data: null,
                width: '10px',
                className: 'text-center',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<button class="btn btn-outline-secondary js-up" value="up_' + data.id + '"><i class="la la-long-arrow-up" style="font-size:20px"></i></button>\
                           <button class="btn btn-outline-secondary js-down" value="down_' + data.id + '"><i class="la la-long-arrow-down " style="font-size:20px"></i></button>';
                }
            },
            {
                data: 'name',
                width: '250px',
            },
            { //操作
                data: null,
                width: '10px',
                className: 'text-center',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<a href="' + editUrl.replace('_id', data.id) + '" class="btn btn-outline-primary" id="edit-' + data.id + '-btn"><i class="la la-edit" style="font-size:24px"></i></a>';
                }
            }

        ],
        "rowCallback": function(row, data, index) {

        },
    }

    _typhoonTable = typhoonTable.DataTable(dataTableSettings);

    $(document).on("click", ".js-up", function() {
        var _id = $(this).val().split('_')[1];

        $.ajax({
            url: 'typhoon/upper',
            method: 'GET',
            dataType: 'json',
            data: {
                id: _id,
            },
            success: function(response) {
                if (response.success) {
                    toastr.success("Success!");
                } else {
                    toastr.error('error: ' + response.message);
                }
                _typhoonTable.ajax.reload();
            },
            error: function() {
                toastr.error('error');
            }
        })
    })

    $(document).on("click", ".js-down", function() {
        var _id = $(this).val().split('_')[1];

        $.ajax({
            url: 'typhoon/lower',
            method: 'GET',
            dataType: 'json',
            data: {
                id: _id,
            },
            success: function(response) {
                if (response.success) {
                    toastr.success("Success!");
                } else {
                    toastr.error('error: ' + response.message);
                }
                _typhoonTable.ajax.reload();
            },
            error: function() {
                toastr.error('error');
            }
        })
    })
});