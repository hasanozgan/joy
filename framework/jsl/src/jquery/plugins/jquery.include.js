/**
*	@name							Lazy
*	@descripton						Lazy is Jquery plugin that lazy loads Jquery plugins
*	@version						1.3.1
*	@requires						Jquery 1.2.6+
*	@author							Jan Jarfalk jan.jarfalk@unwrongest.com
*
*	@param {String} src				Path to the plugin you want to load
*	@param {String} name			Function name of the plugin
*	@param {Hash} dependencies		Hash with the keys js and css
*		@param {Array} js			Array of paths to javascript dependencies
*		@param {Array} css			Array of paths to css dependencies
*	@param {Bool} cache				Enable or disable caching
*/

(function($) {
	
	$.include = function(options)
	{
		
		// Create local variables
		var src = options.src,
			name = options.name,
			cache = options.cache,
			self, arg, object = {};
		
		// Add plugin to the archive
		$.include.archive[src] = {'status':'unloaded','que':[]};
		
		
		// Add a CSS file to the document
		function loadCSS(src,callback,self,name,arg){
			
			$.include.archive[src].status = "loading";
			
			var node = document.createElement('link');
			node.type = 'text/css';
			node.rel = 'stylesheet';
			node.href = src;
			node.media = 'screen';
			document.getElementsByTagName("head")[0].appendChild(node);
			
			$.include.archive[src].status = 'loaded';

			if(callback)
				callback(self,name,arg);
		}
		
		// Add a JS file to the document
		function loadJS(src,callback,self,name,arg){
			
			$.include.archive[src].status = "loading";
				
			$.ajax({
				type: "GET",
			  	url: src,
			  	cache: cache,
			  	dataType: "script",
			  	success: function(){
			  		$.include.archive[src].status = 'loaded';
					if(callback) {
						callback(self,name,arg);
					}
				}
			});
			
		}
		
		// Wrapper for loadJS for the actual plugin file
		function loadPlugin(self, name, arg){
			
			function callback(){
				if(typeof self == 'object'){
					self.each(function(){
						if(arg.length > 0){
							$(this)[name].apply(self,arg);
						} else {
							$(this)[name]();
						}
					});
				} else {
					$[name].apply(null,arg);
				}
				
				$.each($.include.archive[src].que,function(i){
					var queItem = $.include.archive[src].que[i];
					object[queItem.name].apply(queItem.self,queItem.arguments);
				});
				$.include.archive[src].que = [];
			}
			
			loadJS(src,callback,self,name,arg);
		}
		
		// Proxy function
		object[name] = function () {
			
			
			
			var self = this;
			arg = arguments;
				
			if( $.include.archive[src].status === 'loaded' ) {
			
				$.each(this,function(){
					$(this)[name].apply(self,arg);
				});
				
			} else if ( $.include.archive[src].status === 'loading' ) {
				
				$.include.archive[src].que.push({'name':name,'self':self,'arguments':arg});
										
			} else {
			
				$.include.archive[src].status = 'loading';
				
				if ( options.dependencies ) {
					
					var css = options.dependencies.css || [],
						js = options.dependencies.js || [];
					
					var total = css.length + js.length;
					
					function loadDependencies(array, callback, callbackCallback){
									
						var length = array.length,
							src;
						
						array = array.reverse();
						
						while( length-- && total-- ){
							
							
							src = array[length];
							
							if(typeof $.include.archive[src] == 'undefined') {
								$.include.archive[src] = {'status':'unloaded','que':[]};
							}
							
							if($.include.archive[src].status === 'unloaded'){
								
								if(!total) {
								
									callback(src,function(){
										loadPlugin(self,name,arg);
									});
									
								} else {
								
									callback(src);
									
								}
								
							} else if( !total ) {
							
								loadPlugin(self,name,arg);
								
							}
						}
					}
					
					loadDependencies(css, loadCSS);
					loadDependencies(js, loadJS);
				
				} else {
					loadPlugin(self,name,arg);
					
				}
			}
				
			return this;
		};
		
		jQuery.fn.extend(object);
		jQuery.extend(object);
		
	};
	
	$.include.archive = {};

})(jQuery);
