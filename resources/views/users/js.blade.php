let resourceDatatable = $('#resources-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: $('#resources-table').data('route'),
        method: 'POST',
        data: function (data) {
            data.datatable_search = $('#resources-table_filter input').val()
        },
    },
    columns: [
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'actions', name: 'actions' },
    ],
    initComplete: function () {
        $('#resources-table_filter input').unbind();
        $('#resources-table_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) resourceDatatable.ajax.reload()
        })
    },
})

