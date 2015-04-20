<?php

class Navbar_View extends IACS_View
{

    public function render()
    {
?>
    <!-- Navigation bar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <a class="navbar-brand" href="<?php $this->public_path()?>"><strong>IACS</strong></a>
            </div>
            <div class="collapse navbar-collapse" id="main-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><i class="fa fa-fw fa-home"></i> ראשי</a></li>
                    <li><a href="#"><i class="fa fa-fw fa-users"></i> לקוחות</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End of navigation bar -->
<?php
    }
}