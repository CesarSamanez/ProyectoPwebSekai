<!-- File: src/Template/Users/login.ctp -->
<?php $this->layout = 'AdminLTE.login'; ?>
<?= $this->Html->css(captcha_layout_stylesheet_url(), ['inline' => false]) ?>

<div class="users form">
<?= $this->Flash->render() ?>
<?= $this->Form->create() ?>
<fieldset>
  <div class="form-group has-feedback">
    <input type="text" class="form-control" placeholder="Username" name="username">
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
  </div>
  <div class="form-group has-feedback">
    <input type="password" class="form-control" placeholder="Password" name="password">
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
  </div>
  <!-- show captcha image -->
<?= captcha_image_html() ?>
<!-- Captcha code user input textbox -->
<?= $this->Form->input('CaptchaCode', [
  'label' => 'Retype the characters from the picture:',
  'maxlength' => '10',
  'style' => 'width: 270px;',
  'id' => 'CaptchaCode'
]) ?>
 </fieldset>
<?= $this->Form->button(__('Login')); ?>
<?= $this->Form->end() ?>
</div>
