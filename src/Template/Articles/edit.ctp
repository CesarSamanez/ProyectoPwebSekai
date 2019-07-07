<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Article
      <small><?php echo __('Edit'); ?></small>
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
          <?php echo $this->Form->create($article, ['role' => 'form']); ?>
            <div class="box-body">
              <?php
                echo $this->Form->control('categories_id', ['options' => $categories]);
                echo $this->Form->control('name',['onchange'=>"grabar()"] );
                echo $this->Form->control('code');
                echo $this->Form->control('description');
                echo $this->Form->control('stock');
                echo $this->Form->control('price');
                echo $this->Form->control('referential_price');
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
<script>
function grabar(){
var data= document.getElementById("name").value;
var ram=Math.floor(Math.random() * data.length)-1;
document.getElementById("code").value=data.substr(0,1)+"0"+(ram+Math.floor(Math.random() * data.length))+data.length+data.substr(1,2);
}
</script> 
