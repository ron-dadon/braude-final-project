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
 * Class SideBar
 *
 * Side bar widget.
 *
 * @property string $currentMenuItem
 *
 * @package Application\Views\Shared
 */
class SideBar extends AbstractView
{

    /**
     * Render side bar widget.
     */
    public function render() { ?>
    <nav id="side-menu" class="hidden-xs">
        <ul>
            <li <?php if ($this->currentMenuItem === 'Main'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>"><i class="fa fa-fw fa-home"></i> Main</a><span class="arrow"></span></li>
            <li <?php if ($this->currentMenuItem === 'Clients'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Clients"><i class="fa fa-fw fa-users"></i> Clients</a><span class="arrow" style="top: 50px"></span></li>
            <li <?php if ($this->currentMenuItem === 'Products'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Products"><i class="fa fa-fw fa-cubes"></i> Products</a><span class="arrow" style="top: 100px"></span></li>
            <li <?php if ($this->currentMenuItem === 'Quotes'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Quotes"><i class="fa fa-fw fa-database"></i> Quotes</a><span class="arrow" style="top: 150px"></span></li>
            <li <?php if ($this->currentMenuItem === 'Invoices'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Invoices"><i class="fa fa-fw fa-file-text"></i> Invoices</a><span class="arrow" style="top: 200px"></span></li>
            <li <?php if ($this->currentMenuItem === 'Licenses'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Licenses"><i class="fa fa-fw fa-key"></i> Licenses</a><span class="arrow" style="top: 250px"></span></li>
            <li <?php if ($this->currentMenuItem === 'Reports'): ?>class="active"<?php endif; ?>><a href="<?php $this->publicPath() ?>Reports"><i class="fa fa-fw fa-line-chart"></i> Reports</a><span class="arrow" style="top: 300px"></span></li>
        </ul>
    </nav>
<?php
    }

}