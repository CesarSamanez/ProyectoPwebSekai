<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Purchase Controller
 *
 * @property \App\Model\Table\PurchaseTable $Purchase
 *
 * @method \App\Model\Entity\Purchase[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Articles']
        ];
        $purchase = $this->paginate($this->Purchase);

        $this->set(compact('purchase'));
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
        $purchase = $this->Purchase->get($id, [
            'contain' => ['Articles']
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
        $purchase = $this->Purchase->newEntity();
        if ($this->request->is('post')) {
            $purchase = $this->Purchase->patchEntity($purchase, $this->request->getData());
            if ($this->Purchase->save($purchase)) {
                $this->Flash->success(__('The {0} has been saved.', 'Purchase'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Purchase'));
        }
        $articles = $this->Purchase->Articles->find('list', ['limit' => 200]);
        $this->set(compact('purchase', 'articles'));
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
        $purchase = $this->Purchase->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchase = $this->Purchase->patchEntity($purchase, $this->request->getData());
            if ($this->Purchase->save($purchase)) {
                $this->Flash->success(__('The {0} has been saved.', 'Purchase'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Purchase'));
        }
        $articles = $this->Purchase->Articles->find('list', ['limit' => 200]);
        $this->set(compact('purchase', 'articles'));
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
        $purchase = $this->Purchase->get($id);
        if ($this->Purchase->delete($purchase)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Purchase'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Purchase'));
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
}
