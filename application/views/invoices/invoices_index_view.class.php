<?php


class Invoices_Index_View extends Trident_Abstract_View
{
    public function render()
    {
        $this->include_shared_view('header');
        $this->include_shared_view('navbar');
    ?>
    <div class="well well-sm top-fixed-header">
        <h2 class="no-margin"><i class="fa fa-fw fa-money"></i> חשבוניות עסקה</h2>
    </div>
    <div class="container-fluid">
        <p>Test</p>
    </div>
    <?php
        $this->include_shared_view('footer');
    }
}