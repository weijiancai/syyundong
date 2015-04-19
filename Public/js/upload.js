$(function () {
	var i=0;
	var ShowImg = $('#nickthumb');
	var files = $(".files");
	var btn = $(".btn span");
	$("#fileupload").wrap("<form id='myupload' action='/Puser/upimg' method='post' enctype='multipart/form-data'></form>");
	$("#fileupload").change(function(event){
		var size = event.target.files[0].size;
		var name = event.target.files[0].name;
		var format = name.substring(name.lastIndexOf(".")+1,name.length).toLowerCase();
		if((size>=6291456)){
			var str = '<span>图片尺寸超过限制</span>';
			$("#show_mes").html(str);
			$("#alert_box").css({display:"block"});
		}else if((format!='jpg')&&(format!='jpeg')&&(format!='png')){
			var str = '<span>请上传 jpg/jpeg/png格式的图片！</span>';
			$("#show_mes").html(str);
			$("#alert_box").css({display:"block"});
		}else{
			var len = $("#showimg li").length;
			if(len<=2){
				$("#myupload").ajaxSubmit({
					dataType:  'json',
					data:{path:$("#path").val()},
					beforeSend: function() {
                        ShowImg.append("<li><img width:52px height=52px src='/Public/images/wap/upimg_loading.gif'></li>");
					},
					success: function(data) {
						var img = "/Public/Upload/"+data.path+"/"+data.pic;
						$("#showimg li:last-child").html("<span class='delimg' rel='"+data.pic+"'></span><img width:52px height=52px src='"+img+"'>");
					},
					error:function(xhr){
						var str = '<span>出错啦!</span>';
						$("#show_mes").html(str);
						$("#alert_box").css({display:"block"});				
					}
				});
			}else{
					var str = '<span>只能上传3张图片</span>';
					$("#show_mes").html(str);
					$("#alert_box").css({display:"block"});
					return false;
			};				
		}		
	});
	$(".delimg").live('click',function(){
		var pic = $(this).attr("rel");
		$(this).parent().remove();
	});
	
	$("button").click(function(){
		$('#Pic').val('');
		$("ul li .delimg").each(function(){ 
			var id= $(this).parent().attr('id')
			$('#Pic').val($('#Pic').val()+$(this).attr('rel')+',');
		});
	});
	$("#but01").click(function(){
		$("#alert_box").css("display","none");
		
	});
});