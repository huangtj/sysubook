<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><link href="/booksae/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"><link rel="stylesheet" type="text/css" href="/booksae/static/css/style.css" /><script src="/booksae/static/js/jquery-1.10.2.js"></script><script src="/booksae/bootstrap/js/bootstrap.min.js"></script></head><body><div id="header"><div id="logo"><h1>sysu图书管理平台</h1></div><div id="menu"><ul><li><a href="logout">退出</a></li><li><a href="index">返回主页</a></li><?php if($loginname == 'super'): ?><li><a href="addadmin">添加二级管理员账号</a></li><?php endif; ?><li><a href=""><?php echo ($loginname); ?></a></li></ul></div></div><div class="container"><div class="row"><div class="span12"><div class="span2"></div><div class="span9"><fieldset><legend>还书</legend><p>&nbsp;</p><?php if($error == 1): ?><div class="alert alert-error"><?php echo ($errormsg); ?></div><?php elseif($success == 1): ?><div class="alert alert-success"><?php echo ($successmsg); ?></div><?php endif; ?><form class="form-horizontal" method="post" action="returnop"><div class="control-group"><label class="control-label">学生学号：</label><div class="controls"><input id="stunum" type="text" name="stunum" placeholder="输入学号" value="<?php echo ($sid); ?>"/></div></div><div class="control-group"><label class="control-label">书号/光盘号：</label><div class="controls"><input type="text" placeholder="输入书号或光盘号" id="itemid" name="itemid" value="<?php echo ($iid); ?>"></div></div><div class="control-group"><div class="controls"><button id= "confirm" class="btn btn-primary">确认</button></div></div></form></fieldset><script>                     $('#confirm').click(function(){
                            $('#query').submit();
                    });
          </script></div></div></div></div></body>