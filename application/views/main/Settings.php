<?php

namespace Application\Views\Main;

use \Trident\MVC\AbstractView;

class Settings extends AbstractView
{

    public function render()
    {
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-header">
        <h1><i class="fa fa-fw fa-cogs"></i> Settings</h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><i class="fa fa-fw fa-shield"></i> Security</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-lg-4">
                    <form data-toggle="validator" id="security-form">
                        <div class="form-group">
                            <label for="security-idle-logout">Idle time to auto logout:</label>
                            <input type="number" class="form-control" id="security-idle-logout" value="60" required>
                        </div>
                    </form>
                </div>
            </div>
            <div class="alert alert-danger no-margin-bottom">
                <p><i class="fa fa-fw fa-info-circle"></i> Notice: changes in those settings have a security effect.</p>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><i class="fa fa-fw fa-envelope"></i> Email</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-lg-4">
                    <form data-toggle="validator" id="email-form">
                        <div class="form-group">
                            <label for="email-host">Host:</label>
                            <input type="text" class="form-control" id="email-host" value="" pattern="^[a-z0-9A-Z\:\/\.]{1,255}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="alert alert-warning no-margin-bottom">
                <p><i class="fa fa-fw fa-info-circle"></i> Notice: Changes in those settings affect password recovery option.</p>
            </div>
        </div>
    </div>

</div>
<?php
        $this->getSharedView('Footer')->render();
    }

}