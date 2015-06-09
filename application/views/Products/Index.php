<?php

namespace Application\Views\Products;

use \Trident\MVC\AbstractView;
use \Application\Entities\Product;

class Index extends AbstractView
{

    public function render()
    {
        /** @var Product[] $clients */
        $products = $this->data['products'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-cubes"></i> Products</h1>
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
    <div id="alerts-container"></div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table table-bordered" id="products-table">
                <thead>
                <tr>
                    <th data-column-id="id" data-identifier="true">ID</th>
                    <th data-column-id="productType">Type</th>
                    <th data-column-id="productName" data-order="asc" data-formatter="productLink">Name</th>
                    <th data-column-id="basePrice">Base price</th>
                    <th data-column-id="coin">Coin</th>
                    <th data-column-id="actions" data-sortable="false" data-formatter="productActions">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr data-user-id="<?php echo $product->id ?>">
                        <td><?php echo $product->id ?></td>
                        <td><?php echo $product->type === "software" ? "Software" : "Training" ?></td>
                        <td><?php echo $this->escape($product->name) ?></td>
                        <td><?php echo number_format($product->basePrice, 0) ?></td>
                        <td><?php echo $product->coin === "usd" ? "USD $" : "NIS &#8362;" ?></td>
                        <td>Actions</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer text-right">
            <a href="<?php $this->publicPath() ?>Products/New" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> New product</a>
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/products/index.js"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('Footer')->render();
    }

}