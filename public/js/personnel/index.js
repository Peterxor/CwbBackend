$(document).ready(function() {

    var searchForm = $('#search-form');
    var searchUrl = searchForm.attr('action');
    var personnelTable = $('#personnel-table');
    var _personnelTable;
    var editUrl = personnelTable.attr('data-edit-url');

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
            data: null,
            width: '10%',
            className: 'text-center',
            defaultContent: '',
            mRender: function(data, type, full) {
                return '<a href="' + editUrl.replace('_id', data.id) + '" class="btn btn-outline-primary" ><i class="la la-edit"></i></a>';
            }
        }, {
            data: 'name',
            width: '250px',
        }, {
            data: 'nick_name',
            width: '250px',
        }, {
            data: 'career',
            width: '250px',
        }, ],
        "rowCallback": function(row, data, index) {

        },
    }

    _personnelTable = personnelTable.DataTable(dataTableSettings);
});
