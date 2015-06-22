<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Shared;

use Trident\MVC\AbstractView;

/**
 * Class MessageAlert
 *
 * Alert message modal widget.
 *
 * @package Application\Views\Shared
 */
class MessageAlert extends AbstractView
{

    /**
     * Render alert message modal widget.
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