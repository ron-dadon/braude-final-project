<?php

class Main_Index_View extends IACS_View
{

    public function render()
    {
        $this->include_shared_view('header');
        $this->include_shared_view('navbar');
?>
<div class="container-fluid">
</div>
<?php
        $this->include_shared_view('footer');
    }

} 