<?php

namespace Application\Views\Clients;

use \Trident\MVC\AbstractView;
use \Application\Entities\Client;

class Index extends AbstractView
{

    public function render()
    {
        /** @var Client[] $clients */
        $clients = $this->data['clients'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-users"></i> Clients</h1>
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
            <table class="table table-bordered" id="clients-table">
                <thead>
                    <tr>
                        <th data-column-id="id" data-identifier="true" data-visible="false">ID</th>
                        <th data-column-id="clientName" data-formatter="clientLink" data-order="asc">Name</th>
                        <th data-column-id="address" data-formatter="addressLink">Address</th>
                        <th data-column-id="phone" data-formatter="telLink">Phone</th>
                        <th data-column-id="email" data-formatter="emailLink">E-Mail</th>
                        <th data-column-id="website" data-formatter="webLink">Website</th>
                        <th data-column-id="actions" data-sortable="false" data-formatter="clientActions">Actions</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($clients as $client): ?>
                    <tr data-user-id="<?php echo $client->id ?>">
                        <td><?php echo $client->id ?></td>
                        <td><?php echo $this->escape($client->name) ?></td>
                        <td><?php echo $this->escape($client->address) ?></td>
                        <td><?php echo $this->escape($client->phone) ?></td>
                        <td><?php echo $this->escape($client->email) ?></td>
                        <td><?php echo $this->escape($client->webSite) ?></td>
                        <td>Actions</td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer text-right">
            <a href="<?php $this->publicPath() ?>Clients/New" class="btn btn-primary"><i class="fa fa-fw fa-user-plus"></i> New client</a>
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/clients/index.js"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('Footer')->render();
    }

}