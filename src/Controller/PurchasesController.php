<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Purchases Controller
 *
 * @property \App\Model\Table\PurchasesTable $Purchases
 *
 * @method \App\Model\Entity\Purchase[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchasesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $purchases = $this->paginate($this->Purchases->find('all'));

        $this->set(compact('purchases'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchase = $this->Purchases->get($id, [
            'contain' => ['PurchaseDetails']
        ]);
        
        $this->set('purchase', $purchase);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $purchase = $this->Purchases->newEntity();
        if ($this->request->is('post')) {
            $purchase = $this->Purchases->patchEntity($purchase, $this->request->getData());
            if ($this->Purchases->save($purchase)) {
                $this->Flash->success(__('The {0} has been saved.', 'Purchase'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Purchase'));
        }
        $this->set(compact('purchase'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Purchase id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('PurchaseDetails');
        $this->loadModel('Articles');
        $articles = $this->Articles->find();
         $this->paginate = [
            'contain' => ['Categories']
        ];
        $articles = $this->paginate($this->Articles);
        $this->set('articles', $articles);
        date_default_timezone_set('America/Lima');
        $purchase = $this->Purchases->get($id, [
            'contain' => []
        ]);
        $purchase_details=$this->PurchaseDetails->find()->where(['purchase_id'=> $id]);
        $this->set('purchase_details', $purchase_details);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data=$this->request->getData();
            //Editar la venta
            $purchase_data=array(
                    "total" => $data['total'],
                    "date" => date('Y-m-d H:i:s')
        );
            $sale = $this->Purchases->patchEntity($purchase, $purchase_data);
            if ($this->Purchases->save($purchase)) {
                //Edita los detalle venta que ya existian y elimina los que "dejaron de existir"
                //Los edita aun si no editas nada, pero los detalle venta no tienen fecha asi que nadie se da cuenta ¯\_(ツ)_/¯
                //$prev_purdet Es una herramienta secreta que nos ayudara mas tarde
                $prev_purdet=array();
                foreach ($purchase_details as $purdet) {
                    array_push($prev_purdet, $purdet->article_id);
                    //Declara el articulo que va a ser editado
                    $article=$this->Articles->get($purdet->article_id);
                    //Calculo diferencia entre cantidades
                    $old_quant=$purdet->quantity;
                    $new_quant=$data['q'.$purdet->article_id];
                    $dif=$new_quant-$old_quant;
                    //Patch al detalle venta con los nuevos datos 
                    $quantity=$data['q'.$purdet->article_id];
                    $subtotal=$data['t'.$purdet->article_id];

                    if($quantity!=0){

                        $purchase_detail_data=array(
                        "quantity" => $quantity,
                        "total" => $subtotal,
                        );
                        $purdet = $this->Purchases->patchEntity($purdet, $purchase_detail_data);
                        $this->PurchaseDetails->save($purdet);

                    }else{
                        //A volar
                        $this->PurchaseDetails->delete($purdet);
                    }
                    //Cambio de stock
                    $new_stock=$article->stock+$dif;
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
                    if(!(in_array($i, $prev_purdet))){
                        $new_purdet = $this->PurchaseDetails->newEntity();
                        $new_purdet_data=array("id" => null,
                                        "article_id" => $i,
                                        "purchase_id" => $id,
                                        "quantity" => $data['q'.$i],
                                        "total" => $data['t'.$i]
                        );
                        $new_purdet = $this->PurchaseDetails->patchEntity($new_purdet, $new_purdet_data);
                        if($this->PurchaseDetails->save($new_purdet)){
                            $article = $this->Articles->get($i);
                            $new_stock=$article->stock-$new_purdet->quantity;
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
       
        $this->set(compact('purchase'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Purchase id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchase = $this->Purchases->get($id);
        if ($this->Purchases->delete($purchase)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Purchase'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Purchase'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
