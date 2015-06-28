<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Licenses;

use \Trident\MVC\AbstractView;
use \Application\Entities\License;

/**
 * Class Index
 *
 * Show system licenses.
 *
 * @package Application\Views\Licenses
 */
class Index extends AbstractView
{

    /**
     * Render system licenses.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var License[] $licenses */
        $licenses = $this->data['licenses'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
        <div class="container-fluid">
        <div class="page-head bg-main">
            <h1><i class="fa fa-fw fa-key"></i> Licenses</h1>
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
                            <th data-column-id="productName" data-order="asc" data-formatter="product">Product</th>
                            <th data-column-id="clientName" data-formatter="client" data-order="asc">Client</th>
                            <th data-column-id="licenseType" data-formatter="types">Type</th>
                            <th data-column-id="expirationDate">Expiration Date</th>
                            <th data-column-id="serial" data-formatter="licenseLink">Serial</th>
                            <th data-column-id="status" data-formatter="statusFilter">Status</th>
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
                                <td><?php echo (new \DateTime($license->expire)) > (new \DateTime()) ? 'Active' : 'Expired'; ?></td>
                                <td>Actions</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="panel-footer text-right">
                        <button type="button" class="btn btn-default pull-left hidden-xs" onclick="$('#licenses-table').bootgrid('search','')"><i class="fa fa-fw fa-eraser"></i> Clear filter</button>
                        <a href="<?php $this->publicPath() ?>Licenses/New" class="btn btn-primary hidden-xs"><i class="fa fa-fw fa-plus"></i> New License</a>
                        <a href="<?php $this->publicPath() ?>Licenses/New" class="btn btn-primary btn-block visible-xs"><i class="fa fa-fw fa-plus"></i> New License</a>
                        <button type="button" class="btn btn-default btn-block visible-xs" onclick="$('#licenses-table').bootgrid('search','')"><i class="fa fa-fw fa-eraser"></i> Clear filter</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php $this->publicPath() ?>js/licenses/index.js?<?php echo date('YmdHis');?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('Footer')->render();
    }

}