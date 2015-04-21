<?php

class Main_Error_View extends IACS_View
{

    public function render()
    {
        $this->include_shared_view('header');
        $this->include_shared_view('navbar');
?>
<h1 class="upper-bar"><i class="fa fa-fw fa-times-circle"></i> שגיאה</h1>
<div class="container-fluid">
    <div class="alert alert-danger">
        <h3 class="no-margins"><strong><i class="fa fa-fw fa-times-circle"></i> התרחשה שגיאה!</strong></h3>
        <p>המשאב המבוקש לא קיים, לא זמין או שאינך בעל הרשאות לגשת אליו.</p>
    </div>
</div>
<?php
        $this->include_shared_view('footer');
    }

} 