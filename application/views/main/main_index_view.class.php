<?php

class Main_Index_View extends IACS_View
{

    public function render()
    {
        $this->include_shared_view('header');
        $this->include_shared_view('navbar');
?>
<h1 class="upper-bar"><i class="fa fa-fw fa-home"></i> מסך ראשי</h1>
<div class="container-fluid">

</div>
<?php
        $this->include_shared_view('footer');
    }

} 