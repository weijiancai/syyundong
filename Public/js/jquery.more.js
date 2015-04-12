(function( $ ){          
    var target = null;
    var templates = null;
    var lock = false;
    var variables = {
        'last'      :    0        
    } 
    var settings = {
        'amount'      :   '10',          
        'address'     :   'comments.php',
        'format'      :   'json',
        'templates'   :   '.single_item',
	//	'trigger'     :   '.get_more',
        'trigger'     :   '.btn-block',
        'scroll'      :   'false',
        'offset'      :   '100',
        'spinner_code':   '',
		'source_id'	  : ''

    }
    
    var methods = {
        init  :   function(options){
            return this.each(function(){
                if(options){
                    $.extend(settings, options);
                }
				
                templates = $(this).children(settings.templates).wrap('<div/>').parent();
                templates.css('display','none')
                $(this).append('<div class="more_loader_spinner">'+settings.spinner_code+'</div>')
                $(this).children(settings.templates).remove()   
                target = $(this);
                if(settings.scroll == 'false'){                    
                    $(this).find(settings.trigger).bind('click.more',methods.get_data);
                    $(this).more('get_data');
                }                
                else{
                    if($(this).height() <= $(this).attr('scrollHeight')){
                        target.more('get_data',settings.amount*2);
                    }
                    $(this).bind('scroll.more',methods.check_scroll);
                }
            })
        },
        check_scroll : function(){
            if((target.scrollTop()+target.height()+parseInt(settings.offset)) >= target.attr('scrollHeight') && lock == false){
                target.more('get_data');
            }
        },
        debug :   function(){
            var debug_string = '';
            $.each(variables, function(k,v){
                debug_string += k+' : '+v+'\n';
            })
          //  alert(debug_string);
        },     
        remove        : function(){            
            target.children(settings.trigger).unbind('.more');
            target.unbind('.more')
            target.children(settings.trigger).remove();
        },
        add_elements  : function(data){
         //   alert('adding elements')
            
            var root = target       
         //   alert(root.attr('id'))
            var counter = 0;
            if(data){
				var html='';
				for(var i=0;i<data.length;i++){
					html += t= template('list',data[i]);
					root.children(settings.template+':last').attr('id', 'more_element_'+ ((variables.last++)+1)) 
				}
				if(settings.scroll == 'true'){
					root.children('.more_loader_spinner').before(html)	
				}else{
					root.children('.link').before(html)  
				}
				 
            }            
            else  methods.remove()
            target.children('.more_loader_spinner').css('display','none');
            if(counter < settings.amount) methods.remove()            

        },
        get_data      : function(){   
           // alert('getting data')
            var ile;
            lock = true;
            target.children(".more_loader_spinner").css('display','block');
            $(settings.trigger).css('display','none');
            if(typeof(arguments[0]) == 'number') ile=arguments[0];
            else {
                ile = settings.amount;              
            }
            $.post(settings.address, {
                last : variables.last, 
                amount : ile,
                source_id:settings.source_id
            }, function(data){  
				if(!data){
					$('#pageBar').html("<span>没有更多内容</span>")
					$('.btn-block').html("没有更多内容");
				}
                $(settings.trigger).css('display','block')
                methods.add_elements(data)
                lock = false;
            }, settings.format)
        }
    };
    $.fn.more = function(method){
        if(methods[method]) 
            return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        else if(typeof method == 'object' || !method) 
            return methods.init.apply(this, arguments);
        else $.error('Method ' + method +' does not exist!');

    }    
})(jQuery)