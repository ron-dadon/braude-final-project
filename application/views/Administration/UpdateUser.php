<?php

namespace Application\Views\Administration;

use \Trident\MVC\AbstractView;
use Application\Entities\User;

class UpdateUser extends AbstractView
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
        <h1><i class="fa fa-fw fa-user-plus"></i> Update user: <?php echo $this->escape($user->firstName . ' ' . $user->lastName) ?></h1>
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
        <div class="panel-heading">
            <h3>User details:</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="user-email">EMail:</label>
                        <input type="email" id="user-email" name="user_email" class="form-control" value="<?php echo $this->escape($user->email) ?>" required autofocus data-error="Please enter a valid e-mail address">
                        <div class="help-block with-errors" id="email-error"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="user-firstName">First name:</label>
                        <input type="text" id="user-firstName" name="user_firstName" class="form-control" value="<?php echo $this->escape($user->firstName) ?>" required maxlength="20" data-error="Please fill in first name">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="user-lastName">Last name:</label>
                        <input type="text" id="user-lastName" name="user_lastName" class="form-control" value="<?php echo $this->escape($user->lastName) ?>" required maxlength="20" data-error="Please fill in last name">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-3">
                    <div class="form-group">
                        <label for="user-admin">Admin</label>
                        <select id="user-admin" name="user_admin" class="form-control" required>
                            <option value="1" <?php if ($user->admin) echo 'selected' ?>>Yes</option>
                            <option value="0" <?php if (!$user->admin) echo 'selected' ?>>No</option>
                        </select>
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
            <a href="<?php $this->publicPath() ?>Administration/Users" class="btn btn-link">Back</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> Update user</button>
        </div>
    </div>
    </form>
</div>
<script src="<?php $this->publicPath() ?>js/administration/user-update.js?<?php echo date('YmdHis') ?>"></script>
<?php
        $this->getSharedView('Footer')->render();
    }

}