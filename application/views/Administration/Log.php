<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Administration;

use \Trident\MVC\AbstractView;
use Application\Entities\LogEntry;

/**
 * Class Log
 *
 * Show system events log.
 *
 * @package Application\Views\Administration
 */
class Log extends AbstractView
{

    /**
     * Render system events log.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        /** @var LogEntry[] $entries */
        $entries = $this->data['entries'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-th-list"></i> Log</h1>
    </div>
    <div class="panel">
        <div class="table-responsive">
            <table class="table table-bordered" id="log-table">
                <thead>
                    <tr>
                        <th data-column-id="name" data-type="numeric">#</th>
                        <th data-column-id="timestamp">Time stamp</th>
                        <th data-column-id="user">User</th>
                        <th data-column-id="browser">Browser</th>
                        <th data-column-id="platform">Platform</th>
                        <th data-column-id="ip">IP</th>
                        <th data-column-id="entry">Entry</th>
                        <th data-column-id="level" data-formatter="logLevel">Level</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($entries as $entry): ?>
                    <tr>
                        <td><?php echo $entry->id ?></td>
                        <td><?php echo $this->formatSqlDateTime($entry->ts) ?></td>
                        <td><?php if ($entry->user !== null) { echo $this->escape($entry->user->firstName . ' ' . $entry->user->lastName); } else { echo 'n/a'; } ?></td>
                        <td><?php echo $entry->browser ?></td>
                        <td><?php echo $entry->platform ?></td>
                        <td><?php echo $this->escape($entry->ip) ?></td>
                        <td><?php echo $this->escape($entry->entry) ?></td>
                        <td><?php echo $entry->level ?></td>
                    </tr>
<?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="panel-footer text-right">
                <a href="<?php $this->publicPath() ?>Administration" class="btn btn-link hidden-xs">Back</a>
                <a href="<?php $this->publicPath() ?>Administration" class="btn btn-link btn-block visible-xs">Back</a>
            </div>
        </div>
    </div>
</div>
<script src="<?php $this->publicPath() ?>js/administration/log.js"></script>
<?php
        $this->getSharedView('Footer')->render();
    }

}