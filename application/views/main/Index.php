<?php

namespace Application\Views\Main;

use \Trident\MVC\AbstractView;
use Application\Entities\User;
use Application\Entities\Quote;
use Application\Entities\Invoice;
use Application\Entities\License;
/**
 * Class Index
 * @property User $currentUser
 * @package Application\Views\Main
 */
class Index extends AbstractView
{

    public function render()
    {
        $time = date('H');
        if ($time >= 0 && $time < 6 || $time >= 20 && $time <= 23)
        {
            $welcomeMessage = "Good night";
        }
        elseif ($time >= 6 && $time < 12)
        {
            $welcomeMessage = "Good morning";
        }
        elseif ($time >= 12 && $time < 16)
        {
            $welcomeMessage = "Good noon";
        }
        elseif ($time >= 16 && $time < 18)
        {
            $welcomeMessage = "Good after noon";
        }
        else
        {
            $welcomeMessage = "Good evening";
        }
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main" style="max-height: 60px">
        <h1 class="visible-lg"><i class="fa fa-fw fa-home"></i> <?php echo $welcomeMessage . ' <strong>' . $this->currentUser->firstName . ' ' . $this->currentUser->lastName . '</strong>' ?>!</h1>
        <h3 class="visible-xs"><i class="fa fa-fw fa-home"></i> <?php echo $welcomeMessage . ' <strong>' . $this->currentUser->firstName . ' ' . $this->currentUser->lastName . '</strong>' ?>!</h3>
    </div>
    <div class="row">
        <div class="col-xs-12 col-lg-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-fw fa-money"></i> USD-NIS Exchange rate:
                </div>
                <div class="panel-body">
                    1 NIS = <?php echo $this->data['usd-rate'] ?> USD
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-fw fa-list"></i> Summarize:
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge"><?php echo $this->data['clients-count']; ?></span>
                        Clients
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?php echo $this->data['products-count']; ?></span>
                        Products
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?php echo $this->data['quotes-count']; ?></span>
                        Quotes
                    </li>
                    <li class="list-group-item">
                        <span class="badge"><?php echo $this->data['invoices-count']; ?></span>
                        Invoices
                    </li>
                </ul>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-fw fa-cubes"></i> Top products:
                </div>
                <ul class="list-group">
                    <?php foreach ($this->data['top-selling-products'] as $row): ?>
                    <li class="list-group-item">
                        <span class="badge"><?php echo $row['count'] ?></span>
                        <?php
                            echo $row['product']->name;
                            if ($row['product']->type == 'software') {
                                echo ' (' . $row['product']->license->name . ')';
                            }
                        ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="col-xs-12 col-lg-9">
            <div class="col-xs-12">
<?php /** @var Quote[] $quotes */ $quotes = $this->data['quotes']; if (count($quotes)): ?>
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <i class="fa fa-fw fa-exclamation-circle"></i> Non approved quotes:
                    </div>
                    <div class="list-group">
<?php $total = 0; $totalTax = 0; foreach ($quotes as $quote): ?>
                        <a class="list-group-item" href="<?php $this->publicPath() ?>Quotes/Show/<?php echo $quote->id ?>"><i class="fa fa-fw fa-database"></i> Quote No. <?php echo str_pad($quote->id, 8, '0', STR_PAD_LEFT) ?></a>
                        <?php $totalTax += $quote->getTotalWithTax(); ?>
                        <?php $total += $quote->getSubTotal(); ?>
<?php endforeach; ?>
                    </div>
                    <div class="panel-footer">
                        Total (+Tax): <?php echo number_format($total) ?> (<?php echo number_format($totalTax) ?>) NIS
                    </div>
                </div>
<?php endif; ?>
                <?php /** @var Invoice[] $invoices */ $invoices = $this->data['invoices']; $total = 0; $totalTax = 0; if (count($invoices)): ?>
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-fw fa-exclamation-circle"></i> Non paid invoices:
                        </div>
                        <div class="list-group">
                            <?php foreach ($invoices as $invoice): ?>
                                <a class="list-group-item" href="<?php $this->publicPath() ?>Invoice/Show/<?php echo $invoice->id ?>"><i class="fa fa-fw fa-file-text"></i> Invoice No. <?php echo str_pad($invoice->id, 8, '0', STR_PAD_LEFT) ?></a>
                                <?php $totalTax += $invoice->quote->getTotalWithTax(); ?>
                                <?php $total += $invoice->quote->getSubTotal(); ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="panel-footer">
                            Total (+Tax): <?php echo number_format($total) ?> (<?php echo number_format($totalTax) ?>) NIS
                        </div>
                    </div>
                <?php endif; ?>
                <?php /** @var License[] $licenses */ $licenses = $this->data['expire-licenses']; if (count($licenses)): ?>
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-fw fa-exclamation-circle"></i> Licenses expiring / expired this month:
                        </div>
                        <div class="list-group">
                            <?php foreach ($licenses as $license): ?>
                                <a class="list-group-item" href="<?php $this->publicPath() ?>Licenses/Show/<?php echo $license->id ?>"><i class="fa fa-fw fa-key"></i> License <?php echo $license->serial ?> (<?php echo $this->escape($license->client->name) ?>)</a>
                            <?php endforeach; ?>
                        </div>
                        <div class="panel-footer">
                            No. Of Licenses: <?php echo number_format(count($licenses)) ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-fw fa-line-chart"></i> Yearly quotes:
                    </div>
                    <div class="panel-body">
                        <canvas id="year-quotes" style="width: 100%; height: 150px"></canvas>
                        <script>
                            var ctxQuoteYear = document.getElementById('year-quotes').getContext('2d');
                            var dataQuoteYear = {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                datasets: [
                                    {
                                        label: "Yearly quotes",
                                        fillColor: "rgba(220,220,220,0.2)",
                                        strokeColor: "#204d74",
                                        pointColor: "#204d74",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(220,220,220,1)",
                                        data: [<?php echo implode(',', $this->data['quotes-months']) ?>]
                                    }
                                ]
                            };
                            var chartQuoteYear = new Chart(ctxQuoteYear).Line(dataQuoteYear, {bezierCurve : false});
                        </script>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-fw fa-line-chart"></i> Yearly invoices:
                    </div>
                    <div class="panel-body">
                        <canvas id="year-invoices" style="width: 100%; height: 150px"></canvas>
                        <script>
                            var ctxInvoiceYear = document.getElementById('year-invoices').getContext('2d');
                            var dataInvoiceYear = {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                datasets: [
                                    {
                                        label: "Yearly invoices",
                                        fillColor: "rgba(220,220,220,0.2)",
                                        strokeColor: "#204d74",
                                        pointColor: "#204d74",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(220,220,220,1)",
                                        data: [<?php echo implode(',', $this->data['invoices-months']) ?>]
                                    }
                                ]
                            };
                            var chartInvoiceYear = new Chart(ctxInvoiceYear).Line(dataInvoiceYear, {bezierCurve : false});
                        </script>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-fw fa-line-chart"></i> Yearly incomes (NIS) based of invoices:
                    </div>
                    <div class="panel-body">
                        <canvas id="year-incomes" style="width: 100%; height: 150px"></canvas>
                        <small>Blue line: Income | Orange line: Income + Tax</small>
                        <script>
                            var ctxIncomeYear = document.getElementById('year-incomes').getContext('2d');
                            var dataIncomeYear = {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                datasets: [
                                    {
                                        label: "Yearly incomes",
                                        fillColor: "rgba(30,115,164,0.6)",
                                        strokeColor: "#204d74",
                                        highlightFill: "rgba(30,115,164,0.9)",
                                        highlightStroke: "#204d74",
                                        data: [<?php echo implode(',', $this->data['income-months']['total']) ?>]
                                    },
                                    {
                                        label: "Yearly incomes with tax",
                                        fillColor: "rgba(225,95,30,0.6)",
                                        strokeColor: "#ff6620",
                                        highlightFill: "rgba(225,95,30,0.9)",
                                        highlightStroke: "#ff6620",
                                        data: [<?php echo implode(',', $this->data['income-months']['total-tax']) ?>]
                                    }
                                ]
                            };
                            var chartIncomeYear = new Chart(ctxIncomeYear).Bar(dataIncomeYear);
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

}