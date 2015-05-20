<?php


namespace Application\Views\Shared;

use \Trident\MVC\AbstractView;

/**
 * Class Footer
 *
 * @package Application\Views\Shared
 */
class Footer extends AbstractView
{

    public function render() {
        $this->getSharedView('LogoutModal')->render();
        $this->getSharedView('AutoLogoutModal')->render(); ?>
</body>
</html>
<?php
    }

}