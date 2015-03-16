/**
 * Created by wei_jc on 2015/3/15.
 */
var loader_config = {
    baseUrl: '/syyundong/doc/pages/js/',
    paths: {
        'jquery': 'lib/jquery-1.11.1',
        'validate': 'lib/jquery.validate',
        'bootstrap': 'lib/bootstrap',
        'jqueryUI': 'jquery-ui-1.10.3.custom.min',
        'common': 'common',
        'page_login': 'pages/login',
        'page_forgetPassword': 'pages/forgetPassword'
    },
    shim: {
        'bootstrap': {
            deps: ['jquery'],
            exports: 'bootstrap'
        },
        'common': {
            deps: ['jquery', 'bootstrap', 'validate'],
            exports: 'common'
        },
        'page_login': {
            deps: ['common'],
            exports: 'page_login'
        },
        'page_forgetPassword': {
            deps: ['common'],
            exports: 'page_forgetPassword'
        }
    }
};

var Loader = {
    modules: [],
    load: function(modules) {
        for(var i = 0; i < modules.length; i++) {
            modules[i] = modules[i].replace('.', '_');
        }
        this.modules = modules;
    }
};

// 写入css
var baseCssUrl = '/syyundong/doc/pages/css/';
document.write('<link type="text/css" rel="stylesheet" href="' + baseCssUrl + '/common.min.css">');
document.write('<link type="text/css" rel="stylesheet" href="' + baseCssUrl + '/public.css">');
document.write('<link type="text/css" rel="stylesheet" href="' + baseCssUrl + '/zm.css">');

// 写入script
var _script = document.createElement("script");
_script.type = "text/javascript";
_script.src = "js/require.js";
_script.async = true;
_script.onload = function() {
    require.config(loader_config);

    // 加载模块
    require(Loader.modules);
};
document.getElementsByTagName("head")[0].appendChild(_script);

