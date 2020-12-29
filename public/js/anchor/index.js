$(document).ready(function() {

    var searchForm = $('#search-form');
    var searchUrl = searchForm.attr('action');
    var anchorTable = $('#anchor-table');
    var _anchorTable;
    var editUrl = anchorTable.attr('data-edit-url');

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
            { //防災視訊室
                data: null,
                width: '250px',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<a href="' + editUrl.replace('_id', data.id).replace('_device_id', data.device_id_1) + '" class="btn btn-outline-success" title="Edit details" id="edit-' + data.id + '-btn"><i class="la la-edit" style="font-size:24px"></i></a>';
                }
            },
            { //公關室
                data: null,
                width: '250px',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<a href="' + editUrl.replace('_id', data.id).replace('_device_id', data.device_id_2) + '" class="btn btn-outline-success" title="Edit details" id="edit-' + data.id + '-btn"><i class="la la-edit" style="font-size:24px"></i></a>';
                }
            }
        ],
        "rowCallback": function(row, data, index) {

        },
    }

    _anchorTable = anchorTable.DataTable(dataTableSettings);
});
