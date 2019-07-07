<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 *
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories']
        ];
        $articles = $this->paginate($this->Articles->find('all'));

        $this->set(compact('articles'));
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => ['Categories']
        ]);

        $this->set('article', $article);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The {0} has been saved.', 'Article'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Article'));
        }
        $categories = $this->Articles->Categories->find('list', ['limit' => 200]);
        $this->set(compact('article', 'categories'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The {0} has been saved.', 'Article'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Article'));
        }
        $categories = $this->Articles->Categories->find('list', ['limit' => 200]);
        $this->set(compact('article', 'categories'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Article'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Article'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function isAuthorized($user)
    {
         if (isset($user['function']) and $user['function']===0)
        {
            if(in_array($this->request->action, ['view','index'])){
                return true;
            }
        }
        return parent::isAuthorized($user);
    }
    public function sell()
    {
        if ($this->request->is('post')) {
            
            $data = $this->request->getData();
            if($data[total]>0){
                //purtable=saltable
                //pur=sal
                $salTable = \Cake\ORM\TableRegistry::get('Sales', array('table' => 'Sales'));
                $sal = $salTable->newEntity();
                $sal->total = (float)$data[total];
                $data[total]=0;
                $sal->users_id = $this->Auth->User('id');
                $sal->voucher_number = 10;
                $salTable->save($sal);
                $articles = $this->paginate($this->Articles);
                foreach ($articles as $article) {
                    $varC = "q".$article->id;
                    $varS = "t".$article->id;
                    if($data[$varC]>0){
                    $poTable = \Cake\ORM\TableRegistry::get('SaleDetails', array('table' => 'SaleDetails'));
                    $po = $poTable->newEntity();
                    $po->articles_id = $article->id;
                    $po->sales_id = $sal->id;
                    $po->quantity = $data[$varC];
                    
                    $article->stock = (int)$article->stock-(int)$data[$varC];
                    $this->Articles->save($article);

                    $po->total = $data[$varS];
                    $poTable->save($po);  
                    }
                }             
            return $this->redirect(['controller'=>'Sales','action' => 'index']);   
            }
        }
        $this->paginate = [
            'contain' => ['Categories']
        ];
        $articles = $this->paginate($this->Articles->find('all'));

        $this->set(compact('articles'));
    }
    public function buy()
    {
        if ($this->request->is('post')) {
            
            $data = $this->request->getData();
            if($data[total]>0){
                $purTable = \Cake\ORM\TableRegistry::get('Purchases', array('table' => 'Purchases'));
                $pur = $purTable->newEntity();
                $pur->total = (float)$data[total];
                $data[total]=0;
                $pur->users_id = $this->Auth->User('id');
                $purTable->save($pur);
                $articles = $this->paginate($this->Articles);
                foreach ($articles as $article) {
                    $varC = "q".$article->id;
                    $varS = "t".$article->id;
                    if($data[$varC]>0){
                    $poTable = \Cake\ORM\TableRegistry::get('PurchaseDetails', array('table' => 'PurchaseDetails'));
                    $po = $poTable->newEntity();
                    $po->article_id = $article->id;
                    $po->purchase_id = $pur->id;
                    $po->quantity = $data[$varC];
                    
                    $article->stock = (int)$article->stock+(int)$data[$varC];
                    $this->Articles->save($article);

                    $po->total = $data[$varS];

                    $poTable->save($po);  
                    }
                }             
            return $this->redirect(['controller'=>'Purchases','action' => 'index']);   
            }
        }
        $this->paginate = [
            'contain' => ['Categories']
        ];
        $articles = $this->paginate($this->Articles->find('all'));

        $this->set(compact('articles'));
    }
}
