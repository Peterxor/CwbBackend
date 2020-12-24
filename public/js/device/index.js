$(document).ready(function() {

    var searchForm = $('#search-form');
    var searchUrl = searchForm.attr('action');
    var deviceTable = $('#device-table');
    var _deviceTable;
    var editUrl = deviceTable.attr('data-edit-url');

    $.fn.dataTable.ext.errMode = 'none';
    var dataTableSettings = {
        stateSave: false,
        processing: true,
        serverSide: true,
        searching: false,
        destroy: true,
        autoWidth: true,
        ordering: false,
        language: datatable_lang_tw,
        ajax: {
            url: searchUrl,
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
                data: 'name',
                width: '150px',
            },
            {
                data: null,
                width: '250px',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<a href="' + editUrl.replace('_id', data.id) + '" class="btn btn-outline-success" ><i class="la la-edit" style="font-size:24px"></i></a>';
                }
            }
        ],
        "rowCallback": function(row, data, index) {

        },
    }

    _deviceTable = deviceTable.DataTable(dataTableSettings);
});