<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Reports;

use \Trident\MVC\AbstractView;

/**
 * Class Index
 *
 * Show list of reports.
 *
 * @package Application\Views\Reports
 */
class Index extends AbstractView
{

    /**
     * Render list of reports.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-line-chart"></i> Reports</h1>
    </div>
    <?php if (isset($this->data['error'])): ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger alert-dismissable">
                    <h4><i class="fa fa-fw fa-times-circle"></i><?php echo $this->data['error'] ?></h4>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($this->data['success'])): ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-success alert-dismissable">
                    <h4><i class="fa fa-fw fa-check-circle"></i><?php echo $this->data['success'] ?></h4>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-xs-12 col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="no-margin">Expired licenses</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                    <p>Show all expired licenses within the last <input type="number" class="form-control" id="expire-days" value="30"> days.</p>
                    </form>
                    <button type="button" class="btn btn-primary hidden-xs" onclick="goTo('/Reports/ExpiredLicenses/' + $('#expire-days').val())"><i class="fa fa-fw fa-check-circle"></i> Perform!</button>
                    <button type="button" class="btn btn-primary btn-block visible-xs" onclick="goTo('/Reports/ExpiredLicenses/' + $('#expire-days').val())"><i class="fa fa-fw fa-check-circle"></i> Perform!</button>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="no-margin">Quotes by status</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                    <p>Show all quotes in status <select class="form-control" id="quote-status"><?php foreach ($this->data['quote-status'] as $qs): ?><option value="<?php echo $qs->id ?>"><?php echo $qs->name ?></option><?php endforeach; ?></select></p>
                    </form>
                    <button type="button" class="btn btn-primary hidden-xs" onclick="goTo('/Reports/QuotesByStatus/' + $('#quote-status').val())"><i class="fa fa-fw fa-check-circle"></i> Perform!</button>
                    <button type="button" class="btn btn-primary btn-block visible-xs" onclick="goTo('/Reports/QuotesByStatus/' + $('#quote-status').val())"><i class="fa fa-fw fa-check-circle"></i> Perform!</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="no-margin">Open invoices</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <p>Show all invoices without a tax-invoice.</p>
                    </form>
                    <button type="button" class="btn btn-primary hidden-xs" onclick="goTo('/Reports/OpenInvoices')"><i class="fa fa-fw fa-check-circle"></i> Perform!</button>
                    <button type="button" class="btn btn-primary btn-block visible-xs" onclick="goTo('/Reports/OpenInvoices')"><i class="fa fa-fw fa-check-circle"></i> Perform!</button>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="no-margin">Products sales</h3>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <p>Show all products with their sales statistics.</p>
                    </form>
                    <button type="button" class="btn btn-primary hidden-xs" onclick="goTo('/Reports/ProductsSales')"><i class="fa fa-fw fa-check-circle"></i> Perform!</button>
                    <button type="button" class="btn btn-primary btn-block visible-xs" onclick="goTo('/Reports/ProductsSales')"><i class="fa fa-fw fa-check-circle"></i> Perform!</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

}