<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Shared;

use \Trident\MVC\AbstractView;

/**
 * Class Footer
 *
 * View global footer.
 *
 * @package Application\Views\Shared
 */
class Footer extends AbstractView
{

    /**
     * Render global footer.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render() {
        $this->getSharedView('LogoutModal')->render();
        $this->getSharedView('AutoLogoutModal')->render(); ?>
</body>
</html>
<?php
    }

}