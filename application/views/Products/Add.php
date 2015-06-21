<?php


namespace Application\Views\Products;

use Application\Entities\Product;
use Application\Entities\LicenseType;
use Trident\MVC\AbstractView;

class Add extends AbstractView
{
    public function render()
    {
        /** @var Product $product */
        $product = $this->data['product'];
        /** @var LicenseType[] $licenseTypes */
        $licenseTypes = $this->data['license-types'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-plus"></i> New product</h1>
    </div>
<?php if (isset($this->data['error'])): ?>
    <div class="alert alert-dismissable alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 <?php if ($product->getErrors() !== null && count($product->getErrors()) > 0): ?>class="margin-bottom"<?php endif; ?>>
            <i class="fa fa-fw fa-times-circle"></i><?php echo $this->data['error'] ?></h4>
<?php if ($product->getErrors() !== null && count($product->getErrors()) > 0): ?>
            <ul>
<?php foreach ($product->getErrors() as $error): ?>
                <li><?php echo $error ?></li>
<?php endforeach; ?>
            </ul>
<?php endif; ?>
    </div>
<?php endif; ?>
    <form method="post" id="new-client-form" data-toggle="validator">
        <div class="panel">
            <div class="panel-heading">
                <h3>Product details:</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="product-manufactor">Manufacturer:</label>
                            <select id="product-manufactor" name="product_manufactor" class="form-control">
                                <option value="iacs" <?php if ($product->manufactor === "iacs"): ?>selected<?php endif; ?>>IACS</option>
                                <option value="caseware" <?php if ($product->manufactor === "caseware"): ?>selected<?php endif; ?>>CaseWare</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="product-type">Type:</label>
                            <select id="product-type" name="product_type" class="form-control">
                                <option value="software" <?php if ($product->type === "software"): ?>selected<?php endif; ?>>Software</option>
                                <option value="training" <?php if ($product->type === "training"): ?>selected<?php endif; ?>>Training</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <div class="form-group">
                            <label for="product-name">Name:</label>
                            <input type="text" id="product-name" name="product_name" class="form-control" value="<?php echo $this->escape($product->name) ?>" required data-error="Please enter the product name">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="product-basePrice">Base price:</label>
                            <input type="number" id="product-basePrice" name="product_basePrice" class="form-control" value="<?php echo $this->escape($product->basePrice) ?>" required min="0" data-error="Please enter a valid price">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="product-coin">Coin:</label>
                            <select id="product-coin" name="product_coin" class="form-control">
                                <option value="usd" <?php if ($product->coin === "usd"): ?>selected<?php endif; ?>>USD $</option>
                                <option value="nis" <?php if ($product->coin === "nis"): ?>selected<?php endif; ?>>NIS &#8362;</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="product-description">Description:</label>
                            <textarea id="product-description" name="product_description" class="form-control"><?php echo $this->escape($product->description) ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row <?php if ($product->type !== "software"): ?>hidden<?php endif; ?>" id="software-details">
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="product-license-type">License type:</label>
                            <select id="product-license-type" name="product_license" class="form-control" autofocus>
<?php foreach ($licenseTypes as $licenseType): ?>
                                <option value="<?php echo $licenseType->id ?>" <?php if ($product->license !== null && $product->license->id === $licenseType->id): ?>selected<?php endif; ?>><?php echo $this->escape($licenseType->name) ?></option>
<?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="product-version">Version:</label>
                            <input type="text" id="product-version" name="product_version" class="form-control" value="<?php echo $this->escape($product->version) ?>" pattern="^[0-9a-zA-Z\.\s]{0,20}$" data-error="Please enter a valid product version">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row <?php if ($product->type !== "training"): ?>hidden<?php endif; ?>" id="training-details">
                    <div class="col-xs-12 col-lg-3">
                        <div class="form-group">
                            <label for="product-length">Training length:</label>
                            <input type="number" id="product-length" name="product_length" class="form-control" value="<?php echo $this->escape($product->length) ?>" min="1" data-error="Please enter training length in hours. Minimum 1 hour.">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-footer text-right">
                <a href="<?php $this->publicPath() ?>Products" class="btn btn-link">Back</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Add product</button>
            </div>
        </div>
    </form>
</div>
<script src="<?php $this->publicPath() ?>js/products/products-new.js?<?php echo date('YmdHis') ?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('MessageModal')->render();
        $this->getSharedView('Footer')->render();
    }

} 