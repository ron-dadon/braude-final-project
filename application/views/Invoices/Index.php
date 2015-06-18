<?php

namespace Application\Views\Invoices;

use \Trident\MVC\AbstractView;
use Application\Entities\Invoice;

class Index extends AbstractView
{

    public function render()
    {
        /** @var Invoice[] $invoices */
        $invoices = $this->data['invoices'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-file-text"></i> Invoices</h1>
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
    <div id="alerts-container"></div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table table-bordered" id="invoices-table">
                <thead>
                <tr>
                    <th data-column-id="id" data-identifier="true" data-order="desc" data-converter="invoice" data-formatter="invoice">Number</th>
                    <th data-column-id="client" data-formatter="client">Client</th>
                    <th data-column-id="clientName" data-visible="false">Client</th>
                    <th data-column-id="quote" data-converter="invoice" data-formatter="quote">Quote</th>
                    <th data-column-id="receipt">Receipt</th>
                    <th data-column-id="taxInvoice">Tax invoice</th>
                    <th data-column-id="total">Total</th>
                    <th data-column-id="tax">Tax</th>
                    <th data-column-id="totalTax">Total + Tax</th>
                    <th data-column-id="actions" data-sortable="false" data-formatter="invoiceActions">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($invoices as $invoice): ?>
                    <tr data-user-id="<?php echo $invoice->id ?>">
                        <td><?php echo $invoice->id ?></td>
                        <td><?php echo $invoice->client->id ?></td>
                        <td><?php echo $invoice->client->name ?></td>
                        <td><?php echo $invoice->quote->id ?></td>
                        <td><?php echo $this->escape($invoice->receipt) ?></td>
                        <td><?php echo $this->escape($invoice->tax) ?></td>
                        <td><?php echo number_format($invoice->quote->getSubTotal()) ?></td>
                        <td><?php echo number_format($invoice->quote->getTaxAmount()) ?></td>
                        <td><?php echo number_format($invoice->quote->getTotalWithTax()) ?></td>
                        <td>Actions</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer text-right">
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/invoices/index.js?<?php echo date('YmdHis'); ?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('Footer')->render();
    }

}