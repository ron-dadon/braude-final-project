<?php


class Main_Login_View extends Trident_Abstract_View
{
    public function render()
    {
        $this->include_shared_view('header');
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-lg-offset-4 col-lg-4">
                <img class="img-responsive center-block margin-bottom-15px" src="<?php $this->public_path()?>/images/logo-xl.png">
                <form method="post" data-toggle="validator">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <strong class="font-125"><span>כניסה למערכת</span></strong>
                        </div>
                        <div class="panel-body">
                            <?php if ($this->get('login-wrong') == true): ?>
                            <div class="alert alert-danger">
                                <strong><i class="fa fa-fw fa-exclamation-circle"></i> שגיאה:</strong> לא ניתן להכנס למערכת. שם המשתמש ו/או הסיסמא אינם תקינים.
                            </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label>משתמש:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
                                    <input class="form-control" type="email" name="user_email" required data-error="יש להזין דואר אלקטרוני כמזהה משתמש" placeholder="דואר אלקטרוני">
                                </div>
                                <span class="help-block with-errors no-margin"></span>
                            </div>
                            <div class="form-group no-margin">
                                <label>סיסמא:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-key"></i></span>
                                    <input class="form-control" type="password" name="user_password" required data-error="יש להזין סיסמא.">
                                </div>
                                <span class="help-block with-errors no-margin"></span>
                            </div>
                        </div>
                        <div class="panel-footer text-left">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-sign-in"></i> כניסה</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
        $this->include_shared_view('footer');
    }
}