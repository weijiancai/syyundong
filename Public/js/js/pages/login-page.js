define(['jquery', 'core','valid','simplevalidtips','jquery.easing', 'jqueryui'], function() {
  $(function() {
    var root = $('#login-page'),
    s = function(name) {
      return iyuesai.selector(name, root);
    };
    (function(){
      $('form',root).valid({
        success : function() {
        	
        	// passport服务器会在登录后根据host设置cookie，所以放到前端来做比较好 added by yvon 20141013
        	var $fm = $('form');
        	var remember = $fm.find('input[name="remember"]:checked').length?365:1;
        	$.ajax({
    			url: iyuesai.server.passportServer+'login.do',
    			dataType:'jsonp',
    			data:{
    				'username': $.trim($fm.find('input[name="loginName"]').val()),
    		        'password': $.trim($fm.find('input[name="loginPass"]').val()),
    		        'remember': remember
    			},
    			type:'POST',
    			success:function(d, textStatus, jqXHR) {
    				if(d && d.code == 200){
    					var url = $.trim($fm.find('input[name="url"]').val());
    					if(url){window.location.href = window.decodeURIComponent(url)}else{window.location.href = iyuesai.server.websitePath+'/index'}
    				}else{
    					$.dialog.error('帐号或者密码错误');
    				}
    			}
        	});
        	
          return false;
        }
      });
      $("[validate-rules]", root).SimpleValidTips();
    })();
  });
});