$(function(){
				//验证用户名
                var ok1 = false;
                $('input[name="inputcdnum"]').blur(function(){
               if($(this).val()!=''){
               $(this).next().text('');
               $('#cdnumgroup').removeClass('control-group error').addClass('control-group ');
               ok1=true;
               }
               else{
               $(this).next().text('书名不能为空');
               $('#cdnumgroup').removeClass('control-group').addClass('control-group error');
               }
          
        });

          var ok2 = false;
          $('input[name="inputcdname"]').blur(function(){
          if($(this).val()!=''){
          $(this).next().text('');
          $('#cdnamegroup').removeClass('control-group error').addClass('control-group');
            ok2=true;
          }else{
            $(this).next().text('编号不能为空');
            $('#cdnamegroup').removeClass('control-group').addClass('control-group error');
          }
          
        });

         var ok3 = false;
          $('input[name="inputbooknum"]').blur(function(){
          if($(this).val()!=''){
          $(this).next().text('');
          $('#booknumgroup').removeClass('control-group error').addClass('control-group');
            ok3=true;
          }else{
            $(this).next().text('编号不能为空');
            $('#booknumgroup').removeClass('control-group').addClass('control-group error');
          }
          
        });



        $('#summitbtn').click(function(){
          if(ok1 && ok2 && ok3){
            $('#cdform').submit();
          }else{
            return false;
          }
        });
      
    });

