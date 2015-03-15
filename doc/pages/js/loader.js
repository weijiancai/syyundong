var Loader = {
  c: "2.4.4.12369",
  s: "",
  p: "",
  charset: "utf-8",
  cache:{},
  config:{
  	'core':'zm.core.js',
  	'jquery':'jquery-1.8.3.min.js',
  	'jquery.easing':'plugins/jquery.easing.js',
  	'artdialog':'plugins/dialog.min.js',
  	'ajaxfileupload':'plugins/jquery.ajaxfileupload.min.js',
  	'checkboxrelated':'plugins/jquery.checkboxrelated.min.js',
  	'datetimepicker':'plugins/jquery.datetimepicker.min.js',
  	'placeholderui':'plugins/jquery.placeholderui.min.js',
  	'radioui':'plugins/jquery.radioui.min.js',
  	'simplevalidtips':'plugins/jquery.simplevalidtips.min.js',
  	'timeselector':'plugins/jquery.timeselector.min.js',
  	'valid':'plugins/jquery.valid.min.js',
    'datadropdown':'plugins/jquery.datadropdown.min.js',
    'database':'database.min.js',
    'jqueryui':'jquery-ui-1.10.3.custom.min.js',
    'position':'position.min.js',
    'match-position':'match-position.js',
    'json':'plugins/jquery.json.js',
    'base64':'plugins/jquery.base64.min.js',
    'imagesloaded':'plugins/jquery.imagesloaded.min.js',
    'masonry':'plugins/jquery.masonry.min.js',
    'gotop':'plugins/jquery.gotop.js',
    'jquery.cookie':'plugins/jquery.cookie.js'
  },
  get: function() {
    for (var a = 0; a < arguments.length; a++) {
      var b = arguments[a].substring(arguments[a].lastIndexOf(".") + 1);
      var c = this.s + (arguments[a].indexOf('/') === 0 ? arguments[a].substring(1) : (this.p + b + '/' + arguments[a])) + '?' + this.c;
      if (b == "css") {
        document.write(unescape("%3Clink href='" + c + "' rel='stylesheet' type='text/css'/%3E"))
      } else if (b == "js") {
        document.write(unescape("%3Cscript src='" + c + "' type='text/javascript' charset='" + this.charset + "'%3E%3C/script%3E"))
      }
    }
  }
};
define = function(require,callback){
	return new module(require,callback);
}
function module(require,callback){
	if(require){
		for(var i=0;i<require.length;i++){
			if(Loader.config[require[i]]){
				require[i] = Loader.s + Loader.p + 'js/'+Loader.config[require[i]];
			}
		}
    var _loaded = Loader.s+Loader.p+'js/jquery-1.8.3.min.js?'+Loader.c;
    this.cache(_loaded,'loaded');
		this.createScript(require,callback);
	}
}
module.prototype = {
	_cache: {},
  cache:function(name, value){
    if(!name) throw new Error('define.cache -> '+name+' is null.');
    if(value){
      this._cache[name] = value;
      return this;
    } else {
      return this._cache[name] || null;
    }
  },
  createScript:function(url,callback){
		var dc = document,self = this;
	  var urls = url;
	  var completeNum = 0, ie6 = window.VBArray && !window.XMLHttpRequest;
	  callback = callback || function(){};
	  if(urls.length === 0){
	    callback instanceof Function && callback();
	  } else {
	    for( var i = 0; i < urls.length; i++ ){
	      (function(_path){
	        _path += (_path.indexOf("?") !== -1 ? "&" : "?") + window.Loader.c;
	        if(self.cache(_path)){
	          (function(){
	            if (self.cache(_path) === "loaded") {
	              completeNum++;
	              completeNum >= urls.length ? callback() : "";
	            } else {
	              window.setTimeout(arguments.callee, 50);
	            }
	          })();
	        } else {
	          self.cache(_path, "loading");
	          var _script = dc.createElement("script");
	          _script.type = "text/javascript";
            _script.async && (_script.async = "true");
            _script.defer && (_script.defer = "true");
	          if(_script.readyState){
	            _script.onreadystatechange = function(){
	              if(ie6 && !this.getAttribute("initialized")){
	                dc.getElementsByTagName("head")[0].appendChild(_script);
	                this.setAttribute("initialized", true);
	              }
	              if( this.readyState == "loaded" || this.readyState == "complete" ){
	                self.cache(_path, "loaded");
	                this.onreadystatechange = null;
	                completeNum++;
	                completeNum >= urls.length ? callback() : "";
	              }
	            };
	            _script.src = _path;
	            !ie6 && dc.getElementsByTagName("head")[0].appendChild(_script);
	          } else {
	            _script.src = _path;
	            _script.onload = function(){
	              self.cache(_path, "loaded");
	              completeNum++;
	              completeNum >= urls.length ? callback() : "";
	            };
	            dc.getElementsByTagName("head")[0].appendChild(_script);
	          }
	        }
	      })(urls[i]);
	    }
	  }
	}
}
Loader.get("common.min.css","public.css","zm.css","plugins/jquery-ui-1.10.3.custom.min.css","plugins/dialog/ui-dialog.min.css","jquery-1.8.3.min.js","zm.core.js","public.min.js");
