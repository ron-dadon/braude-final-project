<?php


namespace Application\Views\Shared;


use Trident\MVC\AbstractView;

class TopBar extends AbstractView
{

    /**
     * Render out the view.
     */
    public function render() { ?>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobile-menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">IACS</a>
            </div>
            <div class="collapse navbar-collapse" id="mobile-menu">
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="#"><i class="fa fa-fw fa-cogs"></i> Settings</a></li>
                    <li class="danger"><a href="#"><i class="fa fa-fw fa-power-off"></i> Logout</a></li>
                </ul>
           </div>
        </div>
    </nav>
<?php
    }

}