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
use Application\Entities\Invoice;
use Application\Entities\License;

/**
 * Class PrintQuote
 *
 * Show quote print.
 *
 * @package Application\Views\Quotes
 */
class PrintInvoice extends AbstractView
{

    /**
     * Render quote print.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var Invoice $invoice */
        $invoice = $this->data['invoice'];
        /** @var License[] $licenses */
        $licenses = $this->data['licenses'];
        $this->getSharedView('PrintHeader')->render(); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h1>Invoice No. <?php echo $this->escape(str_pad($invoice->id, 8, '0', STR_PAD_LEFT)); ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <strong><?php echo $this->escape($invoice->client->name) ?></strong><br>
                    <?php echo $this->escape($invoice->client->address) ?><br>
                    <?php echo $this->escape($invoice->client->phone) ?><br>
                    <?php echo $this->escape($invoice->client->email) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <p>This is the quote:</p>
                </div>
                <div class="col-xs-12">
                    <table class="table table-bordered table-condensed">
                        <thead>
                        <tr>
                            <th width="1%" style="white-space: nowrap">Product ID</th>
                            <th>Product Name</th>
                            <th width="1%" style="white-space: nowrap">Product Price</th>
                            <th width="1%">Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($invoice->quote->products as $product): ?>
                            <tr>
                                <td><?php echo $product->product->id ?></td>
                                <td><?php echo $product->product->name . ($product->product->type == 'software' ? " ({$product->product->license->name})" : '') ?></td>
                                <td><?php echo number_format($product->product->basePrice) . ' ' . strtoupper($product->product->coin); ?></td>
                                <td><?php echo $product->quantity ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4" class="text-right">USD-NIS
                                                               Rate: <?php echo $invoice->quote->usdRate; ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Sub-Total
                                                               (NIS): <?php echo number_format(intval($invoice->quote->getSubTotal())); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">
                                Discount: <?php echo number_format($invoice->quote->discount, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Tax
                                                               rate: <?php echo number_format($invoice->quote->taxRate, 2); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Tax
                                                               (NIS): <?php echo number_format(intval($invoice->quote->getTaxAmount())); ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Total + Tax
                                                               (NIS): <?php echo number_format(intval($invoice->quote->getTotalWithTax())); ?></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <strong>Notes:</strong><br>

                    <p style="text-decoration: underline"><?php echo str_replace(PHP_EOL, '<br>', $this->escape($invoice->note)); ?></p>
                    <br>
                </div>
            </div>
            <?php if (count($licenses)): ?>
            <div class="row">
                <div class="col-xs-12">
                    <strong>Licenses appendix:</strong>
                    <ul>
                        <?php foreach ($licenses as $lic): ?>
                            <li><strong><?php echo $lic->product->name . " ({$lic->product->license->name})"; ?>
                                    :</strong> <?php echo $lic->serial; ?>
                                (Expire: <?php echo $this->formatSqlDateTime($lic->expire, 'Y-m-d H:i:s', 'd/m/Y'); ?>)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xs-12">
                    <?php if ($invoice->terms > 0): ?>
                    <p><strong>Dear client,</strong><br>Please pay this invoice within <?php echo $invoice->terms ?> business days. Late payment will include debit.</p>
                    <?php else: ?>
                    <p><strong>Dear client,</strong><br>This is a cash invoice. Please pay immediately.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script src="<?php $this->publicPath() ?>js/auto-print.js?<?php echo date('YmdHis') ?>"></script>
    <?php
    }

} 