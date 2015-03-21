define(['jquery', 'jquery.easing', 'core', 'base64'], function() {
  $(function() {
    var root = $('#index'),
      s = function(name) {
        return iyuesai.selector(name, root);
      };
    /*banner*/
    (function() {
      var ul = s('banner').find('ul'),
        len = ul.find('li').length,
        start = 0,
        contoller = s('banner').find('div.banner-controller'),
        html = '',
        timer;
      ul.css({
        'width': (len * 100) + '%'
      });
      ul.find('li').css('width', (100 / len) + '%');
      if (len > 1) {
        for (var i = 0; i < len; i++) {
          html += '<a href="javascript:;" data-index="' + i + '"';
          i == 0 && (html += ' class="current"');
          html += '></a>';
        }
        contoller.html(html);
        var player = function(index) {
          if (index == undefined) {
            start++;
            if (start > (len - 1)) start = 0;
            index = start;
          } else {
            start = parseInt(index);
          }
          ul.stop(true, true);
          ul.animate({
            left: -(index * 100) + '%'
          }, 800, 'easeInOutExpo')
          contoller.find('.current').removeClass('current');
          contoller.find('a:eq(' + index + ')').addClass('current');
        }
        contoller.delegate('a', 'click', function() {
          var index = parseInt($(this).attr('data-index'));
          clearInterval(timer);
          timer = null;
          player(index);
          timer = setInterval(player, 6000);
        });
        timer = setInterval(player, 6000);
      }
    })();

    /*队列加载模块*/
    (function() {
      iyuesai.api.tplQueueLoad([{
        'tpl': 'index-search',
        'selector': 'searchTemplate'
      }, {
        'tpl': 'index-recommend-events',
        'selector': 'recommendEvents',
        'url': s('recommendEvents').data('url')||''
      }, {
        'tpl': 'index-hot-topics',
        'selector': 'hotTopics',
        'url': s('hotTopics').data('url')||''
      }, {
        'tpl': 'index-hot-activity',
        'selector': 'hotActivity',
        'url': s('hotActivity').data('url')||''
      }, {
        'tpl': 'index-recommend-venues',
        'selector': 'recommendVenues',
        'url': s('recommendVenues').data('url')||''
      }], s);
    })();

    /*排行榜自动着色*/
    (function() {
      s('eventsRankings').find('li').each(function(index, val) {
        if (index > 2) {
          return true;
        }
        $(this).find('i').addClass('top' + index);
      });
    })();
  });
})