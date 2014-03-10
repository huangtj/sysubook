<?php

class AdminAction extends Action {
    public function index(){
    	$this->display();
    }
	public function logout(){
    	unset($_SESSION['admin']);
		session_destroy();
	    $this->redirect('Index/index');
    }
}
?>