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
use Application\Entities\Client;

/**
 * Class NonActiveClients
 *
 * Show non active clients report.
 *
 * @package Application\Views\Reports
 */
class NonActiveClients extends AbstractView
{

    /**
     * Render non active clients report.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var Client[] $clients */
        $clients = $this->data['clients'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-users"></i> Non active clients</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-condensed table-bordered table-hover">
            <thead class="bg-main">
                <tr>
                    <th>#</th>
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Client Phone</th>
                    <th>Client Address</th>
                    <th>Client E-Mail</th>
                    <th>Client Website</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0; foreach ($clients as $client): ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $client->id; ?></td>
                    <td><a href="<?php $this->publicPath() ?>Clients/Show/<?php echo $client->id; ?>"><?php echo $client->name; ?></a></td>
                    <td><?php echo $client->phone ?></td>
                    <td><?php echo $client->address ?></td>
                    <td><?php echo $client->email ?></td>
                    <td><?php echo $client->webSite ?></td>
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