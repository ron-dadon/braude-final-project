<?php


class Main_Search_View extends Trident_Abstract_View
{
    public function render()
    {
        $this->include_shared_view('header');
        $this->include_shared_view('navbar');
    ?>
    <div class="well well-sm top-fixed-header">
        <h2 class="no-margin">חיפוש</h2>
    </div>
    <div class="container-fluid">
        <?php if ($this->get('search-term') !== null): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>תוצאות חיפוש עבור: </strong><?php echo $this->get('search-term')?>
            </div>
            <div class="panel-body">
                Results
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-danger">
            <p><strong><i class="fa fa-fw fa-exclamation-circle"></i> לא ניתן לבצע חיפוש.</strong> לא הוזן מונח לחיפוש. מלא מונח לחיפוש ולאחר מכן לחץ על &quot;חפש&quot;.</p>
        </div>
        <div class="row">
            <div class="col-xs-12 col-lg-4 col-lg-offset-4">
                <form method="post" action="<?php $this->public_path()?>/search" data-toggle="validator">
                    <div class="input-group">
                        <input type="text" class="form-control" name="global_search" required placeholder="חפש במערכת...">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> חפש</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php
        $this->include_shared_view('footer');
    }
}