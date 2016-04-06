<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	
	/**
    * set an alias for the newly created helper: Html<->MyHtml
    *
    */
    public $helpers = array('Html' => array('className' => 'MyHtml'));

    /**
    * beforeFilter
    * 
    */
    public function beforeFilter() {
    	if (!isset($this->params['language']) && $this->Session->check('Config.language')) {
            Configure::write('Config.language', $this->Session->read('Config.language'));            
        }elseif(isset($this->params['language']) && 
                ($this->params['language'] !=  $this->Session->read('Config.language'))) {                               
            $this->Session->write('Config.language', $this->params['language']);
            Configure::write('Config.language', $this->params['language']);
        }
    }
    
    /**
    * redirect
    *
    */
    public function redirect( $url, $status = NULL, $exit = true ) {
        if (!isset($url['language']) && $this->Session->check('Config.language')) {
            $url['language'] = $this->Session->read('Config.language');
        }
        parent::redirect($url,$status,$exit);
    }
}
