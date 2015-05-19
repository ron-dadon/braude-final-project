<?php


namespace Application\Views\Shared;


use Trident\MVC\AbstractView;

class MessageModal extends AbstractView
{

    /**
     * Render out the view.
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