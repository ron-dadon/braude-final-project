/*
 * Administration users
 */

$(document).on('ready', function() {
    $('#users-table').bootgrid({
        formatters: {
            "userActions": function (column, row) {
                return '<button class="btn btn-xs btn-default btn-user-delete" data-delete-id="' + row.id + '"><i class="fa fa-fw fa-trash"></i></button>' +
                '<button class="btn btn-xs btn-default btn-user-edit" data-edit-id="' + row.id + '"><i class="fa fa-fw fa-edit"></i></button>';
            }
        }
    });
});