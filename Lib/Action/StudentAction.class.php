<?php

class StudentAction extends Action {
    public function index(){
    	$this->assign('student',$_SESSION['student']);
		$s_id=$_SESSION['student'];
		
		$record=M('sturecord');
		$rlist=$record->join('think_item ON think_sturecord.item_id=think_item.id')->where("stu_id='$s_id'")->order('date desc')->select();
		$this->assign('rlist',$rlist);
		
		$Model = new Model();// 实例化一个model对象 没有对应任何数据表
		$olist=$Model->query("select * from think_orderlist natural join think_item where think_orderlist.item_id=think_item.id");
		$this->assign('olist',$olist);
		
    	$this->display();
    }
    public function logout(){
    	unset($_SESSION['student']);
		session_destroy();
	    $this->redirect('Index/index');
    }
	public function setting(){
		$this->assign('student',$_SESSION['student']);
		$this->display();
	}
	public function chgPwd(){
		$pw1=$_POST['password'];
		$pw2=$_POST['repass'];
		if($pw1!=$pw2){
			$result="两次输入的密码不一致";
			$this->assign('result',$result);
    		$this->redirect('setting');
		}
		else{
			$student=M('student');
			$s_id=$_SESSION['student'];
			$student->where("id=$s_id")->setField('password',MD5($pw1));
			$result="修改成功";
			$this->assign('result',$result);
    		$this->display('setting');
		}
	}
	public function search(){
		$this->assign('student',$_SESSION['student']);
		$item=trim($_GET['itemname']);
		$this->assign('item',$_GET['itemname']);
		
		$Model = M('book');
		$map['title']  = array('like',$item);
		$book=$Model->join("think_item on think_item.id=think_book.id")->where($map)->select();
		//$book_num=$book->count();
		$this->assign('book',$book);
		echo $Model->getLastSql();
		$Model = M('disc');
		$disc=$Model->join("think_item on think_item.id=think_disc.disc_id")->where($map)->select();
		//$disc_num=$disc->count();
		$this->assign('disc',$disc);
		$num=$disc_num+$book_num;
		$this->assign('num',$num);
		
	}
	public function stuLibrary(){
		$this->assign('student',$_SESSION['student']);
		$Model = new Model();// 实例化一个model对象 没有对应任何数据表
		$book=$Model->query("select * from think_item natural join think_book");
		$this->assign('book',$book);
		$disc=$Model->query("select * from think_item natural join think_disc where think_item.id=think_disc.disc_id");
		$this->assign('disc',$disc);
		
		$this->display();
	} 
	public function email(){
		$this->assign('student',$_SESSION['student']);
		$id=$_GET['id'];
		$this->assign('id',$id);
		$this->display();
	}
	public function preorder(){
		$id=$_POST['id'];
		
		$order = M('orderlist'); // 实例化User对象
		$data['stu_id']=$_SESSION['student'];
		$data['item_id'] = str_replace("'","",$id);//！tp自动为单引号转义，必须去掉原来$id中的单引号
		$data['email'] = $_POST['email'];
		$data['date']=date("Y-m-d");
		if($sql=$order->add($data)){
				
			$item = M('item');// 实例化一个model对象 没有对应任何数据表
			$item->where("id=$id")->setField('preorder',1);
			echo "<script>alert('suc');</script>";
			$this->redirect('stuLibrary');
		}
		else{
			echo "<script>alert('suc');</script>";
			$this->redirect('stuLibrary');
		}
	}
}
?>