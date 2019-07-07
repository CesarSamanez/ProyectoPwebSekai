<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PurchaseDetails Controller
 *
 * @property \App\Model\Table\PurchaseDetailsTable $PurchaseDetails
 *
 * @method \App\Model\Entity\PurchaseDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Articles', 'Purchases']
        ];
        $purchaseDetails = $this->paginate($this->PurchaseDetails->find('all'));

        $this->set(compact('purchaseDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Detail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchaseDetail = $this->PurchaseDetails->get($id, [
            'contain' => ['Articles', 'Purchases']
        ]);

        $this->set('purchaseDetail', $purchaseDetail);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $purchaseDetail = $this->PurchaseDetails->newEntity();
        if ($this->request->is('post')) {
            $purchaseDetail = $this->PurchaseDetails->patchEntity($purchaseDetail, $this->request->getData());
            if ($this->PurchaseDetails->save($purchaseDetail)) {
                $this->Flash->success(__('The {0} has been saved.', 'Purchase Detail'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Purchase Detail'));
        }
        $articles = $this->PurchaseDetails->Articles->find('list', ['limit' => 200]);
        $purchases = $this->PurchaseDetails->Purchases->find('list', ['limit' => 200]);
        $this->set(compact('purchaseDetail', 'articles', 'purchases'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Purchase Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchaseDetail = $this->PurchaseDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseDetail = $this->PurchaseDetails->patchEntity($purchaseDetail, $this->request->getData());
            if ($this->PurchaseDetails->save($purchaseDetail)) {
                $this->Flash->success(__('The {0} has been saved.', 'Purchase Detail'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Purchase Detail'));
        }
        $articles = $this->PurchaseDetails->Articles->find('list', ['limit' => 200]);
        $purchases = $this->PurchaseDetails->Purchases->find('list', ['limit' => 200]);
        $this->set(compact('purchaseDetail', 'articles', 'purchases'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Purchase Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseDetail = $this->PurchaseDetails->get($id);
        if ($this->PurchaseDetails->delete($purchaseDetail)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Purchase Detail'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Purchase Detail'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
