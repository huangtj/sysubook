<?php

class AdminAction extends Action {
    public function index(){
    	session_start();
		if(!isset($_SESSION['admin']))
		        $this->redirect('Index/index');
		$loginname = $_SESSION['admin'];
		$this->assign('loginname',$loginname);
    	$this->display();
    }
	public function logout(){
		if(!isset($_SESSION['admin']))
		        $this->redirect('Index/index');
    	unset($_SESSION['admin']);
		session_destroy();
	    $this->redirect('Index/index');
    }
	public function borrow(){
    	if(!isset($_SESSION['admin']))
			$this->redirect('Index/index');
    	$loginname = $_SESSION['admin'];
		$this->assign('loginname',$loginname);
		$this->display();
    }
    public function borrowop(){
    	if(!isset($_SESSION['admin']))
		        $this->redirect('Index/index');
    	$loginname = $_SESSION['admin'];
		$this->assign('loginname',$loginname);
		//插入借书记录并返回该学生所有借书记录
		//如果学生或书号不存在或书本已被借出，提示错误
		$sid=trim($_POST['stunum']);
		if($sid=="")
		{
			$errormsg="请输入学号";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('borrow');
			return;
		}
		$this->assign('sid',$sid);
		$iid=trim($_POST['itemid']);
		if($iid=="")
		{
			$errormsg="请输入书号/光盘号";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('borrow');
			return;
		}
		$this->assign('iid',$iid);

		$Model=M('student');
		$s=$Model->where("id='$sid'")->select();
		if(!$s)
		{
			$errormsg="没有这个学生！";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('borrow');
			return;
		}

		$Model=M('item');
		$item=$Model->where("id='$iid'")->select();
		if(!$item){
			$errormsg="找不到这本书/CD，请检查是否输入错误！";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('borrow');
			return;
		}
		//书本被人预订？
		$pre=$Model->where("id='$iid'")->getField('preorder');
		if($pre){
			$errormsg="书本已被预订，请到预订页面处理";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('borrow');
			return;
		}
		//书本已借出
		$ava=$Model->where("id='$iid'")->getField('avail');
		if(!$ava){
			$errormsg="书本已借出！请检查是否输入错误";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('borrow');
			return;
		}
		

		//借书
		$Model=M('sturecord');
		$data['stu_id']=$sid;
		$data['item_id']=$iid;
		$data['date']=$_POST['time'];
		if($Model->add($data)){
			$Model=M('item');
			$Model->where("id='$iid'")->setField('avail',0);
			$successmsg="借书成功！";
			$this->assign('success',1);
			$this->assign('successmsg',$successmsg);
			$this->display('borrow');
		}
		else{
			$errormsg="借书失败，请重新操作";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('borrow');
		}
    }

	public function returnbook(){
		if(!isset($_SESSION['admin']))
			$this->redirect('Index/index');
    	$loginname = $_SESSION['admin'];
		$this->assign('loginname',$loginname);
		$this->display();
	}
	public function returnop(){
		if(!isset($_SESSION['admin']))
		    $this->redirect('Index/index');
    	$loginname = $_SESSION['admin'];
		$this->assign('loginname',$loginname);
		//如果学生或书号不存在或书本已被借出，提示错误
		$sid=trim($_POST['stunum']);
		if($sid=="")
		{
			$errormsg="请输入学号";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('returnbook');
			return;
		}
		$this->assign('sid',$sid);
		$iid=trim($_POST['itemid']);
		if($iid=="")
		{
			$errormsg="请输入书号/光盘号";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('returnbook');
			return;
		}
		$this->assign('iid',$iid);

		$Model=M('student');
		$s=$Model->where("id='$sid'")->select();
		if(!$s)
		{
			$errormsg="没有这个学生！";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('returnbook');
			return;
		}

		$Model=M('item');
		$item=$Model->where("id='$iid'")->select();
		if(!$item){
			$errormsg="找不到这本书/CD，请检查是否输入错误！";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('returnbook');
			return;
		}
		
		//还书
		$Model=M('sturecord');
		$res=$Model->where("item_id='$iid' and stu_id='$sid'")->delete();
		if($res!=false&&$res!=0){
			$Model=M('item');
			$Model->where("id='$iid'")->setField('avail',1);
			$successmsg="还书成功！";
			$this->assign('success',1);
			$this->assign('successmsg',$successmsg);
			$this->display('returnbook');
		}
		else{
			$errormsg="没有这条借书记录，请检查是否输入错误";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('returnbook');
		}
	}
	public function preorder(){
		if(!isset($_SESSION['admin']))
			$this->redirect('Index/index');
    	$loginname = $_SESSION['admin'];
		$this->assign('loginname',$loginname);

		if(isset($_GET['s_id']) && isset($_GET['item_id'])){
			$s_id=str_replace("'","",$_GET['s_id']);
			$i_id=str_replace("'","",$_GET['item_id']);
			$Model=M('orderlist');
			//删除预订记录并把物品的preorder置为0
			if($Model->where("item_id='$i_id' and stu_id='$s_id'")->delete()){
				$Model=M('item');
				$Model->where("id='$i_id'")->setField('preorder',0);
				$successmsg="处理成功";
				$this->assign('success',1);
				$this->assign('successmsg',$successmsg);
			}
			else{
				$errormsg="处理失败，请重新尝试";
				$this->assign('error',1);
				$this->assign('errormsg',$errormsg);
			}
		}

		$Model = M('orderlist');// 实例化一个model对象 没有对应任何数据表
		$order=$Model->join("think_item on think_item.id=think_orderlist.item_id")
		->join("think_student on think_orderlist.stu_id=think_student.id")->order('date')->select();
		$this->assign('order',$order);
		$this->display();
	}
	public function preorderop(){
		
	}

	public function addadmin(){
		if(!isset($_SESSION['admin']))
			$this->redirect('Index/index');
    	$loginname = $_SESSION['admin'];
		$this->assign('loginname',$loginname);
		$this->display();
	}
	public function addadminop(){
		if(!isset($_SESSION['admin']))
			$this->redirect('Index/index');
    	$loginname = $_SESSION['admin'];
		$this->assign('loginname',$loginname);
		//添加管理员
		$Model=M('admin');
		$name=$_POST['adminname'];
		$test=$Model->where("name='$name'")->select();
		if($test){
			$errormsg="该用户名已存在";
			$this->assign('name',$name);
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
		}
		else{
			$data['name']=$name;
			$data['password']=MD5($_POST['password']);
			if($Model->add($data)){
				$successmsg="添加成功！";
				$this->assign('success',1);
				$this->assign('successmsg',$successmsg);
			}
			else{
				$errormsg="添加失败，请重试";
				$this->assign('error',1);
				$this->assign('errormsg',$errormsg);
			}
		}
		$this->display('addadmin');
	}
	public function checkLibrary(){
		$Model=new Model();
		$book=$Model->query("select * from think_item natural join think_book");
		$this->assign('book',$book);
		$disc=$Model->query("select * from think_item natural join think_disc where think_item.id=think_disc.disc_id");
		$this->assign('disc',$disc);
		$this->display();
	}
	public function addcdop(){
		$data['id']=$_POST['inputcdnum'];
		$id=$data['id'];
		$this->assign('id',$id);
		$data['title']=$_POST['inputcdname'];
		$title=$data['title'];
		$book_id=$_POST['inputbooknum'];
		$this->assign('title',$title);
		$this->assign('book_id',$book_id);
		$data['avail']=1;
		$data['preorder']=0;
		$Model=M('item');
		if($Model->where("id='$id'")->select())
		{
			$errormsg="具有该编号的cd已存在";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
		}
		else if($Model->add($data)){
			$d=M('disc');
			$data2['disc_id']=$id;
			$data2['book_id']=$book_id;
			if($d->add($data2)){
				$successmsg="添加成功！";
				$this->assign('success',1);
				$this->assign('successmsg',$successmsg);
			}
			else{
				$errormsg="添加失败，请重试";
				$this->assign('error',1);
				$this->assign('errormsg',$errormsg);
				$Model->where("id='$id'")->delete();
			}
		}
		else{
			$errormsg="添加失败，请重试";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
		}
		$this->display('addcd');
	}
	public function addbookop(){
		$id=$_POST['inputbooknum'];
		$title=$_POST['inputbookname'];
		$check=intval($_POST['checkbox_value']);
		$this->assign('id',$id);
		$this->assign('title',$title);
		$this->assign('check',$check);
		
		$data['id']=$id;
		$data['title']=$title;
		$data['avail']=1;
		$data['preorder']=0;
		$Model=M('item');
		if($Model->where("id='$id'")->select())
		{
			$errormsg="具有该书号的书本已存在";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
			$this->display('addbook');
			return;
		}
		if($Model->add($data)){
			$d=M('book');
			$data2['id']=$id;
			if($check)
				$data2['disc']=1;
			else
				$data2['disc']=0;
			if($d->add($data2)){
				$successmsg="添加成功！";
				if($check){$successmsg.="<a href='addcd'>请前往添加配套光盘</a>";}
				$this->assign('success',1);
				$this->assign('successmsg',$successmsg);
			}
			else{
				$errormsg="添加失败，请重试";
				$this->assign('error',1);
				$this->assign('errormsg',$errormsg);
				$Model->where("id='$id'")->delete();
			}
		}
		else{
			$errormsg="添加失败，请重试";
			$this->assign('error',1);
			$this->assign('errormsg',$errormsg);
		}
		$this->display('addbook');
	}
	
}
?>