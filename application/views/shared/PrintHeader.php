<?php

namespace Application\Views\Shared;

use \Trident\MVC\AbstractView;

class PrintHeader extends AbstractView
{

    public function render() { ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $this->data['title'] ? $this->data['title'] : '&nbsp;' ?></title>
    <!-- Css files -->
    <?php $this->css('css/bootstrap.min.css') ?>
    <?php $this->css('css/font-awesome.min.css') ?>
    <!-- Css files end -->
    <!-- Icons -->
    <!--[if IE]><link rel="shortcut icon" href="<?php $this->publicPath() ?>images/favicon.ico"><![endif]-->
    <link rel="apple-touch-icon" href="<?php $this->publicPath() ?>images/favicon.png">
    <link rel="icon" href="<?php $this->publicPath() ?>images/favicon.png">
    <!-- Icons end -->
    <!-- Javascript files -->
    <?php $this->js('js/libraries/jquery.min.js') ?>
    <?php $this->js('js/libraries/bootstrap.min.js') ?>
    <!-- Javascript files end -->
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-4">
            <img src="<?php $this->publicPath() ?>images/logo.png" style="height: 1cm">&nbsp;&nbsp;&nbsp;
        </div>
        <div class="col-xs-8 text-right">
            <strong>Internal Audit &amp; Control Solutions</strong><br>
            <small>Haifa, Mahayan 5 st.</small>
        </div>
    </div>
</div>
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