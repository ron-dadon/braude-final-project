<?php

namespace Application\Views\Shared;

use \Trident\MVC\AbstractView;

class Header extends AbstractView
{

    public function render() { ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>IACS</title>
    <!-- Css files -->
    <?php $this->css('css/animate.min.css') ?>
    <?php $this->css('css/bootstrap.min.css') ?>
    <?php $this->css('css/bootstrap-file-input.min.css') ?>
    <?php $this->css('css/bootstrap-grid.min.css') ?>
    <?php $this->css('css/bootstrap-select.min.css') ?>
    <?php $this->css('css/bootstrap-tree.min.css') ?>
    <?php // $this->css('css/bootstrap-rtl.min.css') ?>
    <?php $this->css('css/arimo.min.css') ?>
    <?php $this->css('css/font-awesome.min.css') ?>
    <?php $this->css('css/application.css') ?>
    <!-- Css files end -->
    <!-- Icons -->
    <!--[if IE]><link rel="shortcut icon" href="<?php $this->publicPath() ?>images/favicon.ico"><![endif]-->
    <link rel="apple-touch-icon" href="<?php $this->publicPath() ?>images/favicon.png">
    <link rel="icon" href="<?php $this->publicPath() ?>images/favicon.png">
    <!-- Icons end -->
    <!-- Javascript files -->
    <?php $this->js('js/libraries/jquery.min.js') ?>
    <?php $this->js('js/libraries/bootstrap.min.js') ?>
    <?php $this->js('js/libraries/bootstrap-file-input.min.js') ?>
    <?php // $this->js('js/libraries/bootstrap-file-input-he.min.js') ?>
    <?php $this->js('js/libraries/bootstrap-grid.min.js') ?>
    <?php $this->js('js/libraries/bootstrap-select.min.js') ?>
    <?php $this->js('js/libraries/bootstrap-tree.min.js') ?>
    <?php $this->js('js/libraries/bootstrap-validator.min.js') ?>
    <?php $this->js('js/application-settings.js?'. date('YmdHis')) ?>
    <?php $this->js('js/application.js?'. date('YmdHis')) ?>
    <!-- Javascript files end -->
</head>
<body>
<?php
    }

    public function css($file)
    {
        $file = $this->publicPath(true) . $file;
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $file . "\">" . PHP_EOL;
    }

    public function js($file)
    {
        $file = $this->publicPath(true) . $file;
        echo "<script src=\"" . $file . "\"></script>" . PHP_EOL;
    }

}