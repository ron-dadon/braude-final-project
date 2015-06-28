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
 * Class EmailInvoice
 *
 * Show quote email.
 *
 * @package Application\Views\Quotes
 */
class EmailInvoice extends AbstractView
{

    /**
     * Render quote email.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var Invoice $invoice */
        $invoice = $this->data['invoice'];
        /** @var License[] $licenses */
        $licenses = $this->data['licenses'];
        $this->getSharedView('EmailHeader')->render(); ?>
        <div class="container-fluid" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px;">
            <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
                <div class="col-xs-12 text-center" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;text-align: center;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                    <h1 style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-size: 36px;margin: 0.67em 0;font-family: inherit;font-weight: 500;line-height: 1.1;color: inherit;margin-top: 20px;margin-bottom: 10px;">Invoice No. <?php echo $this->escape(str_pad($invoice->id, 8, '0', STR_PAD_LEFT)); ?></h1>
                </div>
            </div>
            <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
                <div class="col-xs-12" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                    <strong style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-weight: bold;"><?php echo $this->escape($invoice->client->name) ?></strong><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                    <?php echo $this->escape($invoice->client->address) ?><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                    <?php echo $this->escape($invoice->client->phone) ?><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                    <?php echo $this->escape($invoice->client->email) ?>
                </div>
            </div>
            <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
                <div class="col-xs-12" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                    <p style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;">This is the quote:</p>
                </div>
                <div class="col-xs-12" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                    <table class="table table-bordered table-condensed" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;border-collapse: collapse !important;border-spacing: 0;background-color: transparent;width: 100%;max-width: 100%;margin-bottom: 20px;border: 1px solid #ddd;">
                        <thead style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: table-header-group;">
                        <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                            <th width="1%" style="white-space: nowrap;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: left;line-height: 1.42857143;vertical-align: bottom;border-top: 1px solid #ddd;border-bottom: 2px solid #ddd;border: 1px solid #ddd !important;border-bottom-width: 2px;background-color: #fff !important;">Product ID</th>
                            <th style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: left;line-height: 1.42857143;vertical-align: bottom;border-top: 1px solid #ddd;border-bottom: 2px solid #ddd;border: 1px solid #ddd !important;border-bottom-width: 2px;background-color: #fff !important;">Product Name</th>
                            <th width="1%" style="white-space: nowrap;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: left;line-height: 1.42857143;vertical-align: bottom;border-top: 1px solid #ddd;border-bottom: 2px solid #ddd;border: 1px solid #ddd !important;border-bottom-width: 2px;background-color: #fff !important;">Product Price</th>
                            <th width="1%" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: left;line-height: 1.42857143;vertical-align: bottom;border-top: 1px solid #ddd;border-bottom: 2px solid #ddd;border: 1px solid #ddd !important;border-bottom-width: 2px;background-color: #fff !important;">Quantity</th>
                        </tr>
                        </thead>
                        <tbody style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                        <?php foreach ($invoice->quote->products as $product): ?>
                            <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                                <td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;"><?php echo $product->product->id ?></td>
                                <td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;"><?php echo $product->product->name . ($product->product->type == 'software' ? " ({$product->product->license->name})" : '') ?></td>
                                <td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;"><?php echo number_format($product->product->basePrice) . ' ' . strtoupper($product->product->coin); ?></td>
                                <td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;"><?php echo $product->quantity ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                        <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                            <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">USD-NIS
                                                                                                                                                                                                                                                                                                                                    Rate: <?php echo $invoice->quote->usdRate; ?></td>
                        </tr>
                        <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                            <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">Sub-Total
                                                                                                                                                                                                                                                                                                                                    (NIS): <?php echo number_format(intval($invoice->quote->getSubTotal())); ?></td>
                        </tr>
                        <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                            <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">
                                Discount: <?php echo number_format($invoice->quote->discount, 2); ?></td>
                        </tr>
                        <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                            <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">Tax
                                                                                                                                                                                                                                                                                                                                    rate: <?php echo number_format($invoice->quote->taxRate, 2); ?></td>
                        </tr>
                        <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                            <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">Tax
                                                                                                                                                                                                                                                                                                                                    (NIS): <?php echo number_format(intval($invoice->quote->getTaxAmount())); ?></td>
                        </tr>
                        <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                            <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">Total + Tax
                                                                                                                                                                                                                                                                                                                                    (NIS): <?php echo number_format(intval($invoice->quote->getTotalWithTax())); ?></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
                <div class="col-xs-12" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                    <strong style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-weight: bold;">Notes:</strong><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">

                    <p style="text-decoration: underline;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;"><?php echo str_replace(PHP_EOL, '<br>', $this->escape($invoice->note)); ?></p>
                    <br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                </div>
            </div>
            <?php if (count($licenses)): ?>
            <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
                <div class="col-xs-12" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                    <strong style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-weight: bold;">Licenses appendix:</strong>
                    <ul style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-top: 0;margin-bottom: 10px;">
                        <?php foreach ($licenses as $lic): ?>
                            <li style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"><strong style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-weight: bold;"><?php echo $lic->product->name . " ({$lic->product->license->name})"; ?>
                                    :</strong> <?php echo $lic->serial; ?>
                                (Expire: <?php echo $this->formatSqlDateTime($lic->expire, 'Y-m-d H:i:s', 'd/m/Y'); ?>)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
                <div class="col-xs-12" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                    <?php if ($invoice->terms > 0): ?>
                        <p style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;"><strong style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-weight: bold;">Dear client,</strong><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">Please pay this invoice within <?php echo $invoice->terms ?> business days. Late payment will include debit.</p>
                    <?php else: ?>
                        <p style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;"><strong style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-weight: bold;">Dear client,</strong><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">This is a cash invoice. Please pay immediately.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
<?php
    }

} 