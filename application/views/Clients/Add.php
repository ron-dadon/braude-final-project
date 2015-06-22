<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Clients;

use \Trident\MVC\AbstractView;
use \Application\Entities\Client;

/**
 * Class Add
 *
 * Show add client form.
 *
 * @package Application\Views\Clients
 */
class Add extends AbstractView
{

    /**
     * Render add client form.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var Client $client */
        $client = $this->data['client'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
        <div class="container-fluid">
            <div class="page-head bg-main">
                <h1><i class="fa fa-fw fa-user-plus"></i> New client</h1>
            </div>
<?php if (isset($this->data['error'])): ?>
    <div class="alert alert-dismissable alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 <?php if ($client->getErrors() !== null && count($client->getErrors()) > 0): ?>class="margin-bottom"<?php endif; ?>>
            <i class="fa fa-fw fa-times-circle"></i><?php echo $this->data['error'] ?></h4>
<?php if ($client->getErrors() !== null && count($client->getErrors()) > 0): ?>
            <ul>
<?php foreach ($client->getErrors() as $error): ?>
                <li><?php echo $error ?></li>
<?php endforeach; ?>
            </ul>
<?php endif; ?>
    </div>
<?php endif; ?>
            <form method="post" id="new-client-form" data-toggle="validator">
                <div class="panel">
                    <div class="panel-heading">
                        <h3>Client details:</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-lg-3">
                                <div class="form-group">
                                    <label for="client-name">Name:</label>
                                    <input type="text" id="client-name" name="client_name" class="form-control" value="<?php echo $this->escape($client->name) ?>" required autofocus data-error="Please enter the client name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-3">
                                <div class="form-group">
                                    <label for="client-email">E-mail:</label>
                                    <input type="email" id="client-email" name="client_email" class="form-control" value="<?php echo $this->escape($client->email) ?>" data-error="Please enter a valid client email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-3">
                                <div class="form-group">
                                    <label for="client-address">Address:</label>
                                    <input type="text" id="client-address" name="client_address" class="form-control" value="<?php echo $this->escape($client->address) ?>" maxlength="200" data-error="Please enter client address">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-3">
                                <div class="form-group">
                                    <label for="client-phone">Phone:</label>
                                    <input type="text" id="client-phone" name="client_phone" class="form-control" value="<?php echo $this->escape($client->phone) ?>" pattern="^[0-9]{9,10}$|^[0-9]{2,3}\-[0-9]{7}$" data-error="Please enter a valid phone number">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-lg-3">
                                <div class="form-group">
                                    <label for="client-website">Web site:</label>
                                    <input type="text" id="client-website" name="client_webSite" class="form-control" value="<?php echo $this->escape($client->webSite) ?>" data-error="Please enter a valid web site address">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-lg-3">
                                <div class="form-group">
                                    <input type="checkbox" id="redirect-update" name="redirect_update">
                                    <label for="redirect-update">Go to client card after addition</label>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-footer text-right">
                        <a href="<?php $this->publicPath() ?>Clients" class="btn btn-link">Back</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Add client</button>
                    </div>
                </div>
            </form>
        </div>
        <script src="<?php $this->publicPath() ?>js/clients/client-new.js?<?php echo date('YmdHis') ?>"></script>
        <?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('MessageModal')->render();
        $this->getSharedView('Footer')->render();
    }

}