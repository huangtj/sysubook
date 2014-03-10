function isalnum(str){
        var reg=/^[0-9a-zA-Z]{6,20}$/;
        return reg.test(str);
}
function validname(str){
    var reg=/^[A-Za-z0-9_]{4,20}$/;
    return reg.test(str);
}

$(function(){
                //验证用户名
                var ok1 = false;
                $('input[name="adminname"]').focus(function(){
                    if(!validname($(this).val())||$(this).val().length < 4 || $(this).val().length >20 || $(this).val()==''){
					   $(this).next().text('用户名应在4-20位之间,只包含数字、字母与下划线');
                        $('#un').removeClass('control-group').addClass('control-group error');
                    }
				}).blur(function(){
					if(validname($(this).val())&&$(this).val().length >= 4 && $(this).val().length <=20 && $(this).val()!=''){
						$(this).next().text('');
						ok1=true;
                        $('#un').removeClass('control-group error').addClass('control-group');
					}else{
						$(this).next().text('用户名应在4-20位之间,只包含数字、字母与下划线');
                        $('#un').removeClass('control-group').addClass('control-group error');
					}
					
				});
				var ok2=false;
				var ok3=false;
				//验证密码
				$('input[name="password"]').focus(function(){
                    if(!isalnum($(this).val())||$(this).val().length < 6 || $(this).val().length >20 || $(this).val()==''){
					   $(this).next().text('密码应在6-20位之间,只包含数字与字母');
                        $('#pw1').removeClass('control-group').addClass('control-group error');
                    }
				}).blur(function(){
					if(isalnum($(this).val())&&$(this).val().length >= 6 && $(this).val().length <=20 && $(this).val()!=''){
						$(this).next().text('');
						ok2=true;
                        $('#pw1').removeClass('control-group error').addClass('control-group');
					}else{
						$(this).next().text('密码应在6-20位之间,只包含数字与字母');
                        $('#pw1').removeClass('control-group').addClass('control-group error');
					}
					
				});

				//验证确认密码
					$('input[name="repass"]').focus(function(){
                    if($(this).val() != $('input[name="password"]').val()){
					   $(this).next().text('输入的确认密码要与上面一致');
                        $('#pw2').removeClass('control-group').addClass('control-group error');
                    }
				}).blur(function(){
					if($(this).val().length >= 6 && $(this).val().length <=20 && $(this).val()!='' && $(this).val() == $('input[name="password"]').val()){
						$(this).next().text('');
						ok3=true;
                        $('#pw2').removeClass('control-group error').addClass('control-group');
					}else{
						$(this).next().text('输入的确认密码要与上面一致');
                        $('#pw2').removeClass('control-group').addClass('control-group error');
					}
					
				});
        $('#summit').click(function(){
					if(ok1 && ok2 && ok3){
						$('#addadmin').submit();
					}else{
						return false;
					}
				});
	    $('#stupwd').click(function(){
						if(ok2 && ok3){
							$('#changepwd').submit();
						}else{
							return false;
						}
					});
	    });