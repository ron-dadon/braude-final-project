<?php

namespace Application\Views\Licenses;

use \Trident\MVC\AbstractView;
use \Application\Entities\License;

class Index extends AbstractView
{

    public function render()
    {
        /** @var License[] $licenses */
        $licenses = $this->data['licenses'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
        <div class="container-fluid">
        <div class="page-head bg-main">
            <h1><i class="fa fa-fw fa-cubes"></i> Licenses</h1>
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
                    <table class="table table-bordered" id="licenses-table">
                        <thead>
                        <tr>
                            <th data-column-id="licenseId" data-identifier="true" data-visible="false">ID</th>
                            <th data-column-id="productName" data-order="asc" data-formatter="productLink">Product</th>
                            <th data-column-id="clientName" data-formatter="clientLink" data-order="asc">Client</th>
                            <th data-column-id="licenseType">Type</th>
                            <th data-column-id="expirationDate">Expiration Date</th>
                            <th data-column-id="serial" data-formatter="licenseLink">Serial</th>
                            <th data-column-id="actions" data-sortable="false" data-formatter="licenseActions">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($licenses as $license): ?>
                            <tr data-license-id="<?php echo $license->id ?>">
                                <td><?php echo $license->id ?></td>
                                <td><?php echo $license->product->name ?></td>
                                <td><?php echo $license->client->name ?></td>
                                <td><?php echo $license->type->name ?></td>
                                <td><?php echo (new \DateTime($license->expire))->format('d/m/Y') ?></td>
                                <td><?php echo $license->serial ?></td>
                                <td>Actions</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer text-right">
                    <a href="<?php $this->publicPath() ?>Licenses/New" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> New License</a>
                </div>
            </div>
        </div>
        <script src="<?php $this->publicPath() ?>js/licenses/index.js?<?php echo date('YmdHis');?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('Footer')->render();
    }

}