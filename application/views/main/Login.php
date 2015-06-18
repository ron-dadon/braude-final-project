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
        <img src="<?php $this->publicPath() ?>images/logo.png" class="img-responsive"><br>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4><strong>Login</strong></h4>
            </div>
            <div class="panel-body">
                <form data-toggle="validator" id="login-form">
                    <div class="form-group">
                        <label for="user-email">User:</label>
                        <input type="email" class="form-control" id="user-email" placeholder="User E-mail" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label for="user-password">Password:</label>
                        <input type="password" class="form-control" id="user-password" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </form>
                <div class="alert alert-danger no-margin-bottom hidden" id="login-alert">
                    <h4 id="alert-title"></h4>
                    <p id="alert-text"></p>
                </div>
            </div>
            <div class="panel-footer" id="login-footer">
                <button id="login-button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-fw fa-sign-in"></i> Login</button>
            </div>
        </div>
    </div>
</div>
<?php $this->js("js/main/login.js?" . date("Ymdhis")); ?>
</body>
</html>
<?php
    }

}