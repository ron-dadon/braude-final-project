<?php

namespace Application\Views\Licenses;

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
                <div class="alert alert-danger alert-dismissable">
                    <h4><i class="fa fa-fw fa-times-circle"></i><?php echo $this->data['error'] ?></h4>
                </div>
            <?php endif; ?>
            <?php if (isset($this->data['success'])): ?>
                <div class="alert alert-success alert-dismissable">
                    <h4><i class="fa fa-fw fa-check-circle"></i><?php echo $this->data['success'] ?></h4>
                </div>
            <?php endif; ?>
            <div class="panel">
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="bg-main padded-5px margin-bottom">Product information:</h3>
                    </div>
                    <div class="col-xs-12 col-lg-8">
                        <div class="form-group">
                            <label for="product-name">Product Name: </label>
                            <p class="form-control-static" id="product-name">
                                <strong><a href="<?php $this->publicPath() ?>Products/Show/<?php echo $license->product->id?>" title="Go to product"><?php echo $this->escape($license->product->name) ?></a></strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <div class="form-group">
                            <label for="product-version">Version:</label>
                            <p class="form-control-static" id="product-version">
                            <strong><?php echo $this->escape($license->product->version) ?></strong>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="bg-main padded-5px margin-bottom">Client information:</h3>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <div class="form-group">
                            <label for="client-name">Client Name:</label>
                            <p class="form-control-static" id="client-name">
                                <strong><a href="<?php $this->publicPath() ?>Clients/Show/<?php echo $license->client->id?>" title="Go to client"><?php echo $this->escape($license->client->name) ?></a></strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <div class="form-group">
                            <label for="client-address">Client Address:</label>

                            <p class="form-control-static" id="client-address">
                                <strong><?php echo($license->client->address) ?></strong></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <div class="form-group">
                            <label for="client-email">Client Email:</label>

                            <p class="form-control-static" id="client-email">
                                <strong><?php echo $license->client->email ?></strong></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <h3 class="bg-main padded-5px margin-bottom">License information:</h3>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="license-type">License Type:</label>
                            <p class="form-control-static" id="license-type">
                                <strong><?php echo $this->escape($license->type->name); ?></strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="creation-date">Creation Date:</label>
                            <p class="form-control-static" id="creation-date">
                                <strong><?php echo $this->formatSqlDateTime($license->creationDate, 'Y-m-d H:i:s', 'd/m/Y') ?></strong>
                            </p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="expiration-date">Expiration Date:</label>
                            <p class="form-control-static" id="expiration-date">
                                <strong><?php echo $this->formatSqlDateTime($license->expire, 'Y-m-d H:i:s', 'd/m/Y') ?></strong>
                            </p>
                        </div>
                    </div>
<?php if ($license->invoice !== null): ?>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="license-invoice">Invoice:</label>
                            <p class="form-control-static" id="license-invoice">
                                <strong><a href="<?php $this->publicPath() ?>Invoices/Show/<?php echo $license->invoice->id ?>" title="Go to invoice"><?php echo $this->escape(str_pad($license->invoice->id, 8, '0', STR_PAD_LEFT)) ?></a></strong>
                            </p>
                        </div>
                    </div>
<?php endif; ?>
                </div>
            </div>
            <div class="panel">
                <div class="panel-footer text-right">
                    <a href="<?php $this->publicPath() ?>Licenses" class="btn btn-link">Back</a>
                    <?php if ($license->product->manufactor === 'iacs'): ?>
                    <a href="<?php $this->publicPath() ?>Licenses/Download/<?php echo $license->id ?>" class="btn btn-success"><i class="fa fa-fw fa-download"></i> Download license</a>
                    <?php endif; ?>
                    <a href="<?php $this->publicPath() ?>Licenses/Update/<?php echo $license->id ?>" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i> Update license</a>
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