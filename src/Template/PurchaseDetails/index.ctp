<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Purchase Details

    <div class="pull-right"><?php echo $this->Html->link(__('New'), ['action' => 'add'], ['class'=>'btn btn-success btn-xs']) ?></div>
  </h1>
</section>
<style>
.button {
  background-color: #4CAF50;
  border: none;
  color: white;

  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo __('List'); ?></h3>
          <!--Boton y caja -->
          <div >

          <table class="table table-bordered table-striped">
          <tr><td>
          <button class="button" type="button" onclick="sum()">Obtener Cantidades</button>
          </td><td id="total1"></td><td id="total2"></td>
          </tr>
          </table>
                  </div>
                  </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                  <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('article_id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('purchase_id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>

                  <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                  <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($purchaseDetails as $purchaseDetail): ?>
                <tr>
                  <td><?= $this->Number->format($purchaseDetail->id) ?></td>
                  <td><?= $purchaseDetail->has('article') ? $this->Html->link($purchaseDetail->article->name, ['controller' => 'Articles', 'action' => 'view', $purchaseDetail->article->id]) : '' ?></td>

                  <td><?= $purchaseDetail->has('purchase') ? $this->Html->link($purchaseDetail->purchase->id, ['controller' => 'Purchases', 'action' => 'view', $purchaseDetail->purchase->id]) : '' ?></td>
                  <td class="sum1"><?= $this->Number->format($purchaseDetail->quantity) ?></td>

                  <td class="sum2"><?= $this->Number->format($purchaseDetail->total) ?></td>

                  <td><?= h($purchaseDetail->date) ?></td>

                  <td class="actions text-right">
                      <?= $this->Html->link(__('View'), ['action' => 'view', $purchaseDetail->id], ['class'=>'btn btn-info btn-xs']) ?>
                      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $purchaseDetail->id], ['class'=>'btn btn-warning btn-xs']) ?>
                      <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $purchaseDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseDetail->id), 'class'=>'btn btn-danger btn-xs']) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<?php echo $this->Html->css('AdminLTE./bower_components/datatables.net-bs/css/dataTables.bootstrap.min', ['block' => 'css']); ?>

<!-- DataTables -->
<?php echo $this->Html->script('AdminLTE./bower_components/datatables.net/js/jquery.dataTables.min', ['block' => 'script']); ?>
<?php echo $this->Html->script('AdminLTE./bower_components/datatables.net-bs/js/dataTables.bootstrap.min', ['block' => 'script']); ?>


<?php $this->start('scriptBottom'); ?>
<script>
  $(function () {
    $('#example1').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : true
    })
  })
</script>
<script>
function sum() {
var sum1 = document.getElementsByClassName("sum1");
var sum2 = document.getElementsByClassName("sum2");
var total1 = 0;
var total2 = 0;
for (i = 0; i < sum1.length; i++) {
  total1 = total1+parseFloat(sum1[i].innerHTML);
  total2 = total2+parseFloat(sum2[i].innerHTML);
}
document.getElementById("total1").innerHTML="Cantidad Total: "+total1;
document.getElementById("total2").innerHTML="Total General: "+total2;
}
</script>


<?php $this->end(); ?>
