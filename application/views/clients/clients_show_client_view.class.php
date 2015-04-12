<?php


class Clients_Show_Client_View extends Trident_Abstract_View
{
    public function render()
    {
        $this->include_shared_view('header');
        $this->include_shared_view('navbar');
        /** @var Client_Entity $client */
        $client = $this->get('client');
        /** @var Contact_Entity[] $contact */
        $contacts = $this->get('contacts');
    ?>
    <script>
        function show_map()
        {
            $('#client-address').modal('show');
            document.getElementById('client-address-map').src = 'https://maps.google.com/maps?q=<?php echo str_replace(' ', '+', $client->address)?>&output=embed&iwloc';
        }
    </script>
    <div class="well well-sm top-fixed-header">
        <h2 class="no-margin"><i class="fa fa-fw fa-users"></i> לקוחות</h2>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php $this->public_path()?>">ראשי</a></li>
        <li><a href="<?php $this->public_path()?>/clients">לקוחות</a></li>
        <li class="active"><?php echo $this->escape($client->name)?></li>
    </ol>
    <?php if (($alert = $this->get('client-edit', false)) === true): ?>
    <div class="alert alert-success no-margin alert-dismissible fade in">
        <strong><i class="fa fa-fw fa-check-circle"></i> הפעולה בוצעה!</strong> המשתמש <strong><?php echo $this->get('client-edit-name') ?></strong> עודכן בהצלחה
    </div>
    <?php endif; ?>
    <?php if (($alert = $this->get('client-add', false)) === true): ?>
    <div class="alert alert-success no-margin alert-dismissible fade in">
        <strong><i class="fa fa-fw fa-check-circle"></i> הפעולה בוצעה!</strong> המשתמש <strong><?php echo $this->get('client-add-name') ?></strong> נוסף בהצלחה
    </div>
    <?php endif; ?>
    <?php if (($alert = $this->get('contact-add', false)) === true): ?>
    <div class="alert alert-success no-margin alert-dismissible fade in">
        <strong><i class="fa fa-fw fa-check-circle"></i> הפעולה בוצעה!</strong> איש הקשר <strong><?php echo $this->get('contact-add-name') ?></strong> נוסף בהצלחה
    </div>
    <?php endif; ?>
    <?php if (($alert = $this->get('contact-delete', false)) === true): ?>
    <div class="alert alert-success no-margin alert-dismissible fade in">
        <strong><i class="fa fa-fw fa-check-circle"></i> הפעולה בוצעה!</strong> איש הקשר <strong><?php echo $this->get('contact-delete-name') ?></strong> נמחק בהצלחה
    </div>
    <?php endif; ?>
    <?php if ($this->get('client-edit', false) === false): ?>
    <div class="alert alert-danger no-margin alert-dismissible fade in">
        <strong><i class="fa fa-fw fa-exclamation-circle"></i> הפעולה נכשלה!</strong> המשתמש <strong><?php echo $this->get('client-edit-name') ?></strong> לא עודכן בהצלחה
    </div>
    <?php endif; ?>
    <?php if ($this->get('contact-delete', false) === false): ?>
    <div class="alert alert-danger no-margin alert-dismissible fade in">
        <strong><i class="fa fa-fw fa-exclamation-circle"></i> הפעולה נכשלה!</strong> איש הקשר <strong><?php echo $this->get('contact-delete-name') ?></strong> לא נמחק בהצלחה
    </div>
    <?php endif; ?>
    <?php if ($this->get('contact-add', false) === false): ?>
    <div class="alert alert-danger no-margin alert-dismissible fade in">
        <strong><i class="fa fa-fw fa-exclamation-circle"></i> הפעולה נכשלה!</strong> איש הקשר <strong><?php echo $this->get('contact-add-name') ?></strong> לא נוסף בהצלחה
    </div>
    <?php endif; ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong class="font-125"><i class="fa fa-fw fa-user"></i> כרטיס לקוח:  <?php echo $this->escape($client->name)?></strong>
        </div>
        <div class="panel-body">
            <ul class="list-inline">
                <li><strong><i class="fa fa-fw fa-calendar"></i> תאריך יצירה:</strong> <?php echo $this->escape($this->sql_date_to_php($client->created_on))?></li>
                <li><strong><i class="fa fa-fw fa-map-marker"></i> כתובת:</strong> <a id="toggle-map" class="link-like" onclick="show_map()"><?php echo $this->escape($client->address)?></a></li>
                <li><strong><i class="fa fa-fw fa-phone"></i> טלפון:</strong> <a href="tel:+972<?php echo str_replace('-','',ltrim($this->escape($client->phone), '0'))?>"><?php echo $this->escape(($client->phone))?></a></li>
                <li><strong><i class="fa fa-fw fa-fax"></i> פקס:</strong> <?php echo $this->escape(($client->fax))?></li>
                <li><strong><i class="fa fa-fw fa-envelope"></i> דואר אלקטרוני:</strong> <a href="mailto:<?php echo $this->escape(($client->email))?>"><?php echo $this->escape(($client->email))?></a></li>
                <li><strong><i class="fa fa-fw fa-globe"></i> אתר אינטרנט:</strong> <a target="_blank" href="<?php echo $this->escape(($client->website))?>"><?php echo $this->escape(($client->website))?></a></li>
                <li><a href="<?php $this->public_path()?>/clients/edit/<?php echo $client->id?>" class="btn btn-info btn-sm"><i class="fa fa-fw fa-pencil"></i> ערוך לקוח</a></li>
            </ul>
        </div>
        <div class="panel-heading">
            <strong class="font-125"><i class="fa fa-fw fa-user"></i> אנשי קשר: <?php echo $this->escape($client->name)?></strong>
        </div>
        <?php if (count($contacts) === 0): ?>
        <div class="panel-body">
            <p class="text-center">אין אנשי קשר ללקוח</p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table id="contacts-table" class="table table-condensed table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th data-column-id="contact_id" data-type="numeric">מספר</th>
                        <th data-column-id="contact_first_name" data-order="asc">שם פרטי</th>
                        <th data-column-id="contact_last_name">שם משפחה</th>
                        <th data-column-id="contact_phone">טלפון</th>
                        <th data-column-id="contact_fax">פקס</th>
                        <th data-column-id="contact_email">דואר אלקטרוני</th>
                        <th data-column-id="contact_position">תפקיד</th>
                        <th data-column-id="contact_actions" data-formatter="contact_action_buttons" data-sortable="false">פעולות</th>
                    </tr>
                    <tr id="pre-load-table">
                        <td colspan="8" class="text-center"><i class="fa fa-spinner fa-spin"></i> טוען נתונים...</td>
                    </tr>
                </thead>
                <tbody class="hidden">
                <?php /** @var Contact_Entity $contact */ foreach ($contacts as $contact): ?>
                    <tr>
                        <td class="fit"><?php echo $contact->id ?></td>
                        <td><?php echo $contact->first_name ?></td>
                        <td><?php echo $contact->last_name ?></td>
                        <td><?php echo $contact->phone ?></td>
                        <td><?php echo $contact->fax ?></td>
                        <td><?php echo $contact->email ?></td>
                        <td><?php echo $contact->position ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <div class="panel-footer">
            <div class="row">
                <div class="col-xs-12 text-left">
                    <div class="btn-group">
                        <a href="<?php $this->public_path()?>/clients/export-contacts/<?php echo $client->id?>" class="btn btn-default"><i class="fa fa-fw fa-file-excel-o"></i> יצא רשימה</a>
                        <a href="<?php $this->public_path()?>/clients/add-contact/<?php echo $client->id?>" class="btn btn-success"><i class="fa fa-fw fa-user-plus"></i> הוספת איש קשר</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
        </div>
        <div class="panel-heading">
            <strong class="font-125"><i class="fa fa-fw fa-file-text"></i> הצעות מחיר פתוחות: <?php echo $this->escape($client->name)?></strong>
        </div>
        <div class="panel-body">
        <?php if ($this->get('client-open-quotes') === null): ?>
            <p class="text-center">אין הצעות מחיר פתוחות ללקוח</p>
        <?php endif; ?>
        </div>
        <div class="panel-heading">
            <strong class="font-125"><i class="fa fa-fw fa-money"></i> חשבוניות עסקה פתוחות: <?php echo $this->escape($client->name)?></strong>
        </div>
        <div class="panel-body">
        <?php if ($this->get('client-open-invoices') === null): ?>
            <p class="text-center">אין חשבוניות עסקה פתוחות ללקוח</p>
        <?php endif; ?>
        </div>
    </div>
    <!-- Google Maps Modal -->
    <div class="modal fade" id="client-address" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?php echo $this->escape($client->name)?></h4>
                </div>
                <div class="modal-body">
                    <iframe id="client-address-map" width="100%" height="300" frameborder="0" style="display:block; border:0"></iframe>
                </div>
                <div class="modal-footer">
                    <a href="waze://?q=<?php echo str_replace(' ', '%20', $client->address)?>" class="btn btn-primary"><i class="fa fa-fw fa-map-marker"></i> נווט בעזרת WAZE</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Client Modal -->
    <div class="modal fade" id="contact-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">מחיקת איש קשר: <strong><span id="delete-contact-name"></span></strong></h4>
                </div>
                <div class="modal-body">
                    <p>האם אתה בטוח שברצונך לבצע פעולה זו? שים לב - פעולה זו אינה נתנת לביטול.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-fw fa-times"></i> בטל</button>
                    <a href="" class="btn btn-danger" id="delete-contact-link"><i class="fa fa-fw fa-trash"></i> מחק איש קשר</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function show_delete_confirm(c_name, c_id)
        {
            console.log(c_name);
            $('#delete-contact-name').html(c_name);
            $('#delete-contact-link').attr('href', '<?php $this->public_path()?>/clients/contacts/delete/' + c_id);
            $('#contact-delete').modal('show');
        }
        $('#contacts-table').bootgrid({
            formatters: {
                "contact_action_buttons": function(column, row)
                {
                    return '<div class="actions">' +
                    '<a href="<?php $this->public_path()?>/clients/contacts/show/' + row.contact_id + '" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-user"></i> הצג</a>' +
                    '<a href="<?php $this->public_path()?>/clients/contacts/edit/' + row.contact_id + '" class="btn btn-xs btn-info margin-sides-5px"><i class="fa fa-fw fa-pencil"></i> ערוך</a>' +
                    '<a onclick="show_delete_confirm(\'' + row.contact_first_name.replace('\'', '\\\'') + ' ' + row.contact_last_name + '\',' + row.contact_id + ')" class="btn btn-xs btn-danger"><i class="fa fa-fw fa-trash"></i> מחק</a>' +
                    '</div>';
                }
            },
            labels: {
                "search": "חפש איש קשר..."
            }
        }).on("loaded.rs.jquery.bootgrid", function (e)
        {
            $('#pre-load-table').remove();
            $('#contacts-table tbody').removeClass('hidden');
        });
    </script>
    <?php
        $this->include_shared_view('footer');
        /*src="https://www.google.com/maps/embed/v1/search?key=AIzaSyDmBQ5TM9OZolddck5E0H3TIb7m_nk04sI&q=<?php echo str_replace(' ', '+', $client->address)?>">*/
    }
}