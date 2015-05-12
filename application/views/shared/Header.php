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
    <title>IACS</title>
    <?php $this->css('css/bootstrap.min.css') ?>
    <?php $this->css('css/bootstrap-file-input.min.css') ?>
    <?php $this->css('css/bootstrap-grid.min.css') ?>
    <?php $this->css('css/bootstrap-select.min.css') ?>
    <?php $this->css('css/bootstrap-tree.min.css') ?>
    <?php $this->css('css/bootstrap-theme.min.css') ?>
    <?php $this->css('css/bootstrap-rtl.min.css') ?>
    <?php $this->css('css/arimo.min.css') ?>
    <?php $this->css('css/font-awesome.min.css') ?>
    <?php $this->css('css/application.css') ?>
    <!--[if IE]><link rel="shortcut icon" href="<?php $this->publicPath() ?>images/favicon.ico"><![endif]-->
    <link rel="apple-touch-icon" href="<?php $this->publicPath() ?>images/favicon.png">
    <link rel="icon" href="<?php $this->publicPath() ?>images/favicon.png">
    <?php $this->js('js/jquery.min.js') ?>
    <?php $this->js('js/bootstrap.min.js') ?>
    <?php $this->js('js/bootstrap-file-input.min.js') ?>
    <?php $this->js('js/bootstrap-file-input-he.min.js') ?>
    <?php $this->js('js/bootstrap-grid.min.js') ?>
    <?php $this->js('js/bootstrap-select.min.js') ?>
    <?php $this->js('js/bootstrap-tree.min.js') ?>
    <?php $this->js('js/bootstrap-validator.min.js') ?>
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