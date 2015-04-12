<?php


class Clients_Index_View extends Trident_Abstract_View
{
    public function render()
    {
        $this->include_shared_view('header');
        $this->include_shared_view('navbar');
    ?>
    <div class="well well-sm top-fixed-header">
        <h2 class="no-margin"><i class="fa fa-fw fa-users"></i> לקוחות</h2>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php $this->public_path()?>">ראשי</a></li>
        <li class="active">לקוחות</li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong class="font-125"><i class="fa fa-fw fa-users"></i> רשימת לקוחות</strong>
        </div>
        <?php if (($alert = $this->get('client-delete', false)) === true): ?>
        <div class="alert alert-success alert-dismissible fade in">
            <strong><i class="fa fa-fw fa-check-circle"></i> הפעולה בוצעה!</strong> המשתמש <strong><?php echo $this->escape($this->get('client-delete-name')) ?></strong> נמחק בהצלחה
        </div>
        <?php endif; ?>
        <?php if ($this->get('client-delete', false) === false): ?>
        <div class="alert alert-danger alert-dismissible fade in">
            <strong><i class="fa fa-fw fa-exclamation-circle"></i> הפעולה נכשלה!</strong> המשתמש <strong><?php echo $this->escape($this->get('client-delete-name')) ?></strong> לא נמחק בהצלחה
        </div>
        <?php endif; ?>
        <?php if (($clients = $this->get('clients-list')) === null): ?>
        <div class="alert alert-danger">
            <strong><i class="fa fa-fw fa-exclamation-circle"></i> שגיאה!</strong> לא ניתן לקרוא את נתוני הלקוחות ממסד הנתונים
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table id="clients-table" class="table table-condensed table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th data-column-id="client_id" data-type="numeric">מספר לקוח</th>
                        <th data-column-id="client_name" data-order="asc">שם לקוח</th>
                        <th data-column-id="client_address">כתובת</th>
                        <th data-column-id="client_phone">טלפון</th>
                        <th data-column-id="client_fax">פקס</th>
                        <th data-column-id="client_email">דואר אלקטרוני</th>
                        <th data-column-id="client_website">אתר אינטרנט</th>
                        <th data-column-id="client_actions" data-formatter="client_action_buttons" data-sortable="false">פעולות</th>
                    </tr>
                    <tr id="pre-load-table">
                        <td colspan="8" class="text-center"><i class="fa fa-spinner fa-spin"></i> טוען נתונים...</td>
                    </tr>
                </thead>
                <tbody class="hidden">
                <?php /** @var Client_Entity $client */ foreach ($clients as $client): ?>
                    <tr>
                        <td class="fit"><?php echo $client->id ?></td>
                        <td><?php echo $client->name ?></td>
                        <td><?php echo $client->address ?></td>
                        <td><?php echo $client->phone ?></td>
                        <td><?php echo $client->fax ?></td>
                        <td><?php echo $client->email ?></td>
                        <td><?php echo $client->website ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-xs-12 text-left">
                        <div class="btn-group">
                            <a href="<?php $this->public_path()?>/clients/export" class="btn btn-default"><i class="fa fa-fw fa-file-excel-o"></i> יצא רשימה</a>
                            <a href="<?php $this->public_path()?>/clients/add" class="btn btn-success"><i class="fa fa-fw fa-user-plus"></i> הוספת לקוח</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <!-- Delete Client Modal -->
    <div class="modal fade" id="client-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">מחיקת לקוח: <strong><span id="delete-client-name"></span></strong></h4>
                </div>
                <div class="modal-body">
                    <p>האם אתה בטוח שברצונך לבצע פעולה זו? שים לב - פעולה זו אינה נתנת לביטול.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-fw fa-times"></i> בטל</button>
                    <a href="" class="btn btn-danger" id="delete-client-link"><i class="fa fa-fw fa-trash"></i> מחק לקוח</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function show_delete_confirm(c_name, c_id)
        {
            $('#delete-client-name').html(c_name);
            $('#delete-client-link').attr('href', '<?php $this->public_path()?>/clients/delete/' + c_id);
            $('#client-delete').modal('show');
        }
        $('#clients-table').bootgrid({
            formatters: {
                "client_action_buttons": function(column, row)
                {
                    return '<div class="actions">' +
                    '<a href="<?php $this->public_path()?>/clients/show/' + row.client_id + '" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-user"></i> הצג</button>' +
                    '<a href="<?php $this->public_path()?>/clients/edit/' + row.client_id + '" class="btn btn-xs btn-info margin-sides-5px"><i class="fa fa-fw fa-pencil"></i> ערוך</button>' +
                    '<a onclick="show_delete_confirm(\'' + row.client_name + '\',' + row.client_id + ')" class="btn btn-xs btn-danger"><i class="fa fa-fw fa-trash"></i> מחק</button>' +
                    '</div>';
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function (e)
        {
            $('#pre-load-table').remove();
            $('#clients-table tbody').removeClass('hidden');
        });
    </script>
    <?php
        $this->include_shared_view('footer');
    }
}