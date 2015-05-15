<?php

namespace Application\Views\Clients;

use \Trident\MVC\AbstractView;

class Index extends AbstractView
{

    public function render()
    {
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="panel">
        <div class="panel-header">
            <h1>Clients</h1>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="clients-table">
                <thead>
                    <tr>
                        <th data-column-id="name">Name</th>
                        <th data-column-id="address">Address</th>
                        <th data-column-id="phone">Phone</th>
                        <th data-column-id="actions" data-sortable="false">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Client 1</td>
                        <td>Address 1</td>
                        <td>Phone 1</td>
                        <td>Actions</td>
                    </tr>
                    <tr>
                        <td>Client 2</td>
                        <td>Address 2</td>
                        <td>Phone 2</td>
                        <td>Actions</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-footer text-left">
            <a href="<?php $this->publicPath() ?>Clients/Add" class="btn btn-primary"><i class="fa fa-fw fa-user-plus"></i> New client</a>
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/clients/index.js"></script>
<?php
        $this->getSharedView('Footer')->render();
    }

}