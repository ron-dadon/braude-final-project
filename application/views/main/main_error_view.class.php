<?php


class Main_Error_View extends Trident_Abstract_View
{
    public function render()
    {
        $this->include_shared_view('header');
    ?>
    <div class="container">
        <div class="alert alert-danger">
            <h2><i class="fa fa-fw fa-exclamation-triangle"></i> <strong>אופס!</strong> משהו השתבש!</h2>
            <p>המשאב שחיפשת אינו קיים או שאינו זמין. אנא השתמש בתפריטי המערכת על מנת להגיע לחלקיה השונים.</p>
            <p>
                <a href="<?php $this->public_path()?>" class="btn btn-danger btn-lg"><i class="fa fa-fw fa-home"></i> חזור למסך הראשי</a>
            </p>
        </div>
    </div>
    <?php
        $this->include_shared_view('footer');
    }
}