<?php

namespace Application\Views\Main;

use \Trident\MVC\AbstractView;
use Application\Entities\User;

/**
 * Class Index
 * @property User $currentUser
 * @package Application\Views\Main
 */
class Index extends AbstractView
{

    public function render()
    {
        $time = date('H');
        if ($time >= 0 && $time < 6 || $time >= 20 && $time <= 23)
        {
            $welcomeMessage = "Good night";
        }
        elseif ($time >= 6 && $time < 12)
        {
            $welcomeMessage = "Good morning";
        }
        elseif ($time >= 12 && $time < 16)
        {
            $welcomeMessage = "Good noon";
        }
        elseif ($time >= 16 && $time < 18)
        {
            $welcomeMessage = "Good after noon";
        }
        else
        {
            $welcomeMessage = "Good evening";
        }

        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-home"></i> <?php echo $welcomeMessage . ' <strong>' . $this->currentUser->firstName . ' ' . $this->currentUser->lastName . '</strong>' ?>!</h1>
    </div>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

}