<section class="content-header">
  <h1>
    Purchase
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
            <dt scope="row"><?= __('Article') ?></dt>
            <dd><?= $purchase->has('article') ? $this->Html->link($purchase->article->name, ['controller' => 'Articles', 'action' => 'view', $purchase->article->id]) : '' ?></dd>
            <dt scope="row"><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($purchase->id) ?></dd>
            <dt scope="row"><?= __('Quantity') ?></dt>
            <dd><?= $this->Number->format($purchase->quantity) ?></dd>
            <dt scope="row"><?= __('Total') ?></dt>
            <dd><?= $this->Number->format($purchase->total) ?></dd>
            <dt scope="row"><?= __('Date') ?></dt>
            <dd><?= h($purchase->date) ?></dd>
          </dl>
        </div>
      </div>
    </div>
  </div>

</section>
