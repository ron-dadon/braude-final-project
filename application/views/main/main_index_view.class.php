<?php


class Main_Index_View extends Trident_Abstract_View
{
    public function render()
    {
        $this->include_shared_view('header');
        $this->include_shared_view('navbar');
    ?>
    <div class="well well-sm top-fixed-header">
        <h2 class="no-margin"><i class="fa fa-fw fa-home"></i> ראשי</h2>
    </div>
    <div class="alert alert-success alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong><i class="fa fa-fw fa-check-circle"></i> הפעולה בוצעה!</strong> המידע נשמר במערכת
    </div>
    <div class="container-fluid">
        <p>Test</p>
    </div>
    <?php
        $this->include_shared_view('footer');
    }
}