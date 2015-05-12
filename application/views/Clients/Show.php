<?php

namespace Application\Views\Clients;

use \Trident\MVC\AbstractView;

class Show extends AbstractView
{

    public function render()
    {
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <h1>Clients</h1>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

}