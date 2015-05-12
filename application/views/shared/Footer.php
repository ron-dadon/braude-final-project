<?php


namespace Application\Views\Shared;

use \Trident\MVC\AbstractView;

class Footer extends AbstractView
{

    public function render() {
        $this->getSharedView('LogoutModal')->render(); ?>
    <?php $this->js('js/jquery.min.js') ?>
    <?php $this->js('js/bootstrap.min.js') ?>
    <?php $this->js('js/bootstrap-file-input.min.js') ?>
    <?php $this->js('js/bootstrap-file-input-he.min.js') ?>
    <?php $this->js('js/bootstrap-grid.min.js') ?>
    <?php $this->js('js/bootstrap-select.min.js') ?>
    <?php $this->js('js/bootstrap-tree.min.js') ?>
    <?php $this->js('js/bootstrap-validator.min.js') ?>
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