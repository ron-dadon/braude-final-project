<?php

namespace Application\Views\Main;

use \Trident\MVC\AbstractView;

class Login extends AbstractView
{

    public function render()
    {
        $this->getSharedView('Header')->render(); ?>
<div class="container-fluid" id="login-container">
    <div class="col-xs-12 col-lg-4 col-lg-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Login</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="user-email">User email:</label>
                    <input type="email" class="form-control" id="user-email">
                </div>
                <div class="form-group">
                    <label for="user-password">Password:</label>
                    <input type="password" class="form-control" id="user-password">
                </div>
            </div>
            <div class="panel-footer text-left">
                <button id="login-button" class="btn btn-primary"><i class="fa fa-fw fa-sign-in"></i> Login</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/login.js" type="text/javascript"></script>
<?php
        $this->getSharedView('Footer')->render();
    }

}