<?php

namespace Application\Views\Products;

use Trident\MVC\AbstractView;
use Application\Entities\Product;

class Show extends AbstractView
{

    public function render()
    {
        /** @var Product $product */
        $product = $this->data['product'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-cubes"></i> Product: <?php echo $this->escape($product->name) ?></h1>
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
            <div class="col-xs-12">
                <div class="col-xs-12 col-lg-2">
                    <div class="form-group">
                        <label for="product-type">Type:</label>
                        <p class="form-control-static" id="product-type"><strong><?php echo $this->escape(ucfirst($product->type)) ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <div class="form-group">
                        <label for="product-name">Name:</label>
                        <p class="form-control-static" id="product-name"><strong><?php echo $this->escape($product->name) ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-2">
                    <div class="form-group">
                        <label for="product-base-price">Base price:</label>
                        <p class="form-control-static" id="product-base-price"><strong><?php echo number_format($product->basePrice) ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-2">
                    <div class="form-group">
                        <label for="product-coin">Coin:</label>
                        <p class="form-control-static" id="product-coin"><strong><?php echo $product->coin === "usd" ? "USD $" : "NIS &#8362;" ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="product-coin">Description:</label>
                        <p class="form-control-static" id="product-description"><strong><?php echo $this->escape(str_replace(PHP_EOL, "<br>", $product->description)); ?></strong></p>
                    </div>
                </div>
<?php if ($product->type === "software"): ?>
                <div class="col-xs-12 col-lg-2">
                    <div class="form-group">
                        <label for="product-version">Version:</label>
                        <p class="form-control-static" id="product-version"><strong><?php echo $this->escape($product->version) ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-2">
                    <div class="form-group">
                        <label for="product-license">License type:</label>
                        <p class="form-control-static" id="product-license"><strong><?php echo $this->escape($product->license->name) ?></strong></p>
                    </div>
                </div>
<?php else: ?>
                <div class="col-xs-12 col-lg-2">
                    <div class="form-group">
                        <label for="product-length">Training length:</label>
                        <p class="form-control-static" id="product-length"><strong><?php echo $this->escape($product->length) ?> hours</strong></p>
                    </div>
                </div>
<?php endif; ?>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-footer text-right">
            <a href="<?php $this->publicPath() ?>Products" class="btn btn-link">Back</a>
            <a href="<?php $this->publicPath() ?>Products/Update/<?php echo $product->id ?>" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i> Update product</a>
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/products/product-show.js?<?php echo date('YmdHis') ?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('MessageModal')->render();
        $this->getSharedView('Footer')->render();
    }

} 