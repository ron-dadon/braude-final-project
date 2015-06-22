/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

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