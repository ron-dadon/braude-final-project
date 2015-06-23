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
use Application\Entities\Client;
use Application\Entities\Contact;

/**
 * Class Show
 *
 * Show a client.
 *
 * @package Application\Views\Clients
 */
class Show extends AbstractView
{

    /**
     * Render a client.
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
        <h1><i class="fa fa-fw fa-user"></i> Client: <?php echo $this->escape($client->name) ?></h1>
    </div>
<?php if (isset($this->data['error'])): ?>
    <div class="alert alert-dismissable alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4><i class="fa fa-fw fa-times-circle"></i><?php echo $this->escape($this->data['error']) ?></h4>
    </div>
<?php endif; ?>
    <?php if (isset($this->data['success'])): ?>
        <div class="alert alert-success alert-dismissable">
            <h4><i class="fa fa-fw fa-check-circle"></i><?php echo $this->data['success'] ?></h4>
        </div>
    <?php endif; ?>
    <div class="panel">
        <div class="row">
            <div class="col-xs-12 col-lg-6">
                <h3 class="bg-main margin-bottom padded-5px"><i class="fa fa-fw fa-suitcase"></i> Contact information:</h3>
                <p><strong><i class="fa fa-fw fa-phone"></i> Phone:</strong> <?php echo $this->escape($client->phone) ?></p>
                <p><strong><i class="fa fa-fw fa-map-marker"></i> Address:</strong> <?php echo $this->escape($client->address) ?></p>
                <p><strong><i class="fa fa-fw fa-envelope"></i> E-Mail:</strong> <?php echo $this->escape($client->email) ?></p>
                <p><strong><i class="fa fa-fw fa-globe"></i> Web site:</strong> <?php echo $this->escape($client->webSite) ?></p>
            </div>
            <div class="col-xs-12 col-lg-6">
                <div class="embed-responsive embed-responsive-16by9" id="client-map">
                    <iframe class="embed-responsive-item" src="https://maps.google.com/maps?q=<?php echo str_replace(' ', '+', $client->address)?>&output=embed"></iframe>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <a href="<?php $this->publicPath() ?>Quotes/New/<?php echo $client->id ?>" class="btn btn-default"><i class="fa fa-fw fa-file-text"></i>Create quote</a>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="panel">
        <div class="panel-footer text-right">
            <a href="<?php $this->publicPath() ?>Clients" class="btn btn-link hidden-xs">Back</a>
            <a href="<?php $this->publicPath() ?>Clients/Update/<?php echo $client->id ?>" class="btn btn-primary hidden-xs"><i class="fa fa-fw fa-edit"></i> Update client</a>
            <a href="<?php $this->publicPath() ?>Clients/Update/<?php echo $client->id ?>" class="btn btn-primary btn-block visible-xs"><i class="fa fa-fw fa-edit"></i> Update client</a>
            <a href="<?php $this->publicPath() ?>Clients" class="btn btn-link btn-block visible-xs">Back</a>
        </div>
    </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/clients/client-show.js?<?php echo date('YmdHis') ?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('MessageModal')->render();
        $this->getSharedView('Footer')->render();
    }

}