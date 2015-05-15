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
                    <h4 class="modal-title"><i class="fa fa-fw fa-power-off"></i> התנתקות</h4>
                </div>
                <div class="modal-body">
                    האם אתה בטוח שברצונך להתנתק?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-fw fa-times"></i> בטל</button>
                    <a href="<?php $this->publicPath() ?>Logout" class="btn btn-danger"><i class="fa fa-fw fa-check"></i> התנתק</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Logout modal -->
<?php
    }

} 