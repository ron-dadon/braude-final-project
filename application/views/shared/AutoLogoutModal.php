<?php


namespace Application\Views\Shared;


use Trident\MVC\AbstractView;

class AutoLogoutModal extends AbstractView
{

    /**
     * Render out the view.
     */
    public function render() { ?>
    <!-- Logout modal -->
    <div class="modal fade" id="auto-logout-modal" tabindex="-1" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title"><i class="fa fa-fw fa-power-off"></i> Auto logout</h4>
                </div>
                <div class="modal-body">
                    You didn't use the system for a long time, and you where automatically logged out. Please login again to continue.
                </div>
                <div class="modal-footer">
                    <a href="<?php $this->publicPath() ?>" class="btn btn-default"><i class="fa fa-fw fa-sign-in"></i> Go to login</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Logout modal -->
<?php
    }

} 