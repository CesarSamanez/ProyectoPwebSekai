<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Venta de Articulos
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo __('List'); ?></h3>

        </div>
        <!-- /.box-header -->
 
 
        <div class="box-body table-responsive no-padding">
           <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                  <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('stock') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('referential_price') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('cantidad') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('subtotal') ?></th>
              </tr>
            </thead>
            <tbody>
            <?php $counter=0 ?>
              <?php foreach ($articles as $article): ?>
                <?php if($article->stock!=0): ?>
                
                <tr>
                  <td><?= h($article->name) ?></td>
                  <td id="s<?= $counter ?>"><?= $this->Number->format($article->stock) ?></td>
                  <td><?= $this->Number->format($article->price) ?></td>
                  <td><?= $this->Number->format($article->referential_price) ?></td>
                  <td><input onchange="update(this, <?= $article->referential_price ?>)" type="number" id="q<?= $counter ?>" value="0" min="0" max="<?= ($article->stock) ?>"></td>
                  <td><input type="number" id="t<?= $counter ?>" value="0" min="0"></td>
                  <?php $counter++ ?>
                  <?php endif; ?>
                  
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
           <table id="example1" class="table table-bordered table-striped">
           <tbody>
           <td>Cantidad:<input type="number" id="cant" value="0" readonly></td>
           <td>Total:<input type="number" id="total" value="0" readonly></td>
           </tbody>
           </table>
           <input type="submit" class="btn btn-success" value="Enviar" onclick="hola()">
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
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script>
function update(e, pri){
    var pepe=e.id.substring(1,e.id.length);
    var stock=parseInt(document.getElementById("s"+pepe).innerHTML);
    var sub_quant=document.getElementById("q"+pepe);
    console.log(sub_quant.value);
    console.log(stock);
    if(sub_quant.value>stock ){
      sub_quant.value=stock;
    }
    if(sub_quant.value<0){
      sub_quant.value=0;
    }
    console.log(sub_quant.value);
    var beforeT=parseInt(document.getElementById("t"+pepe).value);
    document.getElementById("t"+pepe).value=pri*sub_quant.value;
    var total=parseInt(document.getElementById("total").value);
    var cant=document.getElementById("cant");
    var lastT=parseInt(document.getElementById("t"+pepe).value);
    document.getElementById("total").value=total+(lastT-beforeT);
    var i=0;
    var pepe2=1;
    cant.value=0;
    while(pepe2){
      var pepe3="q"+i;
      pepe2=document.getElementById(pepe3).value;
      cant.value=parseInt(cant.value)+parseInt(pepe2);
      i++;
    }
    
}
function hola(){
  window.alert("ya vendes prro");
}
</script> 


<?php $this->end(); ?>
