<?php

namespace Application\Views\Quotes;

use \Trident\MVC\AbstractView;
use Application\Entities\Quote;

class Index extends AbstractView
{

    public function render()
    {
        /** @var Quote[] $quotes */
        $quotes = $this->data['quotes'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-database"></i> Quotes</h1>
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
            <table class="table table-bordered" id="quotes-table">
                <thead>
                <tr>
                    <th data-column-id="id" data-identifier="true"  data-order="desc" data-converter="quote" data-formatter="quoteLink">Number</th>
                    <th data-column-id="quoteClient">Client</th>
                    <th data-column-id="quoteDate">Date</th>
                    <th data-column-id="quoteDateExpire">Expires</th>
                    <th data-column-id="quoteStatus">Status</th>
                    <th data-column-id="statusSet" data-sortable="false" data-formatter="quoteStatus">Set status</th>
                    <th data-column-id="actions" data-sortable="false" data-formatter="quoteActions">Actions</th>
                </tr>
                </thead>
                <tbody>
<?php foreach ($quotes as $quote): ?>
                    <tr data-user-id="<?php echo $quote->id ?>">
                        <td><?php echo $quote->id ?></td>
                        <td><?php echo $this->escape($quote->client->name) ?></td>
                        <td><?php echo $this->formatSqlDateTime(substr($quote->date,0,10), "Y-m-d", "d/m/Y") ?></td>
                        <td><?php echo $this->formatSqlDateTime(substr($quote->expire,0,10), "Y-m-d", "d/m/Y") ?></td>
                        <td><?php echo $this->escape($quote->status->name) ?></td>
                        <td>Set</td>
                        <td>Actions</td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer text-right">
            <a href="<?php $this->publicPath() ?>Quotes/New" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> New quote</a>
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/quotes/index.js?<?php echo date('YmdHis'); ?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('Footer')->render();
    }

}