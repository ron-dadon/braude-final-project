<?php


namespace Application\Views\Reports;


use Trident\MVC\AbstractView;
use Application\Entities\Product;
use Application\Entities\License;

class ExpiredLicenses extends AbstractView
{

    public function render()
    {
        /** @var License[] $licenses */
        $licenses = $this->data['licenses'];
        $days = $this->data['days'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-key"></i> Expired licenses within the last <?php echo $days ?> days</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-condensed table-bordered table-hover">
            <thead class="bg-main">
                <tr>
                    <th>#</th>
                    <th>License ID</th>
                    <th>License Serial</th>
                    <th>License Client</th>
                    <th>License Invoice</th>
                    <th>License Product</th>
                    <th>License Type</th>
                    <th>License Expire</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0; foreach ($licenses as $license): ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $license->id; ?></td>
                    <td><a href="<?php $this->publicPath() ?>Licenses/Show/<?php echo $license->id; ?>"><?php echo $license->serial; ?></a></td>
                    <td><a href="<?php $this->publicPath() ?>Clients/Show/<?php echo $license->client->id; ?>"><?php echo $license->client->name; ?></a></td>
                    <td><?php echo $license->invoice == null ? '' : str_pad($license->invoice->id,8,'0',STR_PAD_LEFT) ?></td>
                    <td><a href="<?php $this->publicPath() ?>Products/Show/<?php echo $license->product->id; ?>"><?php echo $license->product->name; ?></a></td>
                    <td><?php echo $license->type->name; ?></td>
                    <td><?php echo $this->formatSqlDateTime($license->expire, 'Y-m-d H:i:s', 'd/m/Y') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
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