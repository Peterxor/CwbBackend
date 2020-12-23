$(document).ready(function () {

    var searchForm = $('#search-form');
    var searchFromBtn = $('#search-btn');
    var searchUrl = searchForm.attr('action');
    var courseTable = $('#course-table');
    var _courseTable;
    var editUrl = courseTable.attr('data-edit-url');
    var changeStatusUrl = courseTable.attr('data-status-url')

    $.fn.dataTable.ext.errMode = 'none';
    var dataTableSettings = {
        stateSave: false,
        processing: true,
        serverSide: true,
        searching: false,
        destroy: true,
        autoWidth: true,
        ordering: false,
        // order: [
        //     [0, "asc"]
        // ],
        language: datatable_lang_tw,
        ajax: {
            url: searchUrl,
            type: 'GET',
            data: function (aoData) {
                //把分頁的參數與自訂的搜尋結合
                $.each(searchForm.serializeArray(), function (key, value) {
                    aoData[value.name] = value.value;
                });
                return aoData;
            },
            dataSrc: function (json) {
                //Make your callback here.
                return json.data;
            },
            error: function (xhr, error, code) {
                if (code == 'Forbidden') {
                    location.reload();
                } else if (xhr.status == 419) {
                    location.reload();
                }
            },
        },
        columns: [
            {
                data: 'name',
                width: '220px',
            },
            {
                data: 'email',
                width: '220px',
            },
            {
                data: 'phone',
                width: '220px',
            },
            {
                data: 'ext',
                width: '220px',
            },
            {
                data: 'fax',
                width: '220px',
            },
            {
                data: 'web',
                width: '220px',
            },
            {
                data: null,
                width: '60px',
                orderable: false,
                mRender: function (data, type, full) {
                    if (data.status * 1 === 1) {
                        return '<a href="#" class="kt-badge kt-badge--primary kt-badge--inline kt-badge--pill kt-badge--rounded js-status-change" value="0" id="status-' + data.id + '-btn">啟用</a>';
                    } else {
                        return '<a href="#" class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded js-status-change" value="1" id="status-' + data.id + '-btn">停用</a>';
                    }
                }
            },
            {
                data: null,
                width: '220px',
                orderable: false,
                mRender: function (data, type, full) {
                    console.log(data.exchange_ratio)
                    var exchange_ratio = data.exchange_ratio * 1;
                    return exchange_ratio.toFixed(2);
                }
            },
            {
                data: null,
                width: '220px',
                orderable: false,
                mRender: function (data, type, full) {
                    return data.postcode ? data.postcode : '' + '/' + data.address ? data.address : '';
                }
            },
            {
                data: 'contact_name',
                width: '120px',
            },
            {
                data: 'created_at',
                width: '120px',
            },
            {
                data: 'updated_at',
                width: '120px',
            },
            {
                data: null,
                width: '20px',
                orderable: false,
                mRender: function (data, type, full) {
                    return '<a href="' + editUrl.replace('_id', data.id) + '" class="btn btn-outline-primary btn-elevate btn-icon"><i class="la la-edit"></i></a>';
                }
            },
        ],
        "rowCallback": function (row, data, index) {

        },
    }

    // dataTableSettings.deferLoading = 0;
    _courseTable = courseTable.DataTable(dataTableSettings);

    searchFromBtn.on('click', function () {
        _courseTable.ajax.reload();
    });

    $(document).keypress(function (event) {
        if (event.which == '13') {
            event.preventDefault();
            _courseTable.ajax.reload();
        }
    });

    _courseTable.on('click', '.user-delete', function (e) {
        console.log(123)

        swal.fire({
            title: '確定刪除?',
            text: "這是不可逆的",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '刪除'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = e.target.getAttribute('data-trash-id')
                $.ajax({
                    type: 'DELETE',
                    url: '/users/' + id,
                    processData: false, //prevents jQuery from parsing the data and throwing an Illegal Invocation error. JQuery does this when it encounters a file in the form and can not convert it to string
                    contentType: false, //prevents ajax sending the content type header. The content type header make Laravel handel the FormData Object as some serialized string.,
                    success: function (msg) {
                        if (msg.success) {
                            _courseTable.draw()
                            swal.fire(msg.message);
                            return
                        }
                        swal.fire('刪除失敗');
                    },
                    error: function () {
                        swal.fire('刪除失敗');
                    },
                });

            }
        })
    })


    // 狀態改變
    _courseTable.on("click", ".js-status-change", function () {

        let id = $(this).attr('id').split('-')[1];
        let status = $(this).attr('value');
        let title = +status === 1 ? '確認是否啟用會員？' : '確認是否停用會員？';
        let confirmText = +status === 1 ? '啟用' : '停用';
        let url = changeStatusUrl.replace('_id', id);

        console.log(id, status, changeStatusUrl, url)

        swal.fire({
            position: 'top-center',
            type: 'warning',
            title: title,
            confirmButtonClass: 'btn btn-pink',
            cancelButtonClass: 'btn btn-secondary',
            confirmButtonText: confirmText,
            cancelButtonText: '取消',
            reverseButtons: true,
            showCancelButton: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "put",
                    dataType: "json",
                    data: {status},
                    statusCode: {
                        404: function () {
                            swal.fire({
                                position: 'top-center',
                                type: 'warning',
                                title: '找不到頁面!'
                            });
                        },
                        403: function () {
                            swal.fire({
                                position: 'top-center',
                                type: 'error',
                                title: '無查詢權限!'
                            });
                        },
                        500: function () {
                            swal.fire({
                                position: 'top-center',
                                type: 'error',
                                title: '系統發生錯誤'
                            });
                        },
                    }
                }).done(function (response) {

                    if (!response.success) {
                        swal.fire({
                            position: 'top-center',
                            type: 'error',
                            title: response.message
                        });
                    } else {
                        swal.fire({
                            position: 'top-center',
                            type: 'success',
                            title: response.message
                        }).then(() => {
                            _courseTable.draw();
                        });
                    }
                }).fail(function (err) {
                    console.log(err)
                });
            }
        });
    });


});
