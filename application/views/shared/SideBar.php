<?php


namespace Application\Views\Shared;


use Trident\MVC\AbstractView;

/**
 * Class SideBar
 *
 * @property string $currentMenuItem
 *
 * @package Application\Views\Shared
 */
class SideBar extends AbstractView
{

    /**
     * Render out the view.
     */
    public function render() { ?>
    <nav id="side-menu" class="hidden-xs">
        <ul>
            <li <?php if ($this->currentMenuItem === 'Main'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>"><i class="fa fa-fw fa-home"></i> ראשי</a><span class="arrow-right"></span></li>
            <li <?php if ($this->currentMenuItem === 'Clients'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Clients"><i class="fa fa-fw fa-users"></i> לקוחות</a><span class="arrow-right" style="top: 50px"></span></li>
            <li <?php if ($this->currentMenuItem === 'Products'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Products"><i class="fa fa-fw fa-cubes"></i> מוצרים</a><span class="arrow-right" style="top: 100px"></span></li>
            <li <?php if ($this->currentMenuItem === 'Quotes'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Quotes"><i class="fa fa-fw fa-database"></i> הצעות מחיר</a><span class="arrow-right" style="top: 150px"></span></li>
            <li <?php if ($this->currentMenuItem === 'Invoices'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Invoices"><i class="fa fa-fw fa-file-text"></i> חשבוניות עסקה</a><span class="arrow-right" style="top: 200px"></span></li>
            <li <?php if ($this->currentMenuItem === 'Licenses'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Licenses"><i class="fa fa-fw fa-key"></i> רישיונות</a><span class="arrow-right" style="top: 250px"></span></li>
            <li <?php if ($this->currentMenuItem === 'Reports'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Reports"><i class="fa fa-fw fa-line-chart"></i> דוחות</a><span class="arrow-right" style="top: 300px"></span></li>
        </ul>
    </nav>
<?php
    }

}