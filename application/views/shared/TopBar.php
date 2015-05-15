<?php


namespace Application\Views\Shared;


use Trident\MVC\AbstractView;
use Application\Entities\User;

/**
 * Class TopBar
 *
 * @property User $currentUser
 * @property string $currentMenuItem
 *
 * @package Application\Views\Shared
 */
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
                    <li class="visible-xs <?php if ($this->currentMenuItem === 'Main'): ?>active<?php endif; ?>"><a href="<?php $this->publicPath() ?>"><i class="fa fa-fw fa-home"></i> ראשי</a><span class="arrow-right"></span></li>
                    <li class="visible-xs <?php if ($this->currentMenuItem === 'Clients'): ?>active<?php endif; ?>"><a href="<?php $this->publicPath() ?>Clients"><i class="fa fa-fw fa-users"></i> לקוחות</a><span class="arrow-right" style="top: 50px"></span></li>
                    <li class="visible-xs <?php if ($this->currentMenuItem === 'Products'): ?>active<?php endif; ?>"><a href="<?php $this->publicPath() ?>Products"><i class="fa fa-fw fa-cubes"></i> מוצרים</a><span class="arrow-right" style="top: 100px"></span></li>
                    <li class="visible-xs <?php if ($this->currentMenuItem === 'Quotes'): ?>active<?php endif; ?>"><a href="<?php $this->publicPath() ?>Quotes"><i class="fa fa-fw fa-database"></i> הצעות מחיר</a><span class="arrow-right" style="top: 150px"></span></li>
                    <li class="visible-xs <?php if ($this->currentMenuItem === 'Invoices'): ?>active<?php endif; ?>"><a href="<?php $this->publicPath() ?>Invoices"><i class="fa fa-fw fa-file-text"></i> חשבוניות עסקה</a><span class="arrow-right" style="top: 200px"></span></li>
                    <li class="visible-xs <?php if ($this->currentMenuItem === 'Licenses'): ?>active<?php endif; ?>"><a href="<?php $this->publicPath() ?>Licenses"><i class="fa fa-fw fa-key"></i> רישיונות</a><span class="arrow-right" style="top: 250px"></span></li>
                    <li class="visible-xs <?php if ($this->currentMenuItem === 'Reports'): ?>active<?php endif; ?>"><a href="<?php $this->publicPath() ?>Reports"><i class="fa fa-fw fa-line-chart"></i> דוחות</a><span class="arrow-right" style="top: 300px"></span></li>
                    <li><a href="<?php $this->publicPath() ?>Profile"><i class="fa fa-fw fa-user"></i> <?php echo $this->currentUser->firstName . ' ' . $this->currentUser->lastName ?></a></li>
                    <li><a href="<?php $this->publicPath() ?>Settings"><i class="fa fa-fw fa-cogs"></i> ניהול</a></li>
                    <li class="danger"><a href="#" data-toggle="modal" data-target="#logout-modal"><i class="fa fa-fw fa-power-off"></i> התנתקות</a></li>
                </ul>
           </div>
        </div>
    </nav>
<?php
    }

}