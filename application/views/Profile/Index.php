<?php

namespace Application\Views\Profile;

use \Trident\MVC\AbstractView;
use Application\Entities\User;

class Index extends AbstractView
{

    public function render()
    {
        /** @var User $user */
        $user = $this->data['user'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-user"></i> Profile: <?php echo $this->escape($user->firstName . ' ' . $user->lastName) ?></h1>
    </div>
<?php if (isset($this->data['error'])): ?>
    <div class="alert alert-danger alert-dismissable">
        <h4 <?php if ($user->getErrors() !== null && count($user->getErrors()) > 0): ?>class="margin-bottom"<?php endif; ?>><i class="fa fa-fw fa-times-circle"></i><?php echo $this->data['error'] ?></h4>
<?php if ($user->getErrors() !== null && count($user->getErrors()) > 0): ?>
        <ul>
<?php foreach ($user->getErrors() as $error): ?>
            <li><?php echo $error ?></li>
<?php endforeach; ?>
        </ul>
<?php endif; ?>
    </div>
<?php endif; ?>
<?php if (isset($this->data['success'])): ?>
    <div class="alert alert-success alert-dismissable">
        <h4><i class="fa fa-fw fa-check-circle"></i><?php echo $this->data['success'] ?></h4>
    </div>
<?php endif; ?>
    <form method="post" id="new-user-form" data-toggle="validator">
    <div class="panel">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="user-email">EMail:</label>
                        <p class="form-control-static" id="user-email"><strong><?php echo $this->escape($user->email) ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="user-firstName">First name:</label>
                        <p class="form-control-static" id="user-firstName"><strong><?php echo $this->escape($user->firstName) ?></strong></p>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="user-lastName">Last name:</label>
                        <p class="form-control-static" id="user-lastName"><strong><?php echo $this->escape($user->lastName) ?></strong></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="user-password">Password:</label>
                        <input type="text" id="user-password" name="user_password" class="form-control" value="" pattern="^.{6,20}$" data-error="Password must be at least 6 characters long and not exceed 20 characters">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="user-confirm-password">Confirm password:</label>
                        <input type="text" id="user-confirm-password" name="user_confirm_password" class="form-control" data-match="#user-password" data-match-error="Password does not match  " data-error="Please repeat the password">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel">
        <div class="panel-footer text-right">
            <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> Update profile</button>
        </div>
    </div>
    </form>
</div>
<script src="<?php $this->publicPath() ?>js/main/profile.js?<?php echo date('YmdHis') ?>"></script>
<?php
        $this->getSharedView('Footer')->render();
    }

}