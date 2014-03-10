$(function(){ 
    $("#username").focus();
    document.onkeydown = function(e){ 
	var ev = document.all ? window.event : e; 
		if(ev.keyCode==13) { 
			$("#loginBtn").click();//处理事件 
		}
	}
	$("#loginBtn").click(function(){
	    var user = $("#username").val(); 
	    var pass = $("#password").val();
	    $.ajax({ 
	        type: "POST", 
	        url: "/booksae/index.php/Login/login/", 
	        dataType: "json", 
	        data: {"username":user,"password":pass}, 
	        beforeSend: function(){ 
	            $('#hint').html("正在登录...");
	        },
	        success: function(json){
	        	if(json.suc==2){
	            	window.location.href="/booksae/index.php/Student/index";
	            }
	            else if(json.suc==1){
	            	window.location.href="/booksae/index.php/Admin/index";
	            }
	            else{
	                $('#hint').html(json.message); 
	                return false; 
	            } 
	        },
	        error : function(){
            	$('#hint').html("登录失败");
           }
	    }); 
	});
});