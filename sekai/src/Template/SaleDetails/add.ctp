<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SaleDetail $saleDetail
 */
?>
<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Sale Detail
      <small><?php echo __('Add'); ?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo $this->Url->build(['action' => 'index']); ?>"><i class="fa fa-dashboard"></i> <?php echo __('Home'); ?></a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo __('Form'); ?></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <!-- <?php echo $this->Form->create($saleDetail, ['role' => 'form']); ?>
            <div class="box-body">
              <?php
                echo $this->Form->control('articles_id', ['options' => $articles]);
                echo $this->Form->control('sales_id', ['options' => $sales]);
                echo $this->Form->control('quantity');
                echo $this->Form->control('total');
              ?>
            </div>-->
            <!-- /.box-body -->

          <!--<?php echo $this->Form->submit(__('Submit')); ?>

          <?php echo $this->Form->end(); ?>
        </div>-->
        <!-- /.box -->
      </div>
  </div>
  <!-- /.row -->
</section>
