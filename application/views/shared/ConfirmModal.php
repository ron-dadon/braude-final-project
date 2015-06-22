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
 * Class ConfirmModal
 *
 * Confirm modal widget.
 *
 * @package Application\Views\Shared
 */
class ConfirmModal extends AbstractView
{

    /**
     * Render confirm modal widget.
     */
    public function render() { ?>
    <!-- Message modal -->
    <div class="modal fade" id="confirm-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="confirm-modal-title"></h4>
                </div>
                <div class="modal-body" id="confirm-modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-fw fa-times"></i> Cancel</button>
                    <button type="button" id="confirm-button" class="btn"></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Message modal end -->
<?php
    }

} 