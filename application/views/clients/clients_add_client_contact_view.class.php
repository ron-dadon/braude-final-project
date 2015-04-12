<?php


class Clients_Add_Client_Contact_View extends Trident_Abstract_View
{
    public function render()
    {
        $this->include_shared_view('header');
        $this->include_shared_view('navbar');
        /** @var Client_Entity $client */
        $client = $this->get('client');
    ?>
    <div class="well well-sm top-fixed-header">
        <h2 class="no-margin"><i class="fa fa-fw fa-users"></i> לקוחות</h2>
    </div>
    <ol class="breadcrumb">
        <li><a href="<?php $this->public_path()?>">ראשי</a></li>
        <li><a href="<?php $this->public_path()?>/clients">לקוחות</a></li>
        <li><a href="<?php $this->public_path()?>/clients/show/<?php echo $client->id?>"><?php echo $client->name?></a></li>
        <li class="active">הוספת איש קשר</li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong class="font-125"><i class="fa fa-fw fa-user"></i><?php echo $client->name?> - פרטי איש קשר:</strong>
        </div>
        <div class="panel-body">
            <form id="add-contact-form" method="post" data-toggle="validator">
                <div class="form-group col-xs-12 col-lg-3">
                    <label>שם פרטי</label>
                    <input type="text" class="form-control" name="contact_first_name" required data-maxlength="20" autofocus placeholder="שם פרטי">
                    <div class="help-block with-errors">עד 20 תווים</div>
                </div>
                <div class="form-group col-xs-12 col-lg-3">
                    <label>שם משפחה</label>
                    <input type="text" class="form-control" name="contact_last_name" required data-maxlength="20" placeholder="שם משפחה">
                    <div class="help-block with-errors">עד 20 תווים</div>
                </div>
                <div class="form-group col-xs-12 col-lg-3">
                    <label>טלפון</label>
                    <input type="tel" class="form-control" name="contact_phone" required pattern="^0[0-9]{1,2}\-[0-9]{7}$" data-maxlength="11" placeholder="טלפון">
                    <div class="help-block with-errors">פורמט #######-##?</div>
                </div>
                <div class="form-group col-xs-12 col-lg-3">
                    <label>פקס</label>
                    <input type="tel" class="form-control" name="contact_fax" required pattern="^0[0-9]{1,2}\-[0-9]{7}$" data-maxlength="11" placeholder="פקס">
                    <div class="help-block with-errors">פורמט #######-##?</div>
                </div>
                <div class="form-group col-xs-12 col-lg-3">
                    <label>דואר אלקטרוני</label>
                    <input type="email" class="form-control" name="contact_email" required data-maxlength="255" placeholder="דואר אלקטרוני לקוח">
                    <div class="help-block with-errors">יש להזין כתובת דואר אלקטרוני חוקית</div>
                </div>
                <div class="form-group col-xs-12 col-lg-3">
                    <label>תפקיד</label>
                    <input type="text" class="form-control" name="contact_position" required data-maxlength="40" placeholder="תפקיד">
                    <div class="help-block with-errors">עד 40 תווים</div>
                </div>
            </form>
        </div>
        <div class="panel-footer">
            <div class="row">
                <div class="col-xs-12 text-left">
                    <a href="<?php $this->public_path()?>/clients/show/<?php echo $client->id?>" class="btn btn-link">בטל</a>
                    <button type="button" onclick="$('#add-contact-form').submit()" class="btn btn-success"><i class="fa fa-fw fa-check"></i> הוסף איש קשר</button>
                </div>
            </div>
        </div>
    </div>
    <?php
        $this->include_shared_view('footer');
    }
}