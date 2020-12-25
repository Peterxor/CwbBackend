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
                data: 'sequence',
                width: '40px',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<span class="kt-badge kt-badge--inline"><i class="la la-sort" style="font-size:24px"></i></span>';
                }
            },
            { //操作
                data: null,
                width: '250px',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<a href="' + editUrl.replace('_id', data.id) + '" class="btn btn-outline-success" title="Edit details" id="edit-' + data.id + '-btn"><i class="la la-sort" style="font-size:24px"></i></a>';
                }
            },
            {
                data: 'name',
                width: '150px',
            },
        ],
        rowReorder: {
            dataSrc: 'sequence'
        },
        "rowCallback": function(row, data, index) {

        },
    }

    _typhoonTable = typhoonTable.DataTable(dataTableSettings);

    _typhoonTable.on('row-reorder', function(e, moveData, edit) {
        let id = edit.triggerRow.data().id;
        let moveCount = moveData.length;
        let moveType = 'up';

        if (moveData[moveCount - 1].oldData == edit.triggerRow.data().sequence) {
            moveType = 'down';
        }

        $.ajax({
            url: 'typhoon/sequence',
            method: 'GET',
            dataType: 'json',
            data: {
                id: id,
                type: moveType,
                num: moveCount - 1
            },
            success: function(response) {
                if (response.success) {
                    toastr.success("Success!");
                } else {
                    toastr.error('error: ' + response.errors);
                }
            },
            error: function() {
                toastr.error('error');
            }
        })
    });
});
