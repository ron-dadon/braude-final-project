<?php


namespace Application\Views\Shared;

use \Trident\MVC\AbstractView;

class Footer extends AbstractView
{

    public function render() {
        $this->getSharedView('LogoutModal')->render();
        $this->getSharedView('AutoLogoutModal')->render(); ?>
    <?php $this->js('js/application.js') ?>
</body>
</html>
<?php
    }

    public function js($file)
    {
        $file = $this->publicPath(true) . $file;
        echo "<script src=\"" . $file . "\"></script>" . PHP_EOL;
    }
} 