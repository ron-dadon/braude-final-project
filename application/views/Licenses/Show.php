<?php

namespace Application\Views\Products;

use Trident\MVC\AbstractView;
use Application\Entities\License;

class Show extends AbstractView
{

    public function render()
    {
        /** @var License $license */
        $license = $this->data['license'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
        <div class="container-fluid">
            <div class="page-head bg-main">
                <h1><i class="fa fa-fw fa-cubes"></i> License: <?php echo $this->escape($license->serial) ?></h1>
            </div>
            <?php if (isset($this->data['error'])): ?>
                <div class="alert alert-dismissable alert-danger fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4><i class="fa fa-fw fa-times-circle"></i><?php echo $this->escape($this->data['error']) ?></h4>
                </div>
            <?php endif; ?>
            <div class="panel">
                <div class="row">
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="product-name">Product Name: </label>

                            <p class="form-control-static" id="product-name">
                                <strong><?php echo $this->escape($license->product->name) ?> hours</strong></p>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-12 col-lg-2">
                            <div class="form-group">
                                <label for="product-version">Version:</label>

                                <p class="form-control-static" id="product-version">
                                    <strong><?php echo $this->escape($license->product->version) ?></strong></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-6">
                            <div class="form-group">
                                <label for="client-name">Client Name:</label>

                                <p class="form-control-static" id="client-name">
                                    <strong><?php echo $this->escape($license->client->name) ?></strong></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-2">
                            <div class="form-group">
                                <label for="client-address">Client Address:</label>

                                <p class="form-control-static" id="client-address">
                                    <strong><?php echo($license->client->address) ?></strong></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-2">
                            <div class="form-group">
                                <label for="client-email">Client Email:</label>

                                <p class="form-control-static" id="client-email">
                                    <strong><?php echo $license->client->email ?></strong></p>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="license-type">License Type:</label>

                                <p class="form-control-static" id="license-type">
                                    <strong><?php echo $this->escape($license->type); ?></strong></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-2">
                            <div class="form-group">
                                <label for="creation-date">Creation Date:</label>

                                <p class="form-control-static" id="creation-date">
                                    <strong><?php echo $this->escape($license->creationDate) ?></strong></p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-2">
                            <div class="form-group">
                                <label for="expiration-date">Expiration Date:</label>

                                <p class="form-control-static" id="expiration-date">
                                    <strong><?php echo $this->escape($license->expire) ?></strong></p>
                            </div>
                        </div>
                        <?php if ($license->invoice !== null): ?>
                        <div class="col-xs-12 col-lg-2">
                            <div class="form-group">
                                <label for="license-invoice">Invoice:</label>

                                <p class="form-control-static" id="license-invoice">
                                    <strong><?php echo $this->escape($license->invoice) ?></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="panel">
                <div class="panel-footer text-right">
                    <a href="<?php $this->publicPath() ?>Licenses" class="btn btn-link">Back</a>
                    <a href="<?php $this->publicPath() ?>Licenses/Update/<?php echo $license->id ?>"
                       class="btn btn-primary"><i class="fa fa-fw fa-edit"></i> Update product</a>
                </div>
            </div>
        </div>
        <script src="<?php $this->publicPath() ?>js/Licenses/License-show.js?<?php echo date('YmdHis') ?>"></script>
        <?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('MessageModal')->render();
        $this->getSharedView('Footer')->render();


    }
} 