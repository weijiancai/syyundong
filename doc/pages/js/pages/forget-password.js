define(['jquery', 'core', 'valid', 'simplevalidtips'], function() {
  $(function() {
    var root = $('#signup-page'),
      s = function(name) {
        return iyuesai.selector(name, root);
      };
    //init_page show 
  	$(document).ready(function() {
  		getPicCode();
  	});
  	getPicCode = function()
  	{
  		 $.ajax({
            url: iyuesai.server.passportServer + '../verify/verify.do?_=' + new Date().getTime(),
            dataType: 'jsonp',
            type: 'get',
            async: false,
            success: function(d, textStatus, jqXHR) {
              if (d && d.code == 200) {
              	$("#picCodeImg").attr("src",d["messages"]["data"]["verifyImage"]);
              }
            }
  		 });
  	};
  	$("#picCodeImg").bind("click",getPicCode);
    // 验证手机
    var t = null,x = n = 120;
    (function() {
      s('request-code').click(function() {
        var self = $(this);
        var phone = self.data('val');
        var countWrap = self.find('span');
        clearInterval(t);
        var phone = $.trim($("#signupPhone").val());
        if (phone.length != 11) {
          iyuesai.ui.lightMessageBox({
            'type': 'error',
            'content': '手机号不正确！'
          });
          return false;
        }
        //step 0.5:验证图片验证是否正确
        var picCode = $.trim($("#picCode").val());
        if(picCode == "")
        {
        	iyuesai.ui.lightMessageBox({
                'type': 'error',
                'content': '请输入图片验证码！'
              });
              return false;
        }
        $.ajax({
            url: iyuesai.server.passportServer + '../verify/verify.do?action=verify&verifyCode='+ $.trim($("#picCode").val())+'&verifyImage=' + $("#picCodeImg").attr("src") + '&_=' + new Date().getTime(),
            dataType: 'jsonp',
            type: 'get',
            async: false,
            success: function(d, textStatus, jqXHR) {
              if (d && d.code == 200 && d["messages"]["data"]["verify"] == true) {
            	//step 1: 触发手机验证码
                  $.ajax({
                    url: iyuesai.passportServer('forgotPassword.do?loginType=mobile&loginName=' + $.trim($("#signupPhone").val()) + '&verifyCode='+ $.trim($("#picCode").val())+'&verifyImage=' + $("#picCodeImg").attr("src") +'&_=' + new Date().getTime()),
                    dataType: 'jsonp',
                    type: 'get',
                    async: false,
                    success: function(d, textStatus, jqXHR) {
                      if (d && d.code == 200 && d["messages"]["data"]["isSent"] == true) {
                        iyuesai.ui.lightMessageBox({
                          'content': '短信已发送'
                        });
                        t = setInterval(function() {
                          x--;
                          if (x == 0) {
                            clearInterval(t);
                            countWrap.html('');
                            self.attr('disabled', false);
                            x = n;
                          } else {
                            countWrap.html('(' + x + ')');
                            self.attr('disabled', true)
                          }
                        }, 1000);
                      } else {
                        iyuesai.ui.lightMessageBox({
                          'type': 'error',
                          'content': '手机号尚未注册！'
                        });
                      }
                    }
                  });
              } else {
                  iyuesai.ui.lightMessageBox({
                    'type': 'error',
                    'content': '图片验证码不正确！'
                  });
                }
              }
            });//end ajax
      });
      $(document).delegate('a[data-selector="re-send-code"]', 'click', function(event) {
        if (x != n) {
          $.dialog.error('请不要频繁发送！');
        } else {
          $.dialog.getCurrent().close();
          setTimeout(function() {
            s('request-code').trigger('click');
          }, 50);
        }
      });
    })();

    (function() {
      $('form', root).valid({
        type: {
          callback: function(data) {
            if (!data.valid) {
              $.dialog.error(data.customErrorMsg);
            }
          }
        },
        success: function() {
          var $fm = $('form');
          // step 1: 触发手机验证码验证
          $.ajax({
            url: iyuesai.passportServer('resetPassword.do?action=validateToken&resetToken=' + $.trim($("#signupCode").val()) + '&loginName=' + $.trim($("#signupPhone").val()) + '&loginType=mobile&_=' + new Date().getTime()),
            dataType: 'jsonp',
            type: 'get',
            success: function(d, textStatus, jqXHR) {
              if (d && d.code == 200 && d["messages"]["data"]["validate"] == true) {
                //step 2: 触发手机resetpassword submit
                $.ajax({
                  url: iyuesai.passportServer('resetPassword.do?loginType=mobile&loginName=' + $.trim($("#signupPhone").val()) + '&resetToken=' + $.trim($("#signupCode").val()) + '&password=' + $.trim($("#signupPass").val()) + '&password1=' + $.trim($("#confirmPass").val()) + '&_=' + new Date().getTime()),
                  dataType: 'jsonp',
                  type: 'get',
                  async: false,
                  success: function(d, textStatus, jqXHR) {
                    if (d && d.code == 200 && d["messages"]["data"]["reset"] == true) {
                      iyuesai.ui.lightMessageBox({
                        'content': '重置密码成功！'
                      });
                      setTimeout(function(){
                        window.location.href=window.iyuesai_config.websitePath + "/auth/login";
                      },1500)
                    } else //手机验证出错
                    {
                      iyuesai.ui.lightMessageBox({
                        'type': 'error',
                        'content': '重置密码失败！'
                      });
                    }
                  }
                });
              } else //手机验证码出错
              {
                iyuesai.ui.lightMessageBox({
                  'type': 'error',
                  'content': '手机验证码错误！'
                });
              }
            } //end_success
          });
        }
      });
      $("[validate-rules]", root).SimpleValidTips();
    })();

  });
});