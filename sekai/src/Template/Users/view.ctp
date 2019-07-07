<section class="content-header">
  <h1>
    User
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
            <dt scope="row"><?= __('Name') ?></dt>
            <dd><?= h($user->name) ?></dd>
            <dt scope="row"><?= __('Last Name') ?></dt>
            <dd><?= h($user->last_name) ?></dd>
            <dt scope="row"><?= __('Address') ?></dt>
            <dd><?= h($user->address) ?></dd>
            <dt scope="row"><?= __('Email') ?></dt>
            <dd><?= h($user->email) ?></dd>
            <dt scope="row"><?= __('Username') ?></dt>
            <dd><?= h($user->username) ?></dd>
            <dt scope="row"><?= __('Password') ?></dt>
            <dd><?= h($user->password) ?></dd>
            <dt scope="row"><?= __('Id') ?></dt>
            <dd><?= $this->Number->format($user->id) ?></dd>
            <dt scope="row"><?= __('Dni') ?></dt>
            <dd><?= $this->Number->format($user->dni) ?></dd>
            <dt scope="row"><?= __('Phone Number') ?></dt>
            <dd><?= $this->Number->format($user->phone_number) ?></dd>
            <dt scope="row"><?= __('Function') ?></dt>
            <dd><?= $this->Number->format($user->function) ?></dd>
            <dt scope="row"><?= __('Status') ?></dt>
            <dd><?= $user->status ? __('Yes') : __('No'); ?></dd>
          </dl>
        </div>
      </div>    <?= $this->Html->link(__('Edit your profile'), ['controller' => 'Users', 'action' => 'editID'],["class"=>"btn btn-default btn-flat"]) ?>

    </div>
  </div>

</section>
