$(document).ready(function() {

    var searchForm = $('#search-form');
    var searchFromBtn = $('#search-btn');
    var searchUrl = searchForm.attr('action');
    var courseTable = $('#course-table');
    var _courseTable;
    var editUrl = courseTable.attr('data-edit-url');

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
            data: function(aoData) {
                //把分頁的參數與自訂的搜尋結合
                $.each(searchForm.serializeArray(), function(key, value) {
                    aoData[value.name] = value.value;
                });
                return aoData;
            },
            dataSrc: function ( json ) {
                //Make your callback here.
                return json.data;
            },
            error: function(xhr, error, code) {
                if (code == 'Forbidden') {
                    location.reload();
                } else if (xhr.status == 419) {
                    location.reload();
                }
            },
        },
        columns: [{
                data: 'name',
                width: '220px',
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
                mRender: function(data, type, full) {
                    return '<a href="' + editUrl.replace('_id', data.id) + '" class="btn btn-outline-primary btn-elevate btn-icon"><i class="la la-edit"></i></a>';
                }
            },
            {
                data: null,
                width: '20px',
                orderable: false,
                mRender: function(data, type, full) {
                    return '<a href="javascript:void(0)" class="btn btn-outline-primary btn-elevate btn-icon role-delete" data-trash-id="' + data.id + '"><i class="la la-trash" data-trash-id="' + data.id + '"></i></a>';
                }
            },
        ],
        "rowCallback": function(row, data, index) {

        },
    }

    // dataTableSettings.deferLoading = 0;
    _courseTable = courseTable.DataTable(dataTableSettings);

    searchFromBtn.on('click', function() {
        _courseTable.ajax.reload();
    });

    $(document).keypress(function(event) {
        if (event.which == '13') {
            event.preventDefault();
            _courseTable.ajax.reload();
        }
    });

    _courseTable.on('click', '.role-delete', function(e){
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
                    url: '/roles/' + id,
                    processData: false, //prevents jQuery from parsing the data and throwing an Illegal Invocation error. JQuery does this when it encounters a file in the form and can not convert it to string
                    contentType: false, //prevents ajax sending the content type header. The content type header make Laravel handel the FormData Object as some serialized string.,
                    success: function(msg) {
                        console.log(msg)
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






});
