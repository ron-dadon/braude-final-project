<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Products;

use Trident\MVC\AbstractView;
use Application\Entities\Product;

/**
 * Class Show
 *
 * Show product.
 *
 * @package Application\Views\Products
 */
class Show extends AbstractView
{

    /**
     * Render product.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
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
    <?php if (isset($this->data['success'])): ?>
        <div class="alert alert-success alert-dismissable">
            <h4><i class="fa fa-fw fa-check-circle"></i><?php echo $this->data['success'] ?></h4>
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
                        <label for="product-base-price">Price:</label>
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
    <div class="row">
        <div class="panel">
            <div class="panel-footer text-right">
                <a href="<?php $this->publicPath() ?>Products" class="btn btn-link hidden-xs">Back</a>
                <a href="<?php $this->publicPath() ?>Products/Update/<?php echo $product->id ?>" class="btn btn-primary hidden-xs"><i class="fa fa-fw fa-edit"></i> Update product</a>
                <a href="<?php $this->publicPath() ?>Products/Update/<?php echo $product->id ?>" class="btn btn-primary  visible-xs"><i class="fa fa-fw fa-edit"></i> Update product</a>
                <a href="<?php $this->publicPath() ?>Products" class="btn btn-link btn-block visible-xs">Back</a>
            </div>
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