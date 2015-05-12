<?php


namespace Application\Views\Shared;


use Trident\MVC\AbstractView;

class LogoutModal extends AbstractView
{

    /**
     * Render out the view.
     */
    public function render() { ?>
    <!-- Logout modal -->
    <div class="modal fade" id="logout-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-fw fa-power-off"></i> Logout</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal"><i class="fa fa-fw fa-times"></i> Cancel</button>
                    <button type="button" class="btn btn-danger"><i class="fa fa-fw fa-check"></i> Logout</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Logout modal -->
<?php
    }

} 