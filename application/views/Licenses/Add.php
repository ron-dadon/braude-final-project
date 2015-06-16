<?php


namespace Application\Views\Licenses;

use Application\Entities\License;
use Application\Entities\LicenseType;
use Trident\MVC\AbstractView;

class Add extends AbstractView
{
    public function render()
    {
        /** @var License $license */
        $license = $this->data['license'];
        /** @var LicenseType[] $licenseTypes */
        $licenseTypes = $this->data['license-types'];
        /** @var Clients[] $clients */
        $clients = $this->data['client'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-plus"></i> New license</h1>
    </div>
<?php if (isset($this->data['error'])): ?>
    <div class="alert alert-dismissable alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 <?php if ($license->getErrors() !== null && count($license->getErrors()) > 0): ?>class="margin-bottom"<?php endif; ?>>
            <i class="fa fa-fw fa-times-circle"></i><?php echo $this->data['error'] ?></h4>
<?php if ($license->getErrors() !== null && count($license->getErrors()) > 0): ?>
            <ul>
<?php foreach ($license->getErrors() as $error): ?>
                <li><?php echo $error ?></li>
<?php endforeach; ?>
            </ul>
<?php endif; ?>
    </div>
<?php endif; ?>
    <form method="post" id="new-client-form" data-toggle="validator">
        <div class="panel">
            <div class="panel-heading">
                <h3>License details:</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="license-type">Type:</label>
                            <select id="license-type" name="license_type" class="form-control" autofocus>
<?php foreach ($licenseTypes as $licenseType): ?>
                                <option value="<?php echo $licenseType->id?>"><?php echo $licenseType->name ?></option>
<?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-lg-2">
                                <div class="form-group">
                                    <label for="client-name">Clients:</label>
                                    <select id="client-name" name="client-name" class="form-control" autofocus>
                                        <?php foreach ($clients as $client): ?>
                                            <option value="<?php echo $client->id?>"><?php echo $client->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="license-expire">Expiration date:</label>
                            <input type="date" id="license-expire" name="quote_expire" class="form-control" value="<?php echo $this->escape(substr($license->expire, 0, 10)) ?>" min="<?php echo $this->escape(substr($license->expire, 0, 10)) ?>" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                <div class="row <?php if ($license->type !== "software"): ?>hidden<?php endif; ?>" id="software-details">
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="license-type">License type:</label>
                            <select id="license-type" name="license" class="form-control" autofocus>
<?php foreach ($licenseTypes as $licenseType): ?>
<?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-footer text-right">
                <a href="<?php $this->publicPath() ?>Licenses" class="btn btn-link">Back</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Add license</button>
            </div>
        </div>
    </form>
</div>
<script src="<?php $this->publicPath() ?>js/licenses/licenses-new.js?<?php echo date('YmdHis') ?>"></script>
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('MessageModal')->render();
        $this->getSharedView('Footer')->render();
    }

} 