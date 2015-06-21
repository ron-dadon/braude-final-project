<?php

namespace Application\Views\Licenses;

use Application\Entities\License;
use Application\Entities\Product;
use Application\Entities\Client;
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
        /** @var Client[] $clients */
        $clients = $this->data['clients'];
        /** @var Product[] $products */
        $products = $this->data['products'];
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
    <form method="post" id="new-license-form" data-toggle="validator" enctype="multipart/form-data">
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-lg-4">
                        <div class="form-group">
                            <label for="license-client">Client:</label>
                            <select id="license-client" name="license_client" class="selectpicker" data-live-search="true" data-width="100%">
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?php echo $client->id?>"><?php echo $client->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-4">
                        <div class="form-group">
                            <input type="hidden" id="license-type" name="license_type" value="0">
                            <label for="license-product">Product:</label>
                            <select id="license-product" name="license_product" class="selectpicker" data-live-search="true" data-width="100%">
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo $product->id?>" class="products-list" data-type="<?php echo $product->license ?>"><?php echo $product->name . " ({$product->license->name})" ?></option>
                                <?php endforeach; ?>
                                </select>
                            <script>
                                function updateInvoiceList() {
                                    $.get(appSettings.homeURI + '/Invoices/ByProduct/' + $('#license-product').val() + '/' + $('#license-client').val(), function(data)
                                    {
                                        var json = JSON.parse(data);
                                        var options = '<select id="license-invoice" name="license_invoice" class="selectpicker" data-live-search="true" data-width="100%"><option value="0" selected>None</option>';
                                        for (var i = 0; i < json.length; i++)
                                        {
                                            options += '<option value="' + json[i].id + '">' + json[i].id.toString().pad('0', 8) + '</option>';
                                        }
                                        options += '</select>';
                                        $('#select-invoice').html('<label for="license-invoice">Invoice:</label>').append(options);
                                        $('#license-invoice').selectpicker();
                                    });
                                }
                                function updateLicenseType() {
                                    $('#license-type').val($('.products-list:selected').data('type'));
                                }
                                $(document).on('ready', function() {
                                    $('#license-product').on('change', function() {
                                        updateInvoiceList();
                                        updateLicenseType();
                                    });
                                    $('#license-client').on('change', function() { updateInvoiceList(); });
                                    $('#gen-serial').on('click', function() { $('#license-serial').val(serialGenerator()); $('#new-license-form').validator('validate'); });
                                    updateInvoiceList();
                                    updateLicenseType();
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group" id="select-invoice">
                            <label for="license-invoice">Invoice:</label>
                            <select id="license-invoice" name="license_invoice" class="selectpicker" data-live-search="true" data-width="100%">
                                <option value="0" selected>None</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-2">
                        <div class="form-group">
                            <label for="license-expire">Expiration date:</label>
                            <input type="date" id="license-expire" name="license_expire" class="form-control" value="<?php echo $this->escape(substr($license->expire, 0, 10)) ?>" min="<?php echo $this->escape(substr($license->expire, 0, 10)) ?>" required>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-lg-6">
                        <div class="form-group">
                            <label for="license-serial">Serial:</label>
                            <div class="input-group">
                                <input type="text" id="license-serial" name="license_serial" class="form-control" value="" maxlength="64" pattern="^[a-zA-Z0-9\-]+$" required>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" id="gen-serial" type="button" style="font-size: 14px"><i class="fa fa-fw fa-refresh"></i> Generate</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <div class="form-group">
                            <label for="license-file">Request file:</label>
                            <input id="license-file" type="file" class="file" name="request_file" data-show-preview="false" data-show-upload="false">
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
<!--<script src="<?php $this->publicPath() ?>js/licenses/licenses-new.js?<?php echo date('YmdHis') ?>"></script>-->
<?php
        $this->getSharedView('ConfirmModal')->render();
        $this->getSharedView('MessageModal')->render();
        $this->getSharedView('Footer')->render();
    }

} 