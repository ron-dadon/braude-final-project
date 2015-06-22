<?php
/***********************************************************************************************************************
 * IACS Management System
 * ORT BRAUDE COLLEGE OF ENGINEERING
 * Information System Engineering - Final Project
 * Students: Ron Dadon, Guy Franco
 * Project adviser: PhD Miri Weiss-Cohen
 **********************************************************************************************************************/

namespace Application\Views\Reports;

use Trident\MVC\AbstractView;
use Application\Entities\Product;

/**
 * Class ProductsSales
 *
 * Show products sales reports.
 *
 * @package Application\Views\Reports\
 */
class ProductsSales extends AbstractView
{

    /**
     * Render products sales report.
     *
     * @throws \Trident\Exceptions\ViewNotFoundException
     */
    public function render()
    {
        $counts = $this->data['counts'];
        $total = $this->data['total'];
        $this->getSharedView('Header')->render();
        $this->getSharedView('TopBar')->render();
        $this->getSharedView('SideBar')->render(); ?>
<div class="container-fluid">
    <div class="page-head bg-main">
        <h1><i class="fa fa-fw fa-cubes"></i> Products sales</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-condensed table-bordered table-hover">
            <thead class="bg-main">
                <tr>
                    <th>#</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Manufacturer</th>
                    <th>Product Type</th>
                    <th>Product License</th>
                    <th>Product Sales</th>
                    <th>Product Percentage</th>
                </tr>
            </thead>
            <tbody>
            <?php $i = 0; foreach ($counts as $row): ?>
                <tr>
                    <?php $count = $row['count']; $product = $row['product']; ?>
                    <td><?php echo ++$i; ?></td>
                    <td><?php echo $product->id; ?></td>
                    <td><a href="<?php $this->publicPath() ?>Products/Show/<?php echo $product->id; ?>"><?php echo $product->name; ?></a></td>
                    <td><?php echo $product->manufactor == 'iacs' ? 'IACS' : 'CaseWare'; ?></td>
                    <td><?php echo ucfirst($product->type); ?></td>
                    <td><?php echo $product->type == 'software' ? $product->license->name : ''; ?></td>
                    <td><?php echo $count; ?></td>
                    <td><?php echo number_format(($count / $total) * 100, 2); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right bg-info">Totals:</td>
                    <td><strong><?php echo $total ?></strong></td>
                    <td><strong>100%</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="row">
        <div class="panel">
            <div class="panel-footer text-right">
                <a href="<?php $this->publicPath() ?>Reports" class="btn btn-link hidden-xs">Reports</a>
                <a href="<?php $this->publicPath() ?>Reports" class="btn btn-link btn-block visible-xs">Reports</a>
            </div>
        </div>
    </div>
</div>
<?php
        $this->getSharedView('Footer')->render();
    }

}