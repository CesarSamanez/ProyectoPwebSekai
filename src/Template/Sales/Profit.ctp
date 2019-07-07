<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Sales

    <div class="pull-right"><?php echo $this->Html->link(__('New'), ['controller' => 'Articles', 'action' => 'sell'], ['class'=>'btn btn-success btn-xs']) ?></div>
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
        <div >

          <table  class="table table-bordered table-striped">
          <tr><td>
          <button class="button" type="button" onclick="sum()">Obtener Cantidades</button>
        </td><td id="total1"></td><td id="total2"></td><td id="total3"></td>
          </tr>
          </table>
                  </div></div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <div>
            <h3 class="box-title"><?php echo __('Ventas'); ?></h3>

          <table id="example1" class="table table-hover">
            <thead>
              <tr>
                  <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('users_id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                  <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($sales as $sale): ?>
                <tr>
                  <td><?= $this->Number->format($sale->id) ?></td>
                  <td><?= $sale->has('user') ? $this->Html->link($sale->user->name, ['controller' => 'Users', 'action' => 'view', $sale->user->id]) : '' ?></td>
                  <td class="sum1"><?= $this->Number->format($sale->total) ?></td>
                  <td><?= h($sale->date) ?></td>
                  <td class="actions text-right">
                      <?= $this->Html->link(__('View'), ['action' => 'view', $sale->id], ['class'=>'btn btn-info btn-xs']) ?>
                      <?= $this->Html->link(__('Edit'), ['action' => 'edit', $sale->id], ['class'=>'btn btn-warning btn-xs']) ?>
                      <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $sale->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sale->id), 'class'=>'btn btn-danger btn-xs']) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          </div>
          <div>
            <h3 class="box-title"><?php echo __('Compras'); ?></h3>

            <table id="example2" class="table table-hover">
              <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                    <th scope="col" class="actions text-center"><?= __('Actions') ?></th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($purchases as $purchase): ?>
                  <tr>
                    <td><?= $this->Number->format($purchase->id) ?></td>
                    <td ><?= $this->Number->format($purchase->quantity) ?></td>
                    <td class="sum2"><?= $this->Number->format($purchase->total) ?></td>
                    <td><?= h($purchase->date) ?></td>
                    <td class="actions text-right">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $purchase->id], ['class'=>'btn btn-info btn-xs']) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $purchase->id], ['class'=>'btn btn-warning btn-xs']) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $purchase->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchase->id), 'class'=>'btn btn-danger btn-xs']) ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>



            </div>
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
    $('#example2').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : true
    })
  })
</script>

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
document.getElementById("total1").innerHTML="Total Ventas: "+total1;
document.getElementById("total2").innerHTML="Total Compras: "+total2;
document.getElementById("total3").innerHTML="Total Ganacias: "+(total1-total2);

}
</script>

<?php $this->end(); ?>
