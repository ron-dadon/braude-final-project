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
 * Class PrintQuote
 *
 * Show quote print.
 *
 * @package Application\Views\Quotes
 */
class PrintQuote extends AbstractView
{

    /**
     * Render quote print.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var Quote $quote */
        $quote = $this->data['quote'];
        $subTotal = 0;
        $total = 0;
        $this->getSharedView('PrintHeader')->render(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 text-center">
            <h1>Quote No. <?php echo $this->escape(str_pad($quote->id, 8, '0', STR_PAD_LEFT)); ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <strong><?php echo $this->escape($quote->client->name) ?></strong><br>
            <?php echo $this->escape($quote->client->address) ?><br>
            <?php echo $this->escape($quote->client->phone) ?><br>
            <?php echo $this->escape($quote->client->email) ?>
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
<?php foreach ($quote->products as $product): ?>
                    <tr>
                        <td><?php echo $product->product->id ?></td>
                        <td><?php echo $product->product->name ?></td>
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
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right">USD-NIS Rate: <?php echo $quote->usdRate; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Sub-Total (NIS): <?php echo number_format(intval($subTotal)); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Discount: <?php echo number_format($quote->discount, 2); $subTotal *= (1 - ($quote->discount / 100)); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Tax rate: <?php echo number_format($quote->taxRate, 2); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Tax (NIS): <?php echo number_format(intval($subTotal * ($quote->taxRate / 100))); ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right">Total + Tax (NIS): <?php echo number_format(intval($subTotal * (1 + ($quote->taxRate / 100)))); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <strong>Notes:</strong><br>
            <p style="text-decoration: underline"><?php echo str_replace(PHP_EOL, '<br>', $this->escape($quote->note)); ?></p>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <p><strong>Quote valid until: </strong><span style="text-decoration: underline"><?php echo substr($this->formatSqlDateTime($quote->expire),0,10) ?></span></p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <strong>Quote approve:</strong><br>
            <p>I approve the quote:</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4">
            <div class="form-group text-center">
                <p class="form-control-static" id="approve-name" style="border-bottom: solid 1px black"></p>
                <label for="approve-name">Client</label>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group text-center">
                <p class="form-control-static" id="approve-date" style="border-bottom: solid 1px black"></p>
                <label for="approve-date">Date</label>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group text-center">
                <p class="form-control-static" id="approve-sig" style="border-bottom: solid 1px black"></p>
                <label for="approve-sig">Signature</label>
            </div>
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/auto-print.js?<?php echo date('YmdHis') ?>"></script>
<?php
    }

} 