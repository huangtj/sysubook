<?php
class LoginAction extends Action {
    public function login(){
    	if($ajax || $this->isAjax()){
    		$name = $_POST['username']; 
		    $pass = $_POST['password'];
		    $pwd = md5($pass); //密码使用md5加密 
		    //操作
		    $User=M('admin');
		    $result=$User->where("name='$name' AND password='$pwd'")->find();
		    if($result!=NULL||$result!=false){
		        $_SESSION['admin']=$name;
		        $arr['suc'] = 1; 
		    }
		    else
		    {
		        $User=M('student');
			    $result=$User->where("id='$name' AND password='$pwd'")->find();
			    if($result!=NULL||$result!=false){
			        $_SESSION['student']=$name;
			        $arr['suc'] = 2; 
			    }
		         else
		         {
		         	$arr['suc'] = 0;
		         	$arr['message']="用户名或密码错误";
		         }
		    }
	    	$this->ajaxReturn($arr,'JSON');
	    }
    }
}
?>