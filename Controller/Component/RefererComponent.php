<?php
/**
 * Copyright 2007-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2007-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Utils Plugin
 *
 * Utils Referer Component
 *
 * @package utils
 * @subpackage utils.controllers.components
 */
class RefererComponent extends Component {

/**
 * Controller object instance
 *
 * @var array actions
 */
	public $Controller;

/**
 * Intialize Callback
 *
 * @param object Controller object
 */
	public function initialize($controller) {
		$this->Controller = $controller;
	} 

/**
 * Startup Callback
 *
 * @param object Controller object
 */
	public function startup($controller) {
		$this->setReferer();
	}

/**
 * Store referer data in view $referer variable
 *
 * @param string $default
 */
	public function setReferer($default = null) {
		if (empty($this->Controller->data['Data']['referer'])) {
			$referer = $this->Controller->referer();

			if ($referer == '/' && !empty($default)) {
				$referer = $default;

				if (is_array($referer)) {
					$referer = Router::url($referer);
				}
			}
		} else {
			$referer = $this->Controller->data['Data']['referer'];
		}
		$this->Controller->set(compact('referer'));
	}

/**
 * Redirect to url stored in Data.referer or default $url
 *
 * @param mixed the url to redirect to
 * @param integer http status code, default is null
 * @param boolean calling php exit or not after redirect, default is true
 * @return mixed
 */
	public function redirect($url, $status = null, $exit = true) {
		if (isset($this->Controller->data['Data']['referer'])) {
			$referer = $this->Controller->data['Data']['referer'];
		} else {
			$referer = $this->Controller->referer();
		}

		if (strlen($referer) == 0 || $referer == '/') {
			$this->Controller->redirect($url, $status, $exit);
		} else {
			$this->Controller->redirect($referer, $status, $exit);
		}
	}
}
