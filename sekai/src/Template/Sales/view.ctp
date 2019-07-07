<section class="content-header">
  <h1>
    Sale
    <small><?php echo __('View'); ?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo $this->Url->build(['action' => 'index']); ?>"><i class="fa fa-dashboard"></i> <?php echo __('Home'); ?></a></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-info"></i>
          <h3 class="box-title"><?php echo __('Information'); ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <dl class="dl-horizontal">
            <dt scope="row"><?= __('User') ?></dt>
            <dd><?= $sale->has('user') ? $this->Html->link($sale->user->name, ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></dd>
            <dt scope="row"><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($sale->id) ?></dd>
            <dt scope="row"><?= __('Total') ?></dt>
            <dd><?= $this->Number->format($sale->total) ?></dd>
            <dt scope="row"><?= __('Voucher Number') ?></dt>
            <dd><?= $this->Number->format($sale->voucher_number) ?></dd>
            <dt scope="row"><?= __('Date') ?></dt>
            <dd><?= h($sale->date) ?></dd>
          </dl>
        </div>
        <div class="box-body table-responsive no-padding">
          <table class="table table-hover">
            <thead>
              <tr>
                  <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('total') ?></th>

              </tr>
            </thead>
            <tbody>
              <?php foreach ($saledet as $saleDetail): ?>
                <tr>
                  <td><?= $this->Number->format($saleDetail->id) ?></td>
                  <td><?= $saleDetail->has('article') ? $this->Html->link($saleDetail->article->name, ['controller' => 'Articles', 'action' => 'view', $saleDetails->article->id]) : '' ?></td>
                  <td><?= $this->Number->format($saleDetail->quantity) ?></td>
                  <td><?= $this->Number->format($saleDetail->total) ?></td>
                </tr>
                <tr>

                </tr>
              <?php endforeach; ?>
                <td></td><td>TOTAL</td><td></td><td><?= $this->Number->format($sale->total) ?></td>
            </tbody>
          </table>
</div>
      </div>
    </div>
  </div>

</section>
