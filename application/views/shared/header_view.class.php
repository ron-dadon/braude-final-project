<?php

class Header_View extends IACS_View
{
    public function render()
    {
        $lang = $this->configuration->get('display', 'language') ?: 'en';
?>
<!DOCTYPE html>
<html lang="<?php echo $lang ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Style sheets -->
    <?php $this->load_asset('bootstrap.min.css')?>
<?php if ($this->configuration->get('display', 'theme')) { $this->load_asset('bootstrap-theme.min.css'); } ?>
    <?php $this->load_asset('bootstrap-grid.min.css')?>
    <?php $this->load_asset('bootstrap-select.min.css')?>
    <?php $this->load_asset('bootstrap-file-input.min.css')?>
    <?php $this->load_asset('bootstrap-tree.min.css')?>
<?php if ($this->configuration->get('display', 'rtl')) { $this->load_asset('bootstrap-rtl.min.css'); } ?>
    <?php $this->load_asset('font-awesome.min.css')?>
    <?php $this->load_asset('animate.min.css')?>
    <?php $this->load_asset('arimo.min.css')?>
    <?php $this->load_asset('application.css')?>
    <!-- End of style sheets -->
    <!-- Java scripts -->
    <?php $this->load_asset('jquery.min.js')?>
    <?php $this->load_asset('bootstrap.min.js')?>
    <?php $this->load_asset('bootstrap-grid.min.js')?>
    <?php $this->load_asset('bootstrap-select.min.js')?>
    <?php $this->load_asset('bootstrap-file-input.min.js')?>
    <?php $this->load_asset('bootstrap-file-input-he.js')?>
    <?php $this->load_asset('bootstrap-tree.min.js')?>
    <?php $this->load_asset('bootstrap-validator.min.js')?>
    <?php $this->load_asset('application.js')?>
    <!-- End of java scripts -->
    <title>IACS</title>
</head>
<body>
<?php
    }
}