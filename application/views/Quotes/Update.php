<?php

namespace Application\Views\Quotes;

use Trident\MVC\AbstractView;
use Application\Entities\Client;
use Application\Entities\Product;
use Application\Entities\Quote;
use Application\Entities\QuoteStatus;

class Update extends AbstractView
{

    public function render()
    {
        /** @var Quote $quote */
        $quote = $this->data['quote'];
        /** @var QuoteStatus[] $statues */
        $statues = $this->data['statuses'];
        /** @var Client[] $clients */
        $clients = $this->data['clients'];
        /** @var Product[] $products */
        $products = $this->data['products'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-database"></i> Update quote: <?php echo str_pad($quote->id, 8, '0', STR_PAD_LEFT) ?></h1>
    </div>
<?php if (isset($this->data['error'])): ?>
        <div class="alert alert-dismissable alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 <?php if ($quote->getErrors() !== null && count($quote->getErrors()) > 0): ?>class="margin-bottom"<?php endif; ?>>
                <i class="fa fa-fw fa-times-circle"></i><?php echo $this->data['error'] ?></h4>
<?php if ($quote->getErrors() !== null && count($quote->getErrors()) > 0): ?>
                <ul>
<?php foreach ($quote->getErrors() as $error): ?>
                    <li><?php echo $error ?></li>
<?php endforeach; ?>
                </ul>
<?php endif; ?>
        </div>
<?php endif; ?>
<?php if (isset($this->data['success'])): ?>
    <div class="alert alert-success alert-dismissable">
        <h4><i class="fa fa-fw fa-check-circle"></i><?php echo $this->data['success'] ?></h4>
    </div>
<?php endif; ?>
    <form method="post" id="new-quote-form" data-toggle="validator">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="bg-main padded-5px">General information:</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="quote-date">Date:</label>
                            <p id="quote-date" class="form-control-static"><?php echo $this->escape($this->formatSqlDateTime(substr($quote->date, 0, 10), "Y-m-d", "d/m/Y")) ?></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="quote-expire">Expire at:</label>
                            <input type="date" id="quote-expire" name="quote_expire" class="form-control" value="<?php echo $this->escape(substr($quote->expire, 0, 10)) ?>" min="<?php echo $this->escape(substr($quote->date, 0, 10)) ?>" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-8">
                        <div class="form-group">
                            <label for="quote-client">Client:</label><br>
                            <select class="selectpicker" data-live-search="true" data-width="100%" id="quote-client" name="quote_client">
<?php foreach ($clients as $client): ?>
                                <option value="<?php echo $client->id ?>"<?php if ($quote->client !== null && $quote->client->id === $client->id):?>selected<?php endif; ?>><?php echo $this->escape($client->name) ?></option>
<?php endforeach; ?>
                            </select>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-main">
                                    <th>Product</th>
                                    <th width="1%">Price</th>
                                    <th width="1%">Currency</th>
                                    <th width="1%">Quantity</th>
                                    <th width="1%"></th>
                                </tr>
                            </thead>
                            <tbody id="quote-products-table">
<?php $i = 1; foreach ($quote->products as $product): ?>
                                <tr id="product-line-row-<?php echo $i; ?>">
                                    <td>
                                        <select class="selectpicker" data-live-search="true" data-width="100%" name="quote_products[]" id="product-line-<?php echo $i?>" data-id="<?php echo $i ?>">
                                        <?php foreach ($products as $p): ?>
                                            <option value="<?php echo $p->id; ?>" <?php if ($p->id === $product->product->id): ?>selected<?php endif; ?>><?php echo $p->name; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td class="products-prices" data-coin="<?php echo $product->product->coin ?>" data-quantity="<?php echo $product->quantity ?>" id="product-line-price-<?php echo $i; ?>"><?php echo number_format($product->product->basePrice); ?></td>
                                    <td id="product-line-coin-<?php echo $i; ?>"><?php echo $product->product->coin ?></td>
                                    <td>
                                        <input type="number" class="form-control" name="product_quantity[]" id="product-quantity-<?php echo $i; ?>" value="<?php echo $product->quantity ?>" min="1" data-id="<?php echo $i; ?>">
                                    </td>
                                    <td>
                                        <button type="button" id="delete-row-<?php echo $i; ?>" data-delete-id="<?php echo $i++; ?>" class="btn btn-xs btn-danger"><i class="fa fa-fw fa-times"></i></button>
                                    </td>
                                </tr>
<?php endforeach; ?>
                            </tbody>
                            <tfoot class="bg-info">
                                <tr>
                                    <td colspan="5" class="text-right"><button type="button" id="add-product" class="btn btn-default"><i class="fa fa-fw fa-plus"></i> Add product</button></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>Discount(%):</td>
                                    <td><input type="number" name="quote_discount" id="quote-discount" min="0" max="100" step="0.5" value="0"></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>Tax rate(%):</td>
                                    <td><input type="hidden" name="quote_taxRate" value="<?php echo $this->data['tax'] ?>"><?php echo $this->data['tax'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>USD rate:</td>
                                    <td><input type="hidden" name="quote_usdRate" value="<?php echo $this->data['exchange-rate'] ?>"><?php echo $this->data['exchange-rate'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>Sub&nbsp;Total&nbsp;(NIS):</td>
                                    <td id="quote-total">0</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>Tax&nbsp;(NIS):</td>
                                    <td id="quote-tax">0</td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td>Total&nbsp;(NIS):</td>
                                    <td id="quote-total-tax">0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-heading">
                <h3 class="bg-main padded-5px">Notes:</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <textarea name="quote_note" class="form-control" style="resize: vertical"><?php echo $this->escape($quote->note) ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-footer text-right">
                <a href="<?php $this->publicPath() ?>Quotes" class="btn btn-link">Back</a>
                <button type="submit" class="btn btn-primary" id="add-quote-btn" disabled><i class="fa fa-fw fa-plus"></i> Save quote</button>
            </div>
        </div>
    </form>
</div>
<script>var productLines = <?php echo --$i; ?>;</script>
<script src="<?php $this->publicPath() ?>js/quotes/quote-update.js?<?php echo date('YmdHis') ?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('MessageModal')->render();
        $this->getSharedView('Footer')->render();
    }

} 