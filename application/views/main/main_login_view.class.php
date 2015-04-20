<?php

class Main_Login_View extends IACS_View
{

    public function render()
    {
        $this->include_shared_view('header');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-lg-4 col-lg-offset-4">
            <img src="<?php $this->public_path() ?>/images/logo.png" class="img-responsive margin-bottom margin-top">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>התחברות</strong>
                </div>
                <div class="panel-body">
                    <form method="post" id="login-form" data-toggle="validator">
                        <div class="form-group">
                            <label for="user-name">שם משתמש:</label>
                            <input class="form-control" type="text" id="user-name" name="user_name" required>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="user-password">סיסמא:</label>
                            <input class="form-control" type="password" id="user-password" name="user_password" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer text-left">
                    <a class="btn btn-link" href="<?php $this->public_path() ?>/forgot-password">שכחת סיסמא?</a>
                    <button class="btn btn-primary" onclick="$('#login-form').submit()"><i class="fa fa-sign-in"></i> התחבר</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
        $this->include_shared_view('footer');
    }

} 