<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Licenses;

use Application\Entities\License;
use Application\Entities\Product;
use Application\Entities\Client;
use Application\Entities\LicenseType;
use Trident\MVC\AbstractView;

/**
 * Class Update
 *
 * Show update license form.
 *
 * @package Application\Views\Licenses\
 */
class Update extends AbstractView
{

    /**
     * Render update license form.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var License $license */
        $license = $this->data['license'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-key"></i> Update license: <?php echo $this->escape($license->serial) ?></h1>
    </div>
<?php if (isset($this->data['error'])): ?>
    <div class="alert alert-dismissable alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 <?php if ($license->getErrors() !== null && count($license->getErrors()) > 0): ?>class="margin-bottom"<?php endif; ?>>
            <i class="fa fa-fw fa-times-circle"></i><?php echo $this->data['error'] ?></h4>
<?php if ($license->getErrors() !== null && count($license->getErrors()) > 0): ?>
            <ul>
<?php foreach ($license->getErrors() as $error): ?>
                <li><?php echo $error ?></li>
<?php endforeach; ?>
            </ul>
<?php endif; ?>
    </div>
<?php endif; ?>
    <form method="post" id="update-license-form" data-toggle="validator">
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
        </div>
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="license-expire">Expiration date:</label>
                            <input type="date" id="license-expire" name="license_expire" class="form-control" value="<?php echo $this->escape(substr($license->expire, 0, 10)) ?>" min="<?php echo date('Y-m-d') ?>" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-footer text-right">
                <div class="hidden-xs">
                    <a href="<?php $this->publicPath() ?>Licenses/Show/<?php echo $license->id ?>" class="btn btn-link">Back</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> Update</button>
                </div>
                <div class="visible-xs">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-fw fa-check"></i> Update</button>
                    <a href="<?php $this->publicPath() ?>Licenses/Show/<?php echo $license->id ?>" class="btn btn-link btn-block">Back</a>
                </div>
            </div>
        </div>
    </form>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

} 