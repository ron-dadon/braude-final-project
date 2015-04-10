<?php


class Clients_Index_View extends Trident_Abstract_View
{
    public function render()
    {
        $this->include_shared_view('header');
        $this->include_shared_view('navbar');
    ?>
    <div class="well well-sm top-fixed-header">
        <h2 class="no-margin"><i class="fa fa-fw fa-users"></i> לקוחות</h2>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading text-left">
            <strong class="pull-right font-125"><i class="fa fa-fw fa-users"></i> רשימת לקוחות</strong>
            <button class="btn btn-xs btn-primary "><i class="fa fa-fw fa-user-plus"></i> הוסף לקוח</button>
        </div>
        <div class="panel-body">
            Results
        </div>
        <div class="panel-heading">
            <strong><i class="fa fa-fw fa-users"></i> לקוחות חייבים</strong>
        </div>
        <div class="panel-body">
            Results
        </div>
    </div>
    <?php
        $this->include_shared_view('footer');
    }
}