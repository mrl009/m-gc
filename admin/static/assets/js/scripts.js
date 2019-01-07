
jQuery(document).ready(function() {
    $('.page-container form').submit(function(){
        var username = $(this).find('.username').val();
        var password = $(this).find('.password').val();
        var google     = $(this).find('.google').val();
        var token_private_key     = $(this).find('.token_private_key').val();
        if(username == '') {
            $(this).find('.error').fadeOut('fast', function(){
                $(this).css('top', '27px');
            });
            $(this).find('.error').fadeIn('fast', function(){
                $(this).parent().find('.username').focus();
            });
            return false;
        }
        if(password == '') {
            $(this).find('.error').fadeOut('fast', function(){
                $(this).css('top', '96px');
            });
            $(this).find('.error').fadeIn('fast', function(){
                $(this).parent().find('.password').focus();
            });
            return false;
        }
        if(google == '') {
            $(this).find('.error').fadeOut('fast', function(){
                $(this).css('top', '166px');
            });
            $(this).find('.error').fadeIn('fast', function(){
                $(this).parent().find('.google').focus();
            });
            return false;
        }
        $.post('login/checklogin',{username:username,password:password,google:google,token_private_key:token_private_key},function(c){c=eval('('+c+')');
	        if(c.status=='OK'){
	        		 window.location.href='/';
	        }else{
	        		layer.msg(c.msg,{shift:6});
	        		return false;
	        }
        });
        
        return false;
    });

    $('.page-container form .username, .page-container form .password').keyup(function(){
        $(this).parent().find('.error').fadeOut('fast');
    });
    
    

});
