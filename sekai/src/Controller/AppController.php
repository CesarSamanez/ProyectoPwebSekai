<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\I18n;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        $this->loadComponent('Flash');
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Auth', [
            'authorize'=>'Controller',

            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);
    }
    public function beforeRender(Event $event)
{
    $this->viewBuilder()->setTheme('AdminLTE');


}
    public function beforeFilter(Event $event)
    {
        $this->set('current_user', $this->Auth->user());
        $this->Auth->allow(['display','login','changeLanguage']);
        if($this->request->session()->check('Config.language')){
          I18n::setLocale($this->request->session()->read('Config.language'));
        }else{
          $this->request->session()->write('Config.language',I18n::locale());
        }

    }
    public function changeLanguage($language=null){
      if($language!=null && in_array($language,['en_US','fr_FR','es','pt_BR'])){

        $this->request->session()->write('Config.language',$language);
          return $this->redirect($this->referer());
      }else{
          $this->request->session()->write('Config.language',I18n::locale());
          return $this->redirect($this->referer());

        }
  }
    public function isAuthorized($user)
    {
        if (isset($user['function']) and $user['function']===1)
        {
            return true;
        }
        return false;
    }
}
