<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Sale;
use Cake\ORM\TableRegistry;
/**
 * Sales Controller
 *
 * @property \App\Model\Table\SalesTable $Sales
 *
 * @method \App\Model\Entity\Sale[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $this->paginate = [
            'contain' => ['Users']
        ];
        $sales = $this->paginate($this->Sales->find('all'));

        $this->set(compact('sales'));
    }
    public function profit()
    {
      $purchase = TableRegistry::getTableLocator()->get('Purchases');
      $purchases = $purchase->find();
      $this->set(compact('purchases'));

        $this->paginate = [
            'contain' => ['Users']
        ];
        $sales = $this->paginate($this->Sales);

        $this->set(compact('sales'));
    }
    /**
     * View method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
        public function view($id = null)
    {
        $sale = $this->Sales->get($id, [
            'contain' => ['Users']
        ]);
        $this->loadModel('SaleDetails');
        $this->loadModel('Articles');
        $saledet= $this->SaleDetails->find()
                ->where(['sales_id' => $id])
                ->contain(['Articles'])
        ;
        $this->set('sale', $sale);
        $this->set('saledet', $saledet);
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('SaleDetails');
        $this->loadModel('Articles');
        $sale = $this->Sales->newEntity();

        if ($this->request->is('post')) {
            $a=$this->request->getData();
            $b=array("id" => null,
                    "users_id" => $this->Auth->User('id'),
                    "total" => $a['total'],
                    "voucher_number" => 10,
                    "date" => null
        );
            $sale = $this->Sales->patchEntity($sale, $b);

            if ($this->Sales->save($sale)) {
                $i=1;
                while(array_key_exists('q'.$i,$a )){
                    if($a['q'.$i]!=0){
                        $saled = $this->SaleDetails->newEntity();
                        $saled_array=array("id" => null,
                                        "articles_id" => $i,
                                        "sales_id" => $sale->id,
                                        "quantity" => $a['q'.$i],
                                        "total" => $a['t'.$i]
                        );
                        $saled = $this->SaleDetails->patchEntity($saled, $saled_array);
                        if($this->SaleDetails->save($saled)){
                            /*$tbl= \Cake\ORM\TableRegistry::get('Articles',array('table' => 'Articles'));
                            $art= $tbl->newEntity();
                            $art->stock=(int)($art->stock)-(int)($a['q'.$i]);
                            */
                            $article= $this->Articles->find()->where(['id' => $i]);
                            foreach ($article as $key) {
                                $articled = $this->Articles->get($key->id, [
                                        'contain' => []
                                    ]);
                                $new_stock=(int)($key->stock)-(int)($a['q'.$i]);
                                $article2=array("id" => $key->id,
                                        "categories_id" => $key->categories_id,
                                        "code" => $key->code,
                                        "name" => $key->name,
                                        "description" => $key->description,
                                        "stock" => $new_stock,
                                        "price" => $key->price,
                                        "referential_price" => $key->referential_price
                                );
                                $articled = $this->Articles->patchEntity($articled, $article2);
                                $this->Articles->save($articled);

                            }
                        }
                    }
                    $i++;
                }
                $this->Flash->success(__('The {0} has been saved.', 'Sale'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Sale'));
        }
        $users = $this->Sales->Users->find('list', ['limit' => 200]);
        $this->set(compact('sale', 'users'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('SaleDetails');
        $this->loadModel('Articles');
        $articles = $this->Articles->find();
         $this->paginate = [
            'contain' => ['Categories']
        ];
        $articles = $this->paginate($this->Articles);
        $this->set('articles', $articles);
        date_default_timezone_set('America/Lima');
        $sale = $this->Sales->get($id, [
            'contain' => []
        ]);
        $sale_details=$this->SaleDetails->find()->where(['sales_id'=> $id]);
        $this->set('sale_details', $sale_details);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data=$this->request->getData();
            //Editar la venta
            $sale_data=array(
                    "users_id" => $this->Auth->User('id'),
                    "total" => $data['total'],
                    "voucher_number" => 10,
                    "date" => date('Y-m-d H:i:s')
        );
            $sale = $this->Sales->patchEntity($sale, $sale_data);
            if ($this->Sales->save($sale)) {
                //Edita los detalle venta que ya existian y elimina los que "dejaron de existir"
                //Los edita aun si no editas nada, pero los detalle venta no tienen fecha asi que nadie se da cuenta ¯\_(ツ)_/¯
                //$prev_saledet Es una herramienta secreta que nos ayudara mas tarde
                $prev_saledet=array();
                foreach ($sale_details as $saledet) {
                    array_push($prev_saledet, $saledet->articles_id);
                    //Declara el articulo que va a ser editado
                    $article=$this->Articles->get($saledet->articles_id);
                    //Calculo diferencia entre cantidades
                    $old_quant=$saledet->quantity;
                    $new_quant=$data['q'.$saledet->articles_id];
                    $dif=$new_quant-$old_quant;
                    //Patch al detalle venta con los nuevos datos 
                    $quantity=$data['q'.$saledet->articles_id];
                    $subtotal=$data['t'.$saledet->articles_id];

                    if($quantity!=0){

                        $sale_detail_data=array(
                        "quantity" => $quantity,
                        "total" => $subtotal,
                        );
                        $saledet = $this->Sales->patchEntity($saledet, $sale_detail_data);
                        $this->SaleDetails->save($saledet);

                    }else{
                        //A volar
                        $this->SaleDetails->delete($saledet);
                    }
                    //Cambio de stock
                    $new_stock=$article->stock-$dif;
                    $edited_article=array(
                    "stock" => $new_stock,
                    );
                    $article=$this->Articles->patchEntity($article, $edited_article);
                    $this->Articles->save($article);
                }

                //Para los nuevos detalles
                $selling=$data['selling'];
                $i=substr($selling, 0,strpos($selling, "-"));
                $selling=substr($selling,strpos($selling, "-")+1,strlen($selling));

                while(array_key_exists('q'.$i,$data )){
                    if(!(in_array($i, $prev_saledet))){
                        $new_saledet = $this->SaleDetails->newEntity();
                        $new_saledet_data=array("id" => null,
                                        "articles_id" => $i,
                                        "sales_id" => $id,
                                        "quantity" => $data['q'.$i],
                                        "total" => $data['t'.$i]
                        );
                        $new_saledet = $this->SaleDetails->patchEntity($new_saledet, $new_saledet_data);
                        if($this->SaleDetails->save($new_saledet)){
                            $article = $this->Articles->get($i);
                            $new_stock=$article->stock-$new_saledet->quantity;
                            $article_data=array(
                                    "stock" => $new_stock
                            );
                            $articled = $this->Articles->patchEntity($article, $article_data);
                            $this->Articles->save($article);
                        }
                    }
                    $i=substr($selling, 0,strpos($selling, "-"));
                    $selling=substr($selling,strpos($selling, "-")+1,strlen($selling));
                }

                $this->Flash->success(__('The {0} has been saved.', 'Sale'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Sale'));
        }
       
        $users = $this->Sales->Users->find('list', ['limit' => 200]);
        $this->set(compact('sale', 'users'));
    }
    


    /**
     * Delete method
     *
     * @param string|null $id Sale id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sale = $this->Sales->get($id);
        if ($this->Sales->delete($sale)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Sale'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Sale'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
