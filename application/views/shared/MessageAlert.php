<?php


namespace Application\Views\Shared;


use Trident\MVC\AbstractView;

class MessageAlert extends AbstractView
{

    /**
     * Render out the view.
     */
    public function render() { ?>
        <!-- Message alert -->
        <div class="alert alert-dismissable fade in" id="message-alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 id="message-alert-title"></h4>
            <span id="message-alert-body"></span>
        </div>
        <!-- Message alert end -->
    <?php
    }

} 