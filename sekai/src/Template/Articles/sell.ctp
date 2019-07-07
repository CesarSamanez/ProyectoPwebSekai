<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Venta de Articulos
  </h1>
</section>

<!-- Main content -->
<?php
echo $this->Form->create(null, [
    'url' => [
        'controller' => 'Sales',
        'action' => 'add'
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
 
 
        <div class="box-body table-responsive no-padding">
           <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                  <th scope="col"><?= $this->Paginator->sort('id') ?></th>
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
            <!-- <input type="checkbox" id="showSelling" value="0" onchange="show(this)"> Vendiendo -->
            <input id="selling" name="selling" readonly>
              <?php foreach ($articles as $article): ?>
                <tr id="tr<?= h($article->id) ?>">
                  <td><?= h($article->id) ?></td>
                  <td><?= h($article->name) ?></td>
                  <td id="s<?= $article->id ?>"><?= $this->Number->format($article->stock) ?></td>
                  <td><?= $this->Number->format($article->price) ?></td>
                  <td><?= $this->Number->format($article->referential_price) ?></td>
                  
                  <td><input onchange="update(this, <?= $article->referential_price ?>)" type="number" id="q<?= $article->id ?>" value="0" min="0" max="<?= ($article->stock) ?>" name="q<?= $article->id ?>"></td>
                  <td><input onchange="type="number" id="t<?= $article->id ?>" value="0" min="0" name="t<?= $article->id ?>"></td>
                  
                  <?php $counter++ ?>
                
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
           <table id="example1" class="table table-bordered table-striped">
           <tbody>
           <td>Cantidad:<input type="number" id="cant" value="0" name="cantidad" readonly></td>
           <td>Total:<input type="number" id="total" value="0" name="total" readonly></td>
           </tbody>
           </table>
           <input type="submit" class="btn btn-success" value="Enviar" onclick="hola()">
           </form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<script>
function update(e, pri){
    var pepe=e.id.substring(1,e.id.length);
    
    var stock=parseInt(document.getElementById("s"+pepe).innerHTML);
    var sub_quant=document.getElementById("q"+pepe);
    if(sub_quant.value>stock ){
      sub_quant.value=stock;
    }
    if(sub_quant.value<0){
      sub_quant.value=0;
    }
    var beforeT=parseInt(document.getElementById("t"+pepe).value);
    document.getElementById("t"+pepe).value=pri*sub_quant.value;
    var total=parseInt(document.getElementById("total").value);
    var cant=document.getElementById("cant");
    var lastT=parseInt(document.getElementById("t"+pepe).value);
    document.getElementById("total").value=total+(lastT-beforeT);
    var i=1;
    var pepe2=1;
    var lucho=beforeT/pri;
    var lucho2=sub_quant.value;
    var lucho3=lucho2-lucho;

    var selling=document.getElementById("selling");
    if(selling.value.indexOf(pepe)==-1 && sub_quant.value!=0){
      selling.value+=pepe+"-";
    }else if(selling.value.indexOf(pepe)!=-1 && sub_quant.value==0){
      console.log(pepe);
      console.log(pepe.length);
      sv=selling.value;
      selling.value=sv.substring(0,sv.indexOf(pepe))+sv.substring(sv.indexOf(pepe)+pepe.length+1,sv.length);
    }

    cant.value=parseInt(cant.value)+parseInt(lucho3);
    
}
function hola(){
var i=0;
var elem=document.getElementById("f");
console.log(elem);
var quant=document.getElementById("q"+i).value;
elem.submit();
}
function show(check){
if(check.value==0){
  check.value=1;
}else{
  check.value=0;
}
var selling=document.getElementById("selling");
var sellingValue=selling.value;
  if(check.value==1){
    if(selling.value==""){
      console.log("nel");
    }else{
    sv=selling.value;
      console.log(sv);
    }
  }
  
}
</script> 


<?php $this->end(); ?>
