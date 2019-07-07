<!-- File: src/Template/Users/email.ctp -->
<?php $this->layout = 'AdminLTE.forgot'; ?>

<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
    <fieldset>
        <legend><center><?= __('Please enter your email') ?></center></legend>
        <?= $this->Form->control('email') ?>


    </fieldset>
<?= $this->Form->button(__('Get my password')); ?>
<?= $this->Form->end() ?>
</div>
