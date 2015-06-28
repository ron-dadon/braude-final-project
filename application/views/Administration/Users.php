<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Administration;

use \Trident\MVC\AbstractView;
use Application\Entities\User;

/**
 * Class Users
 *
 * Show system users.
 *
 * @package Application\Views\Administration
 */
class Users extends AbstractView
{

    /**
     * Render system users.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var User[] $users */
        $users = $this->data['users'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-users"></i> Users</h1>
    </div>
    <?php if (isset($this->data['success'])): ?>
        <div class="alert alert-success alert-dismissable">
            <h4><i class="fa fa-fw fa-check-circle"></i><?php echo $this->data['success'] ?></h4>
        </div>
    <?php endif; ?>
    <div id="alerts-container"></div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table table-bordered" id="users-table">
                <thead>
                    <tr>
                        <th data-column-id="id" data-identifier="true" data-order="asc">ID</th>
                        <th data-column-id="email">E-Mail</th>
                        <th data-column-id="firstName">First name</th>
                        <th data-column-id="lastName">Last name</th>
                        <th data-column-id="lastActivity">Last activity</th>
                        <th data-column-id="admin">Administrator</th>
                        <th data-column-id="actions" data-formatter="userActions">Actions</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($users as $user): ?>
                    <tr data-user-id="<?php echo $user->id ?>">
                        <td><?php echo $user->id ?></td>
                        <td><?php echo $this->escape($user->email) ?></td>
                        <td><?php echo $this->escape($user->firstName) ?></td>
                        <td><?php echo $this->escape($user->lastName) ?></td>
                        <td><?php echo $this->formatSqlDateTime($user->lastActive) ?></td>
                        <td><?php echo $user->admin ? 'Yes' : 'No' ?></td>
                        <td>Actions</td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="panel-footer text-right">
                <a href="<?php $this->publicPath() ?>Administration" class="btn btn-link hidden-xs">Back</a>
                <a href="<?php $this->publicPath() ?>Administration/Users/New" class="btn btn-primary hidden-xs"><i class="fa fa-fw fa-user-plus"></i> New user</a>
                <a href="<?php $this->publicPath() ?>Administration/Users/New" class="btn btn-primary  btn-block visible-xs"><i class="fa fa-fw fa-user-plus"></i> New user</a>
                <a href="<?php $this->publicPath() ?>Administration" class="btn btn-link btn-block visible-xs">Back</a>
            </div>
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/administration/users.js?<?php echo date('YmdHis') ?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('Footer')->render();

    }

}