$(document).ready(function() {

    var searchForm = $('#search-form');
    var searchUrl = searchForm.attr('action');
    var weatherTable = $('#weather-table');
    var _weatherTable;
    var editUrl = weatherTable.attr('data-edit-url');

    var categoryForm = $('#category-form');
    var categoryTable = $('#category-table');
    var categoryUrl = categoryForm.attr('data-search-category');
    var _categoryTable;

    $.fn.dataTable.ext.errMode = 'none';

    var categorySetting = {
        stateSave: false,
        processing: true,
        serverSide: true,
        searching: false,
        destroy: true,
        autoWidth: true,
        ordering: false,
        language: datatable_lang_tw,
        ajax: {
            url: categoryUrl,
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
                width: '250px',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<tr><th><a href="" class="btn btn-outline-secondary btn-sm"><i class="la la-sort" style="font-size:16px"></i></a></th>';
                }
            },
            {
                data: null,
                width: '250px',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<td><input class="form-control" type="text" value="' + data.name + '" name="name[]" id="name-input" required\
                                       maxlength="30"></td>';
                }
            },
            {
                data: null,
                width: '250px',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<td><i class="category-trash la la-trash" data-category-id="' + data.id + '" style="font-size:16px"></i></td>\
                                    </tr>';
                }
            },

        ],
        rowReorder: {
            dataSrc: 'sequence'
        },
        "rowCallback": function(row, data, index) {

        },
    }


    var dataTableSettings = {
        stateSave: false,
        processing: true,
        serverSide: true,
        searching: false,
        destroy: true,
        autoWidth: true,
        ordering: false,
        language: datatable_lang_tw,
        sEmptyTable: null,
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
                data: 'sorts',
                width: '10px',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<span class="kt-badge kt-badge--inline"><i class="la la-sort" style="font-size:24px"></i></span>';
                }
            },
            { //操作
                data: null,
                width: '10px',
                defaultContent: '',
                mRender: function(data, type, full) {
                    return '<a href="' + editUrl.replace('_id', data.id) + '" class="btn btn-outline-primary" title="Edit details" id="edit-' + data.id + '-btn"><i class="la la-edit" style="font-size:24px"></i></a>';
                }
            },
            {
                data: 'category',
                width: '100px',
            },
            {
                data: 'name',
                width: '200px',
            },
        ],
        rowReorder: {
            dataSrc: 'sequence'
        },
        "rowCallback": function(row, data, index) {

        },
    }

    _weatherTable = weatherTable.DataTable(dataTableSettings);

    _weatherTable.on('row-reorder', function(e, moveData, edit) {
        let id = edit.triggerRow.data().id;
        let moveCount = moveData.length;
        let moveType = 'up';

        if (moveData[moveCount - 1].oldData == edit.triggerRow.data().sequence) {
            moveType = 'down';
        }

        $.ajax({
            url: 'weather/sequence',
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

    // 管理分類
    $(document).on("click", ".js-edit-btn", function() {
        _categoryTable = categoryTable.DataTable(categorySetting);
        $('#edit-modal').on('shown.bs.modal', function(e) {

            console.log('show');
        });

        $("#edit-modal").on("hidden.bs.modal", function() {
            console.log('hide');
        });
    });

    // 新增分類
    $(document).on("click", "#add-category-btn", function() {
        $('#category_body').find('.dataTables_empty').remove();

        $('#category_body').append('<tr>\
                                        <th><a href="" class="btn btn-outline-secondary btn-sm"><i class="la la-sort" style="font-size:16px"></i></a></th>\
                                        <td><input class="form-control" type="text" value="" name="name[]" id="name-input" required\
                                       maxlength="30"></td>\
                                        <td><a href="" class="btn btn-outline-secondary btn-sm"><i class="la la-trash" style="font-size:16px"></i></a></td>\
                                    </tr>');
    });

    $(document).on("click", "#edit-category-btn", function() {
        var form = $('#category-form')
        console.log(form.serialize())
        var data = form.serialize()

        $.ajax({
            url: 'weather/storeCategory',
            method: 'POST',
            dataType: 'json',
            data,
            success: function(response) {
                if (response.success) {
                    toastr.success("Success!");
                    $('#index-modal').modal('hide');
                } else {
                    toastr.error('error: ' + response.errors);
                }
            },
            error: function() {
                toastr.error('error');
            }
        })
    })

    $(document).on('click', '.category-trash', function(e) {
        var _this = this;
        console.log(_this.parentNode)
        console.log(_this.parentNode.parentNode)
        _this.parentNode.parentNode.parentNode.removeChild(_this.parentNode.parentNode);
    })

});