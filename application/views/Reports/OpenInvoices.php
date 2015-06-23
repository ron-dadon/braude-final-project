<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Reports;

use Trident\MVC\AbstractView;
use Application\Entities\Invoice;

/**
 * Class OpenInvoices
 *
 * Show open invoices report.
 *
 * @package Application\Views\Reports
 */
class OpenInvoices extends AbstractView
{

    /**
     * Render open invoices report.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var Invoice[] $invoices */
        $invoices = $this->data['invoices'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-file-text"></i> Open invoices</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-condensed table-bordered table-hover">
            <thead class="bg-main">
                <tr>
                    <th>#</th>
                    <th>Invoice Number</th>
                    <th>Invoice Date</th>
                    <th>Invoice Total (NIS)</th>
                    <th>Invoice Tax (NIS)</th>
                    <th>Invoice Total + Tax (NIS)</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0; $total = 0; $tax = 0; $totalTax = 0; foreach ($invoices as $invoice): ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><a href="<?php $this->publicPath() ?>Invoices/Show/<?php echo $invoice->id; ?>"><?php echo str_pad($invoice->id, 8, '0', STR_PAD_LEFT); ?></a></td>
                    <td><?php echo $this->formatSqlDateTime($invoice->date, 'Y-m-d H:i:s', 'd/m/Y') ?></td>
                    <td><?php $total += $invoice->quote->getSubTotal(); echo number_format($invoice->quote->getSubTotal()) ?></td>
                    <td><?php $tax += $invoice->quote->getTaxAmount(); echo number_format($invoice->quote->getTaxAmount()) ?></td>
                    <td><?php $totalTax += $invoice->quote->getTotalWithTax(); echo number_format($invoice->quote->getTotalWithTax()) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="bg-info">
                    <td colspan="3" class="text-right"><strong>Totals:</strong></td>
                    <td><strong><?php echo number_format($total) ?></strong></td>
                    <td><strong><?php echo number_format($tax) ?></strong></td>
                    <td><strong><?php echo number_format($totalTax) ?></strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-footer text-right">
                <a href="<?php $this->publicPath() ?>Reports" class="btn btn-link hidden-xs">Reports</a>
                <a href="<?php $this->publicPath() ?>Reports" class="btn btn-link btn-block visible-xs">Reports</a>
            </div>
        </div>
    </div>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

}