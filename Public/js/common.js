/**
 * Created by wei_jc on 2015/3/15.
 */
$.validator.setDefaults({
    errorClass: 'text-error',
    invalidHandler: function (event, validator) { //display error alert on form submit
        for(var i = 0; i < validator.errorList.length; i++) {
            console.log(validator.errorList[i].message);
            $(validator.errorList[i].element).tooltip('destroy');
            $(validator.errorList[i].element).tooltip({
                html: true,
                placement: 'top',
                title: validator.errorList[i].message,
                trigger: 'focus '
            }).data('data-original-title', validator.errorList[i].message);
        }
    },
    /*highlight: function (element) { // hightlight error inputs
        $(element).addClass('text-error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change dony by hightlight
        $(element).removeClass('text-error').tooltip('destroy');
    },*/
    success: function (label, element) {
        $(element).tooltip('destroy');
    },
    errorPlacement: function (error, element) {
        //error.addClass('help-small no-left-padding').insertAfter(element.closest('.input-icon'));
    }
});

(function ($) {
    $.fn.serializeJson = function () {
        var serializeObj = {};
        var array = this.serializeArray();
        var str = this.serialize();
        $(array).each(function () {
            if (serializeObj[this.name]) {
                if ($.isArray(serializeObj[this.name])) {
                    serializeObj[this.name].push(this.value);
                } else {
                    serializeObj[this.name] = [serializeObj[this.name], this.value];
                }
            } else {
                serializeObj[this.name] = this.value;
            }
        });
        return serializeObj;
    };

    // 图片查看
    $.fn.imageView = function() {
        var userName = this.data('user_name');
        var userImage = this.data('user_image');
        var $images = this.find('img');
        var total = $images.length;
        var userUrl = '';
        var current = 0;

        var tpl = '<div>' +
            '    <div class="imageView">' +
            '        <a class="image-prev" href="javascript:;" style="display: none;"></a>' +
            '        <a class="image-next" href="javascript:;" style="display: none;"></a>' +
            '' +
            '        <div class="image-content">' +
            '            <div class="image-panel">' +
            '                <img src="" style="max-height: 763px; display: block;">' +
            '            </div>' +
            '            <!--<div class="share-image clearfix" style="right: -185px;">' +
            '                <a target="_blank" title="分享到qq空间" class="shareto shareto-qzone" href="http://www.jiathis.com/send/?webid=qzone&amp;url=http://www.iyuesai.com/topic/7970&amp;appkey=zDey5D5hxEaececk&amp;pic=http://static.wisdom-china.cn//images/1/7330/4811/2080/176b726c69126e9c855aabb6089d19b0_0_0.jpg&amp;title=爱约赛&amp;summary=一场马拉松留给你的，不仅是一块牌子，更是一段故事，来这里找到你的照片，珍藏你的广马故事。动乐|赛事|脚步飞扬！珍藏你的广马时刻！"></a>' +
            '                <a target="_blank" title="分享到新浪微博" class="shareto shareto-tsina" href="http://www.jiathis.com/send/?webid=tsina&amp;url=http://www.iyuesai.com/topic/7970&amp;appkey=1868074881&amp;pic=http://static.wisdom-china.cn//images/1/7330/4811/2080/176b726c69126e9c855aabb6089d19b0_0_0.jpg&amp;title=爱约赛&amp;summary=一场马拉松留给你的，不仅是一块牌子，更是一段故事，来这里找到你的照片，珍藏你的广马故事。动乐|赛事|脚步飞扬！珍藏你的广马时刻！"></a>' +
            '            </div>-->' +
            '        </div>' +
            '        <div class="module-loading" style="left: 8.33333%; top: 20%; display: none;">' +
            '            <i class="masking"></i>' +
            '        </div>' +
            '    </div>' +
            '</div>';

        $images.click(function() {
            var d = dialog({
                id: "imgViewer",
                content: tpl,
                padding: 0,
                title: '<a href="' + userUrl + '" target="_blank"><img src="' + userImage + '" style="width:25px;height:25px;border-radius:50%;-webkit-border-radius:50%;-moz-border-radius:50%;"/></a> <a href="' + userUrl + '" style="color:#F5A623;" target="_blank">' + userName + "</a> 分享的图片" + (total > 1 ? '&nbsp;&nbsp;<span class="muted" id="imageViewerCount" style="font-weight:normal;">1/' + total + "</span>" : ""),
                onshow: function() {
                    var title = this._$('title');


                    var $content = this._$('content');
                    var prev = $content.find('.image-prev');
                    var next = $content.find('.image-next');

                    // 上一張
                    prev.click(function() {
                        current--;
                        setImageSrc();
                    });
                    // 下一張
                    next.click(function() {
                        current++;
                        setImageSrc();
                    });

                    var $img = $content.find('.image-panel img');
                    setImageSrc();

                    $content.hover(function() {
                        console.log('hover');
                        prev.show();
                        next.show();
                    }, function() {
                        console.log('un hover');
                        prev.hide();
                        next.hide();
                    });

                    function setImageSrc() {
                        if(current < 0) {
                            current = 0;
                        } else if(current > total - 1) {
                            current = total - 1;
                        }

                        $img.attr('src', $images.eq(current).parent().data('href'));
                        d.reset();
                        // 更新標題
                        title.find('#imageViewerCount').text((current + 1) + '/' + total);
                    }
                }
            });
            d.showModal();
        });
    };
})(jQuery);