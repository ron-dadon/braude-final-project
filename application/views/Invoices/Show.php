<?php

namespace Application\Views\Invoices;

use Trident\MVC\AbstractView;
use Application\Entities\Client;
use Application\Entities\Quote;
use Application\Entities\Invoice;
use Application\Entities\QuoteProduct;

class Show extends AbstractView
{

    public function render()
    {
        /** @var Invoice $invoice */
        $invoice = $this->data['invoice'];
        /** @var Quote $quote */
        $quote = $invoice->quote;
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-file-text"></i> Invoice: <?php echo $this->escape(str_pad($invoice->id, 8, '0', STR_PAD_LEFT)) ?></h1>
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
                <h3 class="bg-main padded-5px margin-bottom">Invoice information</h3>
                <div class="col-xs-12 col-lg-2">
                    <div class="form-group">
                        <label for="invoice-date">Date:</label>
                        <p class="form-control-static" id="invoice-date"><strong><?php echo $this->formatSqlDateTime($invoice->date, 'Y-m-d H:i:s', 'd/m/Y'); ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-2">
                    <div class="form-group">
                        <label for="invoice-quote">Quote:</label>
                        <p class="form-control-static" id="invoice-quote"><a href="<?php $this->publicPath() ?>Quotes/Show/<?php echo $invoice->quote->id?>"><strong><?php echo $this->escape(str_pad($invoice->quote->id, 8, '0', STR_PAD_LEFT)) ?></strong></a></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-4">
                    <div class="form-group">
                        <label for="invoice-receipt">Receipt:</label>
                        <p class="form-control-static" id="invoice-receipt"><strong><?php echo $this->escape($invoice->receipt) ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-4">
                    <div class="form-group">
                        <label for="invoice-tax">Tax invoice:</label>
                        <p class="form-control-static" id="invoice-tax"><strong><?php echo $this->escape($invoice->tax) ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="bg-main padded-5px margin-bottom">Client</h3>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="invoice-client-name">Name:</label>
                        <p class="form-control-static" id="invoice-client-name"><strong><a href="<?php $this->publicPath() ?>Clients/Show/<?php echo $invoice->client->id ?>"><?php echo $invoice->client->name ?></a></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="invoice-client-name">Address:</label>
                        <p class="form-control-static visible-xs" id="invoice-client-name"><strong><a href="waze://?q=<?php echo $invoice->client->address ?>"><?php echo $invoice->client->address ?></a></strong></p>
                        <p class="form-control-static hidden-xs" id="invoice-client-name"><strong><?php echo $invoice->client->address ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="invoice-client-name">Phone:</label>
                        <p class="form-control-static visible-xs" id="invoice-client-name"><strong><a href="tel:<?php echo $invoice->client->phone ?>"><?php echo $invoice->client->phone ?></a></strong></p>
                        <p class="form-control-static hidden-xs" id="invoice-client-name"><strong><?php echo $invoice->client->phone ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="invoice-client-name">E-Mail:</label>
                        <p class="form-control-static" id="invoice-client-name"><strong><a href="mailto:<?php echo $invoice->client->email ?>"><?php echo $invoice->client->email ?></a></strong></p>
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
                                <td><?php echo $product->product->name . ($product->product->type == 'software' ? " ({$product->product->license->name})" : '')?></td>
                                <td><?php echo number_format($product->product->basePrice) . ' ' . strtoupper($product->product->coin); ?></td>
                                <td><?php echo $product->quantity ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="bg-info">
                            <tr>
                                <td colspan="3" class="text-right"><strong>USD-NIS Rate:</strong></td>
                                <td><?php echo $quote->usdRate; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Sub-Total (NIS):</strong></td>
                                <td><?php echo number_format(intval($quote->getSubTotal())); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Discount (%):</strong></td>
                                <td><?php echo number_format($quote->discount, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Tax rate (%):</strong></td>
                                <td><?php echo number_format($quote->taxRate, 2); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Tax (NIS):</strong></td>
                                <td><?php echo number_format(intval($quote->getTaxAmount())); ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Total + Tax (NIS):</strong></td>
                                <td><?php echo number_format(intval($quote->getTotalWithTax())); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <?php $licenses = $this->data['licenses']; if (count($licenses)): ?>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="bg-main padded-5px margin-bottom">Related licenses:</h3>
                <ul>
                    <?php foreach($licenses as $license): ?>
                        <li><a href="<?php $this->publicPath() ?>Licenses/Show/<?php echo $license->id ?>"><?php echo "{$license->product->name}  ({$license->type->name}): {$license->serial}" ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="panel">
        <div class="panel-footer text-right">
            <div class="hidden-xs">
                <a href="<?php $this->publicPath() ?>Invoices" class="btn btn-link">Invoices</a>
                <?php if ($invoice->client->email): ?><button data-send-id="<?php echo $invoice->id?>" data-send-email="<?php echo $invoice->client->email?>" class="btn btn-default send-mail-btn"><i class="fa fa-fw fa-send"></i> Mail invoice</button><?php endif; ?>
                <a href="<?php $this->publicPath() ?>Invoices/Print/<?php echo $invoice->id ?>" target="_blank" class="btn btn-default"><i class="fa fa-fw fa-print"></i> Print invoice</a>
                <a href="<?php $this->publicPath() ?>Invoices/Update/<?php echo $invoice->id ?>" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i> Update invoice</a>
            </div>
            <div class="visible-xs">
                <a href="<?php $this->publicPath() ?>Invoices/Update/<?php echo $invoice->id ?>" class="btn btn-primary btn-block"><i class="fa fa-fw fa-edit"></i> Update invoice</a>
                <?php if ($invoice->client->email): ?><button data-send-id="<?php echo $invoice->id?>" data-send-email="<?php echo $invoice->client->email?>" class="btn btn-default btn-block send-mail-btn"><i class="fa fa-fw fa-send"></i> Mail invoice</button><?php endif; ?>
                <a href="<?php $this->publicPath() ?>Invoices" class="btn btn-link btn-block">Invoices</a>
            </div>
        </div>
    </div>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

} 