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
 * Class EmailQuote
 *
 * Show quote for e-mail.
 *
 * @package Application\Views\Quotes
 */
class EmailQuote extends AbstractView
{

    /**
     * Render quote email.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var Quote $quote */
        $quote = $this->data['quote'];
        $subTotal = 0;
        $total = 0;
        $this->getSharedView('EmailHeader')->render(); ?>
        <div class="container-fluid" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-right: auto;margin-left: auto;padding-left: 15px;padding-right: 15px;">
        <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
            <div class="col-xs-12 text-center" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;text-align: center;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                <h1 style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-size: 36px;margin: 0.67em 0;font-family: inherit;font-weight: 500;line-height: 1.1;color: inherit;margin-top: 20px;margin-bottom: 10px;">Quote No. <?php echo $this->escape(str_pad($quote->id, 8, '0', STR_PAD_LEFT)); ?></h1>
            </div>
        </div>
        <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
            <div class="col-xs-12" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                <strong style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-weight: bold;"><?php echo $this->escape($quote->client->name) ?></strong><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                <?php echo $this->escape($quote->client->address) ?><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                <?php echo $this->escape($quote->client->phone) ?><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                <?php echo $this->escape($quote->client->email) ?>
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
                    <?php foreach ($quote->products as $product): ?>
                        <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                            <td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;"><?php echo $product->product->id ?></td>
                            <td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;"><?php echo $product->product->name ?></td>
                            <td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;"><?php echo number_format($product->product->basePrice) . ' ' . strtoupper($product->product->coin); ?></td>
                            <td style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;"><?php echo $product->quantity ?></td>
                        </tr>
                        <?php
                        if ($product->product->coin === 'nis') {
                            $subTotal += $product->product->basePrice * $product->quantity;
                        } else {
                            $subTotal += $product->product->basePrice * $product->quantity * $quote->usdRate;
                        }
                    endforeach; ?>
                    </tbody>
                    <tfoot style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                    <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                        <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">USD-NIS Rate: <?php echo $quote->usdRate; ?></td>
                    </tr>
                    <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                        <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">Sub-Total (NIS): <?php echo number_format(intval($subTotal)); ?></td>
                    </tr>
                    <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                        <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">Discount: <?php echo number_format($quote->discount, 2); $subTotal *= (1 - ($quote->discount / 100)); ?></td>
                    </tr>
                    <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                        <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">Tax rate: <?php echo number_format($quote->taxRate, 2); ?></td>
                    </tr>
                    <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                        <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">Tax (NIS): <?php echo number_format(intval($subTotal * ($quote->taxRate / 100))); ?></td>
                    </tr>
                    <tr style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;page-break-inside: avoid;">
                        <td colspan="4" class="text-right" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 5px;text-align: right;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #ddd;border: 1px solid #ddd !important;background-color: #fff !important;">Total + Tax (NIS): <?php echo number_format(intval($subTotal * (1 + ($quote->taxRate / 100)))); ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
            <div class="col-xs-12" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                <strong style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-weight: bold;">Notes:</strong><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                <p style="text-decoration: underline;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;"><?php echo str_replace(PHP_EOL, '<br>', $this->escape($quote->note)); ?></p>
                <br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
            </div>
        </div>
        <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
            <div class="col-xs-12" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                <p style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;"><strong style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-weight: bold;">Quote valid until: </strong><span style="text-decoration: underline;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;"><?php echo substr($this->formatSqlDateTime($quote->expire),0,10) ?></span></p>
            </div>
        </div>
        <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
            <div class="col-xs-12" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 100%;">
                <strong style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;font-weight: bold;">Quote approve:</strong><br style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;">
                <p style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;">I approve the quote:</p>
            </div>
        </div>
        <div class="row" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;margin-left: -15px;margin-right: -15px;">
            <div class="col-xs-4" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 33.33333333%;">
                <div class="form-group text-center" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;text-align: center;margin-bottom: 15px;">
                    <p class="form-control-static" id="approve-name" style="border-bottom: solid 1px black;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;padding-top: 7px;padding-bottom: 7px;margin-bottom: 0;min-height: 34px;"></p>
                    <label for="approve-name" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: bold;">Client</label>
                </div>
            </div>
            <div class="col-xs-4" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 33.33333333%;">
                <div class="form-group text-center" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;text-align: center;margin-bottom: 15px;">
                    <p class="form-control-static" id="approve-date" style="border-bottom: solid 1px black;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;padding-top: 7px;padding-bottom: 7px;margin-bottom: 0;min-height: 34px;"></p>
                    <label for="approve-date" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: bold;">Date</label>
                </div>
            </div>
            <div class="col-xs-4" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;float: left;width: 33.33333333%;">
                <div class="form-group text-center" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;text-align: center;margin-bottom: 15px;">
                    <p class="form-control-static" id="approve-sig" style="border-bottom: solid 1px black;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;orphans: 3;widows: 3;margin: 0 0 10px;padding-top: 7px;padding-bottom: 7px;margin-bottom: 0;min-height: 34px;"></p>
                    <label for="approve-sig" style="-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: inline-block;max-width: 100%;margin-bottom: 5px;font-weight: bold;">Signature</label>
                </div>
            </div>
        </div>
        </div>
<?php
    }

} 