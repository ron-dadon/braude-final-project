<?php


class Navbar_View extends Trident_Abstract_View
{
    public function render()
    {
    ?>
    <nav class="navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <a class="navbar-brand navbar-brand-image" href="<?php $this->public_path()?>" style="color: #ffffff"><img src="<?php $this->public_path()?>/images/logo-sm-white.png"></a>
            </div>
            <div class="collapse navbar-collapse" id="main-menu">
                <ul class="nav navbar-nav">
                    <li<?php if ($this->get('current-menu') === 'home') { echo ' class="active"'; }?>><a href="<?php $this->public_path()?>"><i class="fa fa-fw fa-home"></i> ראשי</a></li>
                    <li<?php if ($this->get('current-menu') === 'clients') { echo ' class="active"'; }?>><a href="<?php $this->public_path()?>/clients"><i class="fa fa-fw fa-users"></i> לקוחות</a></li>
                    <li<?php if ($this->get('current-menu') === 'products') { echo ' class="active"'; }?>><a href="<?php $this->public_path()?>/products"><i class="fa fa-fw fa-shopping-cart"></i> מוצרים</a></li>
                    <li<?php if ($this->get('current-menu') === 'quotes') { echo ' class="active"'; }?>><a href="<?php $this->public_path()?>/quotes"><i class="fa fa-fw fa-file-text"></i> הצעות מחיר</a></li>
                    <li<?php if ($this->get('current-menu') === 'invoices') { echo ' class="active"'; }?>><a href="<?php $this->public_path()?>/invoices"><i class="fa fa-fw fa-money"></i> חשבוניות עסקה</a></li>
                    <li<?php if ($this->get('current-menu') === 'reports') { echo ' class="active"'; }?>><a href="<?php $this->public_path()?>/reports"><i class="fa fa-fw fa-line-chart"></i> דוחות</a></li>
                    <?php if ($this->get('is_admin')): ?>
                    <li<?php if ($this->get('current-menu') === 'management') { echo ' class="active"'; }?>><a href="<?php $this->public_path()?>/management"><i class="fa fa-fw fa-cogs"></i> ניהול</a></li>
                    <?php endif; ?>
                </ul>
                <ul class="nav navbar-nav navbar-left">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-fw fa-user"></i> <?php echo $this->get('current-user')?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu">
                            <li><a href="<?php $this->public_path()?>/logout"><i class="fa fa-fw fa-sign-out"></i> התנתק</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-left hidden-xs" method="post" action="<?php $this->public_path()?>/search" data-toggle="validator">
                    <div class="input-group">
                        <input type="text" class="form-control" name="global_search" required placeholder="חפש במערכת...">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-fw fa-search"></i> חפש</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </nav>
    <?php
    }
} 