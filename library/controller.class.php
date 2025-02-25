<?php
// #[\AllowDynamicProperties]
class Controller {
    protected $_controller;
	protected $_action;
	protected $_template;


	public $doNotRenderHeader;
	public $render;

    public function __construct($controller, $action) {
        $this->_controller = ucfirst($controller);
        $this->_action = $action;


		$model = $this->_controller;
		$this->$model = new $model;

        $this->_template = new Template($controller, $action);

        $this->doNotRenderHeader = 0;
        $this->render = 1;

        $this->startMessages();
    }

    function setMessages($msg) {
		array_push($_SESSION['messages'], $msg);
	}

    function startMessages() {
		session_start();
		if(!isset($_SESSION['messages'])) {
			$_SESSION['messages'] = array();
		}
		if(!isset($_SESSION['redirect'])) {
			$_SESSION['redirect'] = 0;
		}
	}
	function checkSession() {
        if (!isset($_SESSION['user_id']) || $_SESSION['expires_at'] < time()) {
            session_destroy();
            header("Location: /login");
            exit();
        } else {
            $_SESSION['expires_at'] = time() + 3600; 
        }
    }

    function set($name,$value) {
		$this->_template->set($name,$value);
	}



    function __destruct() {
		if($_SESSION['redirect'] == 0) {
			if($this->render) {
				$this->_template->render($this->doNotRenderHeader);
			}
		} else {
			$_SESSION['redirect'] = 0;
 		}
	}
}

?>