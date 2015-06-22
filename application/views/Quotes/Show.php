<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Quotes;

use Trident\MVC\AbstractView;
use Application\Entities\Quote;
use Application\Entities\QuoteProduct;

/**
 * Class Show
 *
 * Show quote.
 *
 * @package Application\Views\Quotes
 */
class Show extends AbstractView
{

    /**
     * Render quote.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var Quote $quote */
        $quote = $this->data['quote'];
        $total = 0;
        $subTotal = 0;
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-database"></i> Quote: <?php echo $this->escape(str_pad($quote->id, 8, '0', STR_PAD_LEFT)) ?></h1>
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
                <h3 class="bg-main padded-5px margin-bottom">Client</h3>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="quote-client-name">Name:</label>
                        <p class="form-control-static" id="quote-client-name"><strong><a href="<?php $this->publicPath() ?>Clients/Show/<?php echo $quote->client->id ?>"><?php echo $quote->client->name ?></a></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="quote-client-name">Address:</label>
                        <p class="form-control-static visible-xs" id="quote-client-name"><strong><a href="waze://?q=<?php echo $quote->client->address ?>"><?php echo $quote->client->address ?></a></strong></p>
                        <p class="form-control-static hidden-xs" id="quote-client-name"><strong><?php echo $quote->client->address ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="quote-client-name">Phone:</label>
                        <p class="form-control-static visible-xs" id="quote-client-name"><strong><a href="tel:<?php echo $quote->client->phone ?>"><?php echo $quote->client->phone ?></a></strong></p>
                        <p class="form-control-static hidden-xs" id="quote-client-name"><strong><?php echo $quote->client->phone ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="quote-client-name">E-Mail:</label>
                        <p class="form-control-static" id="quote-client-name"><strong><a href="mailto:<?php echo $quote->client->email ?>"><?php echo $quote->client->email ?></a></strong></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr class="bg-main">
                                <th width="1%" style="white-space: nowrap">Product ID</th>
                                <th>Product Name</th>
                                <th width="1%" style="white-space: nowrap">Product Price</th>
                                <th width="1%">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($quote->products as $product): ?>
                            <tr>
                                <td><?php echo $product->product->id ?></td>
                                <td><?php echo $product->product->name ?><?php if ($product->product->type == 'software'):?> (<?php echo $product->product->license->name ?>)<?php endif; ?></td>
                                <td><?php echo number_format($product->product->basePrice) . ' ' . strtoupper($product->product->coin); ?></td>
                                <td><?php echo $product->quantity ?></td>
                            </tr>
                            <?php
                            if ($product->product->coin === 'nis') {
                                $subTotal += $product->product->basePrice * $product->quantity;
                            } else {
                                $subTotal += $product->product->basePrice * $product->quantity * $quote->usdRate;
                            }
                        endforeach; ?>
                        </tbody>
                        <tfoot class="bg-info">
                            <tr>
                                <td colspan="3" class="text-right"><strong>USD-NIS Rate:</strong></td>
                                <td><?php echo $quote->usdRate; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Sub-Total (NIS):</strong></td>
                                <td><?php echo number_format(intval($subTotal)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Discount (%):</strong></td>
                                <td><?php echo number_format($quote->discount, 2); $subTotal *= (1 - ($quote->discount / 100)); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Tax rate (%):</strong></td>
                                <td><?php echo number_format($quote->taxRate, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Tax (NIS):</strong></td>
                                <td><?php echo number_format(intval($subTotal * ($quote->taxRate / 100))); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Total + Tax (NIS):</strong></td>
                                <td><?php echo number_format(intval($subTotal * (1 + ($quote->taxRate / 100)))); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="bg-main padded-5px margin-bottom">Quote information:</h3>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="quote-date">Creation Date:</label>
                        <p class="form-control-static" id="quote-date"><strong><?php echo $this->formatSqlDateTime($quote->date, 'Y-m-d H:i:s', 'd/m/Y') ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="quote-expire">Expire:</label>
                        <p class="form-control-static" id="quote-expire"><strong><?php echo $this->formatSqlDateTime($quote->expire, 'Y-m-d H:i:s', 'd/m/Y') ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="quote-notes">Notes:</label>
                        <p class="form-control-static" id="quote-notes"><strong><?php echo str_replace(PHP_EOL, "<br>", $this->escape($quote->note)) ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-footer text-right">
            <div class="hidden-xs">
                <a href="<?php $this->publicPath() ?>Quotes" class="btn btn-link">Quotes</a>
                <?php if ($quote->client->email): ?><button data-send-id="<?php echo $quote->id?>" data-send-email="<?php echo $quote->client->email?>" class="btn btn-default send-mail-btn"><i class="fa fa-fw fa-send"></i> Mail quote</button><?php endif; ?>
                <a href="<?php $this->publicPath() ?>Quotes/Print/<?php echo $quote->id ?>" target="_blank" class="btn btn-default"><i class="fa fa-fw fa-print"></i> Print quote</a>
                <?php if ($quote->status->id == 4): ?><a href="<?php $this->publicPath() ?>Invoices/New/<?php echo $quote->id ?>" class="btn btn-success"><i class="fa fa-fw fa-file-text"></i> Create invoice</a><?php endif; ?>
                <?php if ($quote->status->id != 5): ?>
                <a href="<?php $this->publicPath() ?>Quotes/Update/<?php echo $quote->id ?>" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i> Update quote</a>
                <?php endif; ?>
            </div>
            <div class="visible-xs">
                <?php if ($quote->status->id != 5): ?>
                <a href="<?php $this->publicPath() ?>Quotes/Update/<?php echo $quote->id ?>" class="btn btn-primary btn-block"><i class="fa fa-fw fa-edit"></i> Update quote</a>
                <?php endif; ?>
                <?php if ($quote->status->id == 4): ?><a href="<?php $this->publicPath() ?>Invoices/New/<?php echo $quote->id ?>" class="btn btn-success btn-block"><i class="fa fa-fw fa-file-text"></i> Create invoice</a><?php endif; ?>
                <?php if ($quote->client->email): ?><button data-send-id="<?php echo $quote->id?>" data-send-email="<?php echo $quote->client->email?>" class="btn btn-default btn-block send-mail-btn"><i class="fa fa-fw fa-send"></i> Mail quote</button><?php endif; ?>
                <a href="<?php $this->publicPath() ?>Quotes" class="btn btn-link btn-block">Quotes</a>
            </div>
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/quotes/quote-show.js?<?php echo date('YmdHis') ?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('MessageModal')->render();
        $this->getSharedView('Footer')->render();
    }

} 