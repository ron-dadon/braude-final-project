<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Invoices;

use Trident\MVC\AbstractView;
use Application\Entities\Client;
use Application\Entities\Quote;
use Application\Entities\Invoice;
use Application\Entities\QuoteProduct;

/**
 * Class Update
 *
 * Show update invoice form.
 *
 * @package Application\Views\Invoices
 */
class Update extends AbstractView
{

    /**
     * Render update invoice form.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
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
    <div class="alert alert-dismissable alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 <?php if ($invoice->getErrors() !== null && count($invoice->getErrors()) > 0): ?>class="margin-bottom"<?php endif; ?>>
            <i class="fa fa-fw fa-times-circle"></i><?php echo $this->data['error'] ?></h4>
        <?php if ($invoice->getErrors() !== null && count($invoice->getErrors()) > 0): ?>
            <ul>
                <?php foreach ($invoice->getErrors() as $error): ?>
                    <li><?php echo $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endif; ?>
    <form id="create-invoice" method="post">
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
                <div class="col-xs-12 col-lg-5">
                    <div class="form-group">
                        <label for="invoice-receipt">Receipt:</label>
                        <input type="text" class="form-control" id="invoice-receipt" name="invoice_receipt" value="<?php echo $this->escape($invoice->receipt) ?>" maxlength="50">
                    </div>
                </div>
                <div class="col-xs-12 col-lg-5">
                    <div class="form-group">
                        <label for="invoice-tax">Tax invoice:</label>
                        <input type="text" class="form-control" id="invoice-tax" name="invoice_tax" value="<?php echo $this->escape($invoice->tax) ?>" maxlength="50">
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
                                <td><?php echo $product->product->name ?></td>
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
        <div class="row">
            <div class="col-xs-12">
                <div class="panel-heading">
                    <h3 class="bg-main padded-5px">Notes:</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <textarea name="invoice_note" class="form-control" style="resize: vertical"><?php echo $this->escape($invoice->note) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-footer text-right">
                <div class="hidden-xs">
                    <a href="<?php $this->publicPath() ?>Invoices/Show/<?php echo $invoice->id ?>" class="btn btn-link">Back to invoice</a>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> Update invoice</button>
                </div>
                <div class="visible-xs">
                    <a href="<?php $this->publicPath() ?>Invoices/Show/<?php echo $invoice->id ?>" class="btn btn-link btn-block">Back to invoice</a>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-fw fa-check"></i> Update invoice</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

} 