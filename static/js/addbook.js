$(function(){
                var ok1 = false;
                $('input[name="inputbookname"]').blur(function(){
               if($(this).val()!=''){
               $(this).next().text('');
               $('#booknamegroup').removeClass('control-group error').addClass('control-group ');
               ok1=true;
               }
               else{
               $(this).next().text('书名不能为空');
               $('#booknamegroup').removeClass('control-group').addClass('control-group error');
               }
          
        });

          var ok2 = false;
          $('input[name="inputbooknum"]').blur(function(){
          if($(this).val()!=''){
          $(this).next().text('');
          $('#booknumgroup').removeClass('control-group error').addClass('control-group');
            ok2=true;
          }else{
            $(this).next().text('编号不能为空');
            $('#booknumgroup').removeClass('control-group').addClass('control-group error');
          }
          
        });


        $('#summitbtn').click(function(){
          if(ok1 && ok2){
            $('#addbookform').submit();
          }else{
            return false;
          }
        });
      
    });

