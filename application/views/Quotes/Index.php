<?php

namespace Application\Views\Quotes;

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
        <h1><i class="fa fa-fw fa-database"></i> Quotes</h1>
    </div>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

}