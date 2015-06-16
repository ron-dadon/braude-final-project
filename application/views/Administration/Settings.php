<?php

namespace Application\Views\Administration;

use \Trident\MVC\AbstractView;

class Settings extends AbstractView
{

    public function render()
    {
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-cogs"></i> Settings</h1>
    </div>
    <div id="alerts-container"></div>
    <div class="row">
        <form data-toggle="validator" id="settings-form">
            <div class="col-xs-12 col-lg-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-shield"></i> Security</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-lg-6">
                                <div class="form-group">
                                    <label for="security-idle-logout">Auto logout on idle:</label>
                                    <select id="security-idle-logout" class="form-control" required>
                                        <option value="1" <?php if ($this->data['security-idle-logout']) echo 'selected' ?>>Yes</option>
                                        <option value="0" <?php if (!$this->data['security-idle-logout']) echo 'selected' ?>>No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-6">
                                <div class="form-group">
                                    <label for="security-idle-logout-time">Idle time to auto logout:</label>
                                    <input type="number" class="form-control" id="security-idle-logout-time" value="<?php echo $this->escape($this->data['security-idle-logout-time']) ?>" min="1" max="120" <?php if (!$this->data['security-idle-logout']) echo 'disabled' ?> required>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-danger no-margin-bottom">
                            <p><i class="fa fa-fw fa-info-circle"></i> Notice: changes in those settings have a security effect.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-asterisk"></i> General</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="general-tax">Tax rate (%):</label>
                                    <input type="number" class="form-control" id="general-tax" value="<?php echo $this->escape($this->data['tax']) ?>" min="0" max="100" required step="0.05">
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info no-margin-bottom">
                            <p><i class="fa fa-fw fa-info-circle"></i>Tax rate affects all application.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4><i class="fa fa-fw fa-envelope"></i> Email</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-lg-3">
                                <div class="form-group">
                                    <label for="email-host">Host:</label>
                                    <input type="text" class="form-control" id="email-host" value="<?php echo $this->escape($this->data['email-host']) ?>" required pattern="^[a-z0-9A-Z\:\/\.\-]{0,}$">
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-1">
                                <div class="form-group">
                                    <label for="email-port">Port:</label>
                                    <input type="number" class="form-control" id="email-port" value="<?php echo $this->escape($this->data['email-port']) ?>" required min="1" max="65535">
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-2">
                                <div class="form-group">
                                    <label for="email-security">Security:</label>
                                    <select id="email-security" class="form-control" required>
                                        <option value="none" <?php if ($this->data['email-security'] === 'none') echo 'selected' ?>>None</option>
                                        <option value="ssl" <?php if ($this->data['email-security'] === 'ssl') echo 'selected' ?>>SSL</option>
                                        <option value="tls" <?php if ($this->data['email-security'] === 'tls') echo 'selected' ?>>TLS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-3">
                                <div class="form-group">
                                    <label for="email-user">User name:</label>
                                    <input type="text" class="form-control" id="email-user" value="<?php echo $this->escape($this->data['email-user']) ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-3">
                                <div class="form-group">
                                    <label for="email-password">Password:</label>
                                    <input type="text" class="form-control" id="email-password" value="<?php echo $this->escape($this->data['email-password']) ?>">
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-warning no-margin-bottom">
                            <p><i class="fa fa-fw fa-info-circle"></i> Notice: Changes in those settings affect automatic e-mail notifications.</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-dismissable hidden" id="save-message"></div>
            <div class="panel panel-default">
                <div class="panel-footer text-right">
                    <a href="<?php $this->publicPath() ?>Administration" class="btn btn-link">Back</a>
                    <button id="save-button" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <?php $this->js("js/administration/settings.js?" . date('YmdHis')); ?>
</div>
<?php
        $this->getSharedView('MessageModal')->render();
        $this->getSharedView('Footer')->render();
    }

}