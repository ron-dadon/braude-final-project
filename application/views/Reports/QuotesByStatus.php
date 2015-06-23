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
use Application\Entities\Quote;

/**
 * Class QuotesByStatus
 *
 * Show quotes by status report.
 *
 * @package Application\Views\Reports
 */
class QuotesByStatus extends AbstractView
{

    /**
     * Render quotes by status report.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var Quote[] $quotes */
        $quotes = $this->data['quotes'];
        $status = $this->data['status'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-file-text"></i> Quotes By Status: <?php echo $status ?></h1>
    </div>
    <div class="table-responsive">
        <table class="table table-condensed table-bordered table-hover">
            <thead class="bg-main">
                <tr>
                    <th>#</th>
                    <th>Quote Number</th>
                    <th>Quote Client</th>
                    <th>Quote Expire</th>
                    <th>Quote Total (NIS)</th>
                    <th>Quote Tax (NIS)</th>
                    <th>Quote Total + Tax (NIS)</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0; $total = 0; $tax = 0; $totalTax = 0; foreach ($quotes as $quote): ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><a href="<?php $this->publicPath() ?>Quotes/Show/<?php echo $quote->id; ?>"><?php echo str_pad($quote->id, 8, '0', STR_PAD_LEFT); ?></a></td>
                    <td><a href="<?php $this->publicPath() ?>Clients/Show/<?php echo $quote->client->id; ?>"><?php echo $quote->client->name ?></a></td>
                    <td><?php echo $this->formatSqlDateTime($quote->expire, 'Y-m-d H:i:s', 'd/m/Y') ?></td>
                    <td><?php $total += $quote->getSubTotal(); echo number_format($quote->getSubTotal()) ?></td>
                    <td><?php $tax += $quote->getTaxAmount(); echo number_format($quote->getTaxAmount()) ?></td>
                    <td><?php $totalTax += $quote->getTotalWithTax(); echo number_format($quote->getTotalWithTax()) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="bg-info">
                    <td colspan="4" class="text-right"><strong>Totals:</strong></td>
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