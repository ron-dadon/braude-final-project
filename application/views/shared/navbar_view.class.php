<?php

class Navbar_View extends IACS_View
{

    private function set_active_menu_item($item)
    {
        if ($item === $this->get('controller'))
        {
            echo ' class="active"';
        }
    }

    public function render()
    {
?>
    <!-- Navigation bar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <a class="navbar-brand" href="<?php $this->public_path()?>"><strong>IACS</strong></a>
            </div>
            <div class="collapse navbar-collapse" id="main-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li<?php $this->set_active_menu_item('main')?>><a href="<?php $this->public_path() ?>"><i class="fa fa-fw fa-home"></i> ראשי</a></li>
                    <li<?php $this->set_active_menu_item('clients')?>><a href="<?php $this->public_path() ?>/clients"><i class="fa fa-fw fa-users"></i> לקוחות</a></li>
                    <li<?php $this->set_active_menu_item('products')?>><a href="<?php $this->public_path() ?>/products"><i class="fa fa-fw fa-shopping-cart"></i> מוצרים</a></li>
                    <li<?php $this->set_active_menu_item('quotes')?>><a href="<?php $this->public_path() ?>/quotes"><i class="fa fa-fw fa-file-text"></i> הצעות מחיר</a></li>
                    <li<?php $this->set_active_menu_item('invoices')?>><a href="<?php $this->public_path() ?>/invoices"><i class="fa fa-fw fa-file-text"></i> חשבוניות עסקה</a></li>
                    <li<?php $this->set_active_menu_item('licenses')?>><a href="<?php $this->public_path() ?>/licenses"><i class="fa fa-fw fa-key"></i> רישיונות</a></li>
                    <li<?php $this->set_active_menu_item('reports')?>><a href="<?php $this->public_path() ?>/reports"><i class="fa fa-fw fa-line-chart"></i> דוחות</a></li>
                    <li<?php $this->set_active_menu_item('administration')?>><a href="<?php $this->public_path() ?>/administration"><i class="fa fa-fw fa-cogs"></i> ניהול</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li<?php $this->set_active_menu_item('users')?>><a href="<?php $this->public_path() ?>/profile"><i class="fa fa-fw fa-user"></i> שם משתמש</a></li>
                    <li><a href="<?php $this->public_path() ?>/logout"><i class="fa fa-fw fa-sign-out"></i> יציאה</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of navigation bar -->
<?php
    }
}