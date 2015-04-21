<?php

class Main_Login_View extends IACS_View
{

    public function render()
    {
        $fields = [
            'user_name' => [
                'type' => 'email',
                'label' => 'מזהה משתמש:',
                'holder' => 'מזהה משתמש',
                'validators' => [
                    'required',
                    'data-error="יש להזין מזהה משתמש חוקי. מזהה המשתמש הוא הדואר האלקטרוני המשוייך לחשבונך."'
                ]
            ],
            'user_password' => [
                'type' => 'password',
                'label' => 'סיסמא:',
                'validators' => [
                    'required',
                    'data-error="יש להזין סיסמא."'
                ]
            ]
        ];
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
                        <?php $this->create_form_fields($fields) ?>
                    </form>
                    <?php $this->alert() ?>
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