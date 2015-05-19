/*
 * Administration log
 */

$(document).on('ready', function() {
    $('#log-table').bootgrid({
        formatters: {
            "logLevel": function (column, row) {
                return '<span class="text-' + row.level + '"><i class="fa fa-fw fa-circle"></i></span>';
            }
        }
    });
});