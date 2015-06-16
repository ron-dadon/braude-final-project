<?php

namespace Application\Views\Licenses;

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
<?php
        $this->getSharedView('Footer')->render();
    }

}