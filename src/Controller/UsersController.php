<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout','register']);
        $this->loadComponent('CakeCaptcha.Captcha', [
      'captchaConfig' => 'ExampleCaptcha'
    ]);
    }
    public function index()
    {
        $users = $this->paginate($this->Users->find('all'));

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
          $isHuman = captcha_validate($this->request->data['CaptchaCode']);
          unset($this->request->data['CaptchaCode']);
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ( $isHuman && $this->Users->save($user) ) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }
    public function Register()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {

            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }
    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['forgot','logout']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
          $isHuman = captcha_validate($this->request->data['CaptchaCode']);

 // clear previous user input, since each Captcha code can only be validated once
          unset($this->request->data['CaptchaCode']);
            $user = $this->Auth->identify();
            if ($user && $isHuman) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function forgot(){
        if($this->request->is('post')){

        $email = new Email();
        $email->transport('mailjet');

        try {
            $res = $email->from('sekai.ent123@gmail.com')
                  ->to($this->request->data['email'])
                  ->subject('Contact')
                  ->send('Se recibió tu peticion, alguien te contactará hasta en 24 horas. Gracias. SekaiEntertainment');

        } catch (Exception $e) {

            echo 'Exception : ',  $e->getMessage(), "\n";

        }
    }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
    public function isAuthorized($user)
    {
        if (isset($user['function']) and $user['function']===0)
        {
            if(in_array($this->request->action, ['home','logout','view','index'])){
                return true;
            }
        }
        return parent::isAuthorized($user);
    }
    public function getID()
    {

      $uid = $this->Auth->User('id');

      $this->redirect(array("controller" => "Users",
                          "action" => "view",
                          $uid));
    }public function editID()
    {

      $uid = $this->Auth->User('id');

      $this->redirect(array("controller" => "Users",
                          "action" => "edit",
                          $uid));
    }
}
