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
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong class="font-125"><i class="fa fa-fw fa-users"></i> רשימת לקוחות</strong>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 text-left">
                    <div class="btn-group">
                        <button type="button" class="btn btn-success"><i class="fa fa-fw fa-user-plus"></i> הוספת לקוח</button>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-fw fa-cloud-download"></i> יצוא
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                <li><a href="#">Excel</a></li>
                                <li><a href="#">Csv</a></li>
                                <li><a href="#">Pdf</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                </thead>
                <tbody>
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
        </div>
        <?php endif; ?>
        <div class="panel-heading">
            <strong><i class="fa fa-fw fa-users"></i> לקוחות חייבים</strong>
        </div>
        <div class="panel-body">
            Results
        </div>
    </div>
    <script>
        $('#clients-table').bootgrid({
            formatters: {
                "client_action_buttons": function(column, row)
                {
                    return '' +
                    '<a href="<?php $this->public_path()?>/clients/edit/' + row.client_id + '" class="btn btn-xs btn-info table-action"><i class="fa fa-fw fa-pencil"></i><span class="action-label"> ערוך</span></button>' +
                    '<a href="<?php $this->public_path()?>/clients/delete/' + row.client_id + '" class="btn btn-xs btn-danger"><i class="fa fa-fw fa-trash"></i></button>' +
                    '<a href="<?php $this->public_path()?>/clients/contacts/' + row.client_id + '" class="btn btn-xs btn-default"><i class="fa fa-fw fa-users"></i></button>' +
                    '';
                }
            }
        });
    </script>
    <?php
        $this->include_shared_view('footer');
    }
}