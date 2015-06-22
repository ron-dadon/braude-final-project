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
 * Class MessageModal
 *
 * Message modal widget.
 *
 * @package Application\Views\Shared
 */
class MessageModal extends AbstractView
{

    /**
     * Render message modal widget.
     */
    public function render() { ?>
    <!-- Message modal -->
    <div class="modal fade" id="message-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="message-modal-title"></h4>
                </div>
                <div class="modal-body" id="message-modal-body">
                </div>
            </div>
        </div>
    </div>
    <!-- Message modal end -->
<?php
    }

} 