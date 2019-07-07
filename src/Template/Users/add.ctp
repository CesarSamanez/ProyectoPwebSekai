<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?= $this->Html->css(captcha_layout_stylesheet_url(), ['inline' => false]) ?>

<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User
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
          <?php echo $this->Form->create($user, ['role' => 'form']); ?>
            <div class="box-body">
              <?php
                echo $this->Form->control('name');
                echo $this->Form->control('last_name');
                echo $this->Form->control('dni',["maxlength" => "8"]);
                echo $this->Form->control('address');
                echo $this->Form->control('phone_number',["maxlength" => "9"]);
                echo $this->Form->control('email');
                echo $this->Form->control('username');
                echo $this->Form->control('password');
                ?>
                <strong>Role</strong><br>
                <select name="function">
                <option value="0">Seller</option>
                <option value="1">Admin</option>
              </select>
                <?php
                echo $this->Form->control('status');
              ?>
              <?= captcha_image_html() ?>
              <!-- Captcha code user input textbox -->
              <?= $this->Form->input('CaptchaCode', [
                'label' => 'Retype the characters from the picture:',
                'maxlength' => '10',
                'style' => 'width: 270px;',
                'id' => 'CaptchaCode'
              ]) ?>
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
