<?php
namespace App\Controller;
use App\Model\Entity\Sale;
use App\Controller\AppController;

/**
 * SaleDetails Controller
 *
 * @property \App\Model\Table\SaleDetailsTable $SaleDetails
 *
 * @method \App\Model\Entity\SaleDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SaleDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Articles', 'Sales']
        ];
        $saleDetails = $this->paginate($this->SaleDetails->find('all'));

        $this->set(compact('saleDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Sale Detail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $saleDetail = $this->SaleDetails->get($id, [
            'contain' => ['Articles', 'Sales']
        ]);

        $this->set('saleDetail', $saleDetail);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $saleDetail = $this->SaleDetails->newEntity();
        if ($this->request->is('post')) {
            $saleDetail = $this->SaleDetails->patchEntity($saleDetail, $this->request->getData());
            if ($this->SaleDetails->save($saleDetail)) {
                $this->Flash->success(__('The {0} has been saved.', 'Sale Detail'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Sale Detail'));
        }
        $articles = $this->SaleDetails->Articles->find('list', ['limit' => 200]);
        $sales = $this->SaleDetails->Sales->find('list', ['limit' => 200]);
        $this->set(compact('saleDetail', 'articles', 'sales'));
    }

    
    /**
     * Edit method
     *
     * @param string|null $id Sale Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $saleDetail = $this->SaleDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $saleDetail = $this->SaleDetails->patchEntity($saleDetail, $this->request->getData());
            if ($this->SaleDetails->save($saleDetail)) {
                $this->Flash->success(__('The {0} has been saved.', 'Sale Detail'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The {0} could not be saved. Please, try again.', 'Sale Detail'));
        }
        $articles = $this->SaleDetails->Articles->find('list', ['limit' => 200]);
        $sales = $this->SaleDetails->Sales->find('list', ['limit' => 200]);
        $this->set(compact('saleDetail', 'articles', 'sales'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Sale Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $saleDetail = $this->SaleDetails->get($id);
        if ($this->SaleDetails->delete($saleDetail)) {
            $this->Flash->success(__('The {0} has been deleted.', 'Sale Detail'));
        } else {
            $this->Flash->error(__('The {0} could not be deleted. Please, try again.', 'Sale Detail'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
