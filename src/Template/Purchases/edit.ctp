<!-- Content Header (Page header) -->
<section class="content-header">
<?php echo $this->Html->css('buy'); ?>
  <h1>
    Purchase of Articles
  </h1>
</section>

<!-- Main content -->
<?php
echo $this->Form->create($purchase, [
    'url' => [
        'controller' => 'Purchases',
        'action' => 'edit'
    ]
]);
?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo __('List'); ?></h3>

        </div>
        <!-- /.box-header -->
        <div>
        <div align="center">
     <div class="custom-select" style="width:200px;"><select id="TB">
    <option value="-1">Tipo de busqueda:</option>
    <option value="1">Searching for name</option>
    <option value="2">Searching for Categoria</option>

  </select>
</div>
     <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search" title="Type in a name">
    </div><div>

        <div class="box-body table-responsive no-padding">
           <table id="myTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                  <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('categories') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('stock') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('referential_price') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('cantidad') ?></th>
                  <th scope="col"><?= $this->Paginator->sort('subtotal') ?></th>
              </tr>
            </thead>
            <tbody>
            <?php $counter=0 ?>
            <!-- <input type="checkbox" id="showSelling" value="0" onchange="show(this)"> Vendiendo -->
            <?php
                $selling="";
                foreach ($purchase_details as $purdet){
                  $selling.=$purdet->article_id."-";
                }

                ?>
            <input id="selling" value="<?= $selling ?>" name="selling" readonly>
            Editando compra: <input id="id" name="id" value="<?= $purchase->id ?>" readonly>
              <?php foreach ($articles as $article): ?>
                <?php
                $sub_quant=0;
                $sub_total=0;
                foreach ($purchase_details as $purdet){
                  if($purdet->article_id==$article->id){
                    $sub_quant=$purdet->quantity;
                    $sub_total=$purdet->total;
                    break;
                  }
                }

                ?>
            <tr id="tr<?= h($article->id) ?>">
                  <td><?= h($article->id) ?></td>
                  <td><?= h($article->name) ?></td>
                  <td><?= $article->has('category') ? $this->Html->link($article->category->name, ['controller' => 'Categories', 'action' => 'view', $article->category->id]) : '' ?></td>
                  <td id="s<?= $article->id ?>"><?= $this->Number->format($article->stock) ?></td>
                  <td><?= $this->Number->format($article->price) ?></td>
                  <td><?= $this->Number->format($article->referential_price) ?></td>
                  
                  <td><input onchange="update(this, <?= $article->referential_price ?>)" type="number" id="q<?= $article->id ?>" value="<?= $sub_quant ?>" min="0" max="<?= ($article->stock) ?>" name="q<?= $article->id ?>"></td>
                  <td><input onchange="updateTotal()" type="number" id="t<?= $article->id ?>" value="<?= $sub_total ?>" min="0" name="t<?= $article->id ?>"></td>
                  
                  <?php $counter++ ?>
                
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
           <table id="example1" class="table table-bordered table-striped">
           <tbody>
           <?php 
               $total=$purchase->total;
               $quantity=0;
                ?>
           <td>Cantidad:<input type="number" id="cant" value="<?= $quantity ?>" name="cantidad" readonly></td>
           <td>Total:<input type="number" id="total" value="<?= $total ?>" name="total" readonly></td>
           </tbody>
           </table>
           <input type="submit" class="btn btn-success"  value="Enviar" onclick="borrar()">
           </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<?php echo $this->Html->script('buy2'); ?>
<?php $this->end(); ?>