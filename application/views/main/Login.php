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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><strong>התחברות למערכת</strong></h4>
            </div>
            <div class="panel-body">
                <form data-toggle="validator" id="login-form">
                    <div class="form-group">
                        <label for="user-email">מזהה משתמש:</label>
                        <input type="email" class="form-control" id="user-email" required>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label for="user-password">סיסמא:</label>
                        <input type="password" class="form-control" id="user-password" required>
                        <div class="help-block with-errors"></div>
                    </div>
                </form>
                <div class="alert alert-danger no-margin-bottom hidden" id="login-alert">
                    <h4 id="alert-title"></h4>
                    <p id="alert-text"></p>
                </div>
            </div>
            <div class="panel-footer text-left">
                <button id="login-button" class="btn btn-primary"><i class="fa fa-fw fa-sign-in"></i> התחבר</button>
            </div>
        </div>
    </div>
</div>
<?php $this->js("js/main/login.js"); ?>
</body>
</html>
<?php
    }

    public function js($file)
    {
        $file = $this->publicPath(true) . $file;
        echo "<script src=\"" . $file . "\"></script>" . PHP_EOL;
    }

}