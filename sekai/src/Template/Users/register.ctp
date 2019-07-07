<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?php $this->layout = 'AdminLTE.register'; ?>

<!-- Content Header (Page header) -->


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
          <?php echo $this->Form->create($user, ['role' => 'form']); ?>
            <div class="box-body">
              <?php
                echo $this->Form->control('name');
                echo $this->Form->control('last_name');
                echo $this->Form->control('dni');
                echo $this->Form->control('address');
                echo $this->Form->control('phone_number');
                echo $this->Form->control('email');
                echo $this->Form->control('username');
                echo $this->Form->control('password');?>
                <strong>Role</strong><br>
                <select name="function">
                <option value="0">Seller</option>
                <option value="1">Admin</option>
              </select><?php
                echo $this->Form->control('status');
              ?>

            </div>
            <!-- /.box-body -->

          <?php echo $this->Form->submit(__('Submit')); ?>

          <?php echo $this->Form->end(); ?>
        </div>
        <!-- /.box -->
      </div>
  </div>
  <!-- /.row -->
</section>
