<?php


class Clients_Add_Client_View extends Trident_Abstract_View
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
        <li><a href="<?php $this->public_path()?>/clients">לקוחות</a></li>
        <li class="active">הוספת לקוח</li>
    </ol>
    <?php if ($this->get('client-add-error', false) === true): ?>
    <div class="alert alert-danger no-margin alert-dismissible fade in">
        <strong><i class="fa fa-fw fa-exclamation-circle"></i> הפעולה נכשלה!</strong> לא ניתן להוסיף את המשתמש
    </div>
    <?php endif; ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong class="font-125"><i class="fa fa-fw fa-user"></i>פרטי לקוח:</strong>
        </div>
        <div class="panel-body">
            <form id="add-client-form" method="post" data-toggle="validator">
                <div class="form-group col-xs-12 col-lg-3">
                    <label>שם לקוח</label>
                    <input type="text" class="form-control" name="client_name" required data-maxlength="128" autofocus placeholder="שם לקוח">
                    <div class="help-block with-errors">עד 128 תווים</div>
                </div>
                <div class="form-group col-xs-12 col-lg-3">
                    <label>כתובת לקוח</label>
                    <input type="text" class="form-control" name="client_address" required data-maxlength="128" placeholder="כתובת לקוח">
                    <div class="help-block with-errors">עד 128 תווים</div>
                </div>
                <div class="form-group col-xs-12 col-lg-3">
                    <label>טלפון לקוח</label>
                    <input type="tel" class="form-control" name="client_phone" required pattern="^0[0-9]{1,2}\-[0-9]{7}$" data-maxlength="11" placeholder="טלפון לקוח">
                    <div class="help-block with-errors">פורמט #######-##?</div>
                </div>
                <div class="form-group col-xs-12 col-lg-3">
                    <label>פקס לקוח</label>
                    <input type="tel" class="form-control" name="client_fax" required pattern="^0[0-9]{1,2}\-[0-9]{7}$" data-maxlength="11" placeholder="פקס לקוח">
                    <div class="help-block with-errors">פורמט #######-##?</div>
                </div>
                <div class="form-group col-xs-12 col-lg-3">
                    <label>דואר אלקטרוני לקוח</label>
                    <input type="email" class="form-control" name="client_email" required data-maxlength="255" placeholder="דואר אלקטרוני לקוח">
                    <div class="help-block with-errors">יש להזין כתובת דואר אלקטרוני חוקית</div>
                </div>
                <div class="form-group col-xs-12 col-lg-3">
                    <label>אתר אינטרנט לקוח</label>
                    <input type="url" class="form-control" name="client_website" required data-maxlength="255" placeholder="אתר אינטרנט לקוח">
                    <div class="help-block with-errors">יש להזין כתובת אתר אינטרנט חוקית</div>
                </div>
            </form>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-xs-12 text-left">
                    <a href="<?php $this->public_path()?>/clients" class="btn btn-link">בטל</a>
                    <button type="button" onclick="$('#add-client-form').submit()" class="btn btn-success"><i class="fa fa-fw fa-check"></i> הוסף לקוח</button>
                </div>
            </div>
        </div>
    </div>
    <?php
        $this->include_shared_view('footer');
    }
}