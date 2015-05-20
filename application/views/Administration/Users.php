<?php

namespace Application\Views\Administration;

use \Trident\MVC\AbstractView;
use Application\Entities\User;

class Users extends AbstractView
{

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
                        <td><?php echo $user->email ?></td>
                        <td><?php echo $user->firstName ?></td>
                        <td><?php echo $user->lastName ?></td>
                        <td><?php echo $this->formatSqlDateTime($user->lastActive) ?></td>
                        <td><?php echo $user->admin ? 'Yes' : 'No' ?></td>
                        <td>Actions</td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer text-right">
            <a href="<?php $this->publicPath() ?>Administration" class="btn btn-link">Back</a>
            <a href="<?php $this->publicPath() ?>Administration/Users/New" class="btn btn-primary"><i class="fa fa-fw fa-user-plus"></i> New user</a>
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/administration/users.js?<?php echo date('YmdHis') ?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('Footer')->render();

    }

}