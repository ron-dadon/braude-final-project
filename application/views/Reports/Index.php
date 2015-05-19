<?php

namespace Application\Views\Reports;

use \Trident\MVC\AbstractView;

class Index extends AbstractView
{

    public function render()
    {
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-line-chart"></i> Reports</h1>
    </div>
    <a href="<?php $this->publicPath() ?>Reports/ExpiredLicenses">Expired Licenses</a>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

}