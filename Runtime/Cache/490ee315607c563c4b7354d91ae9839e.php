<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><link href="/booksae/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"><link rel="stylesheet" type="text/css" href="/booksae/static/css/style.css" /><script src="/booksae/static/js/jquery-1.10.2.js"></script><script src="/booksae/bootstrap/js/bootstrap.min.js"></script><script type="text/javascript" src="/booksae/static/js/check.js"></script></head><body><div id="header"><div id="logo"><h1>sysu图书管理平台</h1></div><div id="menu"><ul><li><a href="logout">退出</a></li><li><a href="index">返回主页</a></li><?php if($loginname == 'super'): ?><li><a href="addadmin">添加二级管理员账号</a></li><?php endif; ?><li><a href=""><?php echo ($loginname); ?></a></li></ul></div></div><div class="container"><div class="row"><div class="span12"><div class="row"><div class="span1"></div><div class="span10"><div class="page-header"><h4>添加二级管理员帐号</h4></div><?php if($error == 1): ?><div class="alert alert-error"><?php echo ($errormsg); ?></div><?php elseif($success == 1): ?><div class="alert alert-success"><?php echo ($successmsg); ?></div><?php endif; ?><form class="form-horizontal" id="addadmin" method="post" action="addadminop"><div id="un" class="control-group"><label class="control-label">用户名:</label><div class="controls"><input  type="text" class="textset" name="adminname" value="<?php echo ($name); ?>"/><span class="help-inline"></span></div></div><div id="pw1" class="control-group"><label class="control-label">密码：</label><div class="controls"><input type="password" class="textset" name="password"/><span class="help-inline"></span></div></div><div id="pw2" class="control-group"><label class="control-label">确认密码：</label><div class="controls"><input type="password" class="textset" name="repass"/><span class="help-inline"></span></div></div><div class="controls"><button id="summit" class="btn btn-primary">添加</button></div></form></div><div class="span1"></div></div></div></div></div></body></html>