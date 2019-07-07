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
        $sale = $this->Sales->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sale = $this->Sales->patchEntity($sale, $this->request->getData());
            if ($this->Sales->save($sale)) {
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
