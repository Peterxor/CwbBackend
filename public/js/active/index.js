$(document).ready(function() {
    // 時間設定
    $("#start-date").datepicker({
        autoclose: true,
        language: 'zh-TW',
        format: "yyyy-mm-dd",
    }).on('changeDate', function() {
        // console.log('yes');
        if ($("#start-date").val() > $('#end-date').val()) {
            $('#end-date').val('');
        }
        $('#end-date').datepicker('setStartDate', $("#start-date").val());
        $('#end-date').focus();
    });
    $("#end-date").datepicker({
        autoclose: true,
        language: 'zh-TW',
        format: "yyyy-mm-dd",
    });

    var searchForm = $('#search-form');
    var searchFromBtn = $('#search-btn');
    var searchUrl = searchForm.attr('action');
    var activeTable = $('#active-table');
    var _activeTable;
    var editUrl = activeTable.attr('data-edit-url');

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
            data: 'date',
            width: '150px',
        }, {
            data: 'user',
            width: '150px',
        }, {
            data: 'active',
            width: '150px',
        }, {
            data: 'item',
            width: '150px',
        }, {
            data: 'ip',
            width: '150px',
        }],
        "rowCallback": function(row, data, index) {

        },
    }

    _activeTable = activeTable.DataTable(dataTableSettings);

    searchFromBtn.on('click', function() {

        _activeTable.ajax.reload();
    });
});