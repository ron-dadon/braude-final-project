<?php

namespace Application\Views\Quotes;

use Trident\MVC\AbstractView;
use Application\Entities\Client;
use Application\Entities\Product;
use Application\Entities\Quote;
use Application\Entities\QuoteStatus;

class Add extends AbstractView
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
        <h1><i class="fa fa-fw fa-plus"></i> New quote</h1>
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
    <form method="post" id="new-client-form" data-toggle="validator">
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
                            <input type="hidden" name="quote_date" value="<?php echo $quote->date ?>">
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="quote-expire">Expire at:</label>
                            <input type="date" id="quote-expire" name="quote_expire" class="form-control" value="<?php echo $this->escape(substr($quote->date, 0, 10)) ?>" min="<?php echo $this->escape(substr($quote->date, 0, 10)) ?>" required>
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
                                    <th width="1%" style="white-space: nowrap;">Currency</th>
                                    <th width="1%">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="quote-products-table">
                            </tbody>
                            <tfoot class="bg-info">
                                <tr>
                                    <td colspan="4" class="text-right"><button type="button" id="add-product" class="btn btn-default"><i class="fa fa-fw fa-plus"></i> Add product</button></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Discount(%):</td>
                                    <td><input type="number" name="quote_discount" min="0" max="100" step="0.05" value="0"></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Tax rate(%):</td>
                                    <td><input type="hidden" name="quote_tax" value="<?php echo $this->data['tax'] ?>"><?php echo $this->data['tax'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>USD rate:</td>
                                    <td><input type="hidden" name="quote_usd_rate" value="<?php echo $this->data['exchange-rate'] ?>"><?php echo $this->data['exchange-rate'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Total:</td>
                                    <td id="quote-total">0</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Tax:</td>
                                    <td id="quote-tax">0</td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Total + Tax:</td>
                                    <td id="quote-total-tax">0</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-footer text-right">
                <a href="<?php $this->publicPath() ?>Quotes" class="btn btn-link">Back</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Add quote</button>
            </div>
        </div>
    </form>
</div>
<script src="<?php $this->publicPath() ?>js/quotes/quote-new.js?<?php echo date('YmdHis') ?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('MessageModal')->render();
        $this->getSharedView('Footer')->render();
    }

} 