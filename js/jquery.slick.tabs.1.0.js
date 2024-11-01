/*
 * DC jQuery Slick Tabs - jQuery Slick Tabs
 * Copyright (c) 2011 Design Chemical
 * 	http://www.designchemical.com
 *
 * Dual licensed under the MIT and GPL licenses:
 * 	http://www.opensource.org/licenses/mit-license.php
 * 	http://www.gnu.org/licenses/gpl.html
 *
 */

(function($){

	//define the new for the plugin ans how to call it
	$.fn.dcSlickTabs = function(options) {

		//set default options
		var defaults = {
			method: 'slide',
			classWrapper: 'dc-social',
			classContent: 'dc-social-content',
			idWrapper: 'dc-social-'+$(this).index(),
			slideWrap: 'slide-wrap',
			classTabContent: 'tab-content',
			location: 'left',
			align: 'top',
			offset: 50,
			speed: 'slow',
			autoClose: true,
			width: 300,
			height: 300,
			direction: 'horizontal',
			start: 0,
			slider: 'dcsmt',
			slides: 'tab-content',
			tabs: 'social-tabs',
			classOpen: 'dcsmt-open',
			classClose: 'dcsmt-close',
			classToggle: 'dcsmt-toggle',
			onLoad : function() {},
            beforeOpen : function() {},
			beforeClose: function() {}
		};

		//call in the default otions
		var options = $.extend(defaults, options);
		var $dcSlickObj = this;
		//act upon the element that is passed into the design
		return $dcSlickObj.each(function(options){

			// declare variables
			var clWrap = defaults.classWrapper;
			var idWrapper = defaults.idWrapper;
			var speed = defaults.speed;
			var offset = defaults.offset+'px';
			var width = defaults.width;
			var height = defaults.height;
			var direction = defaults.direction;
			
			var linkOpen = $('.'+defaults.classOpen, this);
			var linkClose = $('.'+defaults.classClose, this);
			var linkToggle = $('.'+defaults.classToggle, this);
			
			$(this).addClass(defaults.classContent).wrap('<div id="'+idWrapper+'" class="'+clWrap+'" />');
			
			var $slider = $('#'+idWrapper);
			var $tab = $('.'+defaults.tabs,$slider);
			
			var widthPx = width+'px';
			var heightPx = height+'px';
			var bodyHeight = $(window).height();
			
			if(defaults.method == 'slide'){
				slickSetup($slider);
				sliderSetup();
				
				if(defaults.autoClose == true){
					$('body').mouseup(function(e){
						if($slider.hasClass('active')){
							if(!$(e.target).parents('#'+defaults.idWrapper+'.'+defaults.classWrapper).length){
								slickClose();
							}
						}
					});
				}
				
				$('li a',$tab).click(function(e){
					var i = parseInt($(this).attr('rel'));
					if(!$slider.hasClass('active')){
						slickOpen();
					}
					slickTabs(i);
					e.preventDefault();
				});
				
			$(linkOpen).click(function(e){
				slickOpen();
				e.preventDefault();
			});
			
			$(linkClose).click(function(e){
				if($slider.hasClass('active')){
					slickClose();
				}
				e.preventDefault();
			});
			
			$(linkToggle).click(function(e){
				if($slider.hasClass('active')){
					slickClose();
				} else {
					slickOpen();
				}
				e.preventDefault();
			});
				
			} else {
				staticSetup($slider);
				sliderSetup();
				$('li a',$tab).click(function(e){
					var i = parseInt($(this).attr('rel'));
					slickTabs(i);
					e.preventDefault();
				});
			}
			
			slickTabs(defaults.start);
			
			function slickTabs(i){
				$('li',$tab).removeClass('active');
				$('li:eq('+i+')',$tab).addClass('active');
				tabSlide(i);
			}
	
			function slickOpen(){
			
				$('.'+clWrap).css({zIndex: 10000});
				$slider.css({zIndex: 10001});
				var init = {marginBottom: "-=5px"};
				var params = {marginBottom: 0};
				switch (defaults.location) {
					case 'top': 
					init = {marginTop: "-=5px"};
					params = {marginTop: 0};
					break;
					case 'left':
					init = {marginLeft: "-=5px"};
					params = {marginLeft: 0};					
					break;
					case 'right': 
					init = {marginRight: "-=5px"};
					params = {marginRight: 0};
					break;
				}
				$slider.animate(init, "fast").animate(params, speed).addClass('active');
				
				// onOpen callback;
				defaults.beforeOpen.call(this);
			}
			
			function slickClose(){
			
			$slider.css({zIndex: 10000});
			if($slider.hasClass('active')){
				var params = {"marginBottom": "-"+heightPx};
				switch (defaults.location) {
					case 'top': 
					params = {"marginTop": "-"+heightPx};
					break;
					case 'left':
					params = {"marginLeft": "-"+widthPx};					
					break;
					case 'right': 
					params = {"marginRight": "-"+widthPx};
					break;
				}
				$slider.removeClass('active').animate(params, speed);
			}
			// onClose callback;
			defaults.beforeClose.call(this);
			}
			
			function tabSlide(pos){
				// Set animation based on direction
				var params = direction == 'vertical' ? {'marginTop' : height*(-pos)} : {'marginLeft' : width*(-pos)} ;
				$('#'+defaults.slideWrap).stop().animate(params);
			}
			
			function sliderSetup(){
				var slideContainer = $('.'+defaults.slider);
				var slides = $('.'+defaults.slides);
				var numSlides = slides.length;
				slideContainer.css({height: height+'px', width: width+'px'});
				slides.css({height: height+'px', width: width+'px'});
				// Set CSS of slide-wrap based on direction
				wrapCss = direction == 'vertical' ? {height: height * numSlides} : {width: width * numSlides} ;
				
				// Wrap the slides & set the wrap width
				slides.wrapAll('<div id="'+defaults.slideWrap+'"></div>').css({'float' : 'left','width' : width});
				$('#'+defaults.slideWrap).css(wrapCss);
			}
			
			function slickSetup(obj){
				$tab.css({position: 'absolute'});
				var $container = $('.'+defaults.classContent,obj);
				// Get slider border
				var bdrTop = $slider.css('border-top-width');
				var bdrRight = $slider.css('border-right-width');
				var bdrBottom = $slider.css('border-bottom-width');
				var bdrLeft = $slider.css('border-left-width');
				// Get tab dimension
				var tabWidth = $tab.outerWidth();
				var tabWidthPx = tabWidth+'px';
				var tabHeight = $tab.outerHeight();
				var tabHeightPx = tabHeight+'px';

				$(obj).addClass(defaults.location).addClass('align-'+defaults.align).css({position: 'fixed', zIndex: 10000});

				$container.css({height: heightPx, width: widthPx, position: 'relative'});
				
				switch(defaults.location){
					case 'left':
					objcss = {marginLeft: '-'+widthPx, top: offset, left: 0};
					tabWidth = $('li',$tab).outerWidth();
					tabWidthPx = tabWidth+'px';
					tabcss = {top: 0, right: 0, marginRight: '-'+tabWidthPx};
					break;
					case 'right':
					objcss = {marginRight: '-'+widthPx, top: offset, right: 0};
					tabWidth = $('li',$tab).outerWidth();
					tabWidthPx = tabWidth+'px';
					tabcss = {top: 0, right: 0, marginLeft: '-'+tabWidthPx};
					break;
					case 'top':
					objcss = {marginTop: '-'+heightPx, top: 0};
					tabHeight = $('li',$tab).outerHeight();
					tabHeightPx = tabHeight+'px';
					tabcss = {bottom: 0, marginBottom: '-'+tabHeightPx};
					if(defaults.align == 'left'){
						$(obj).css({left: offset});
						$tab.css({left: 0});
					} else {
						$(obj).css({right: offset});
						$tab.css({right: 0});
					}
					break;
					case 'bottom':
					objcss = {marginBottom: '-'+heightPx, bottom: 0};
					tabHeight = $('li',$tab).outerHeight();
					tabHeightPx = tabHeight+'px';
					tabcss = {top: 0, marginTop: '-'+tabHeightPx};
					
					if(defaults.align == 'left'){
						$(obj).css({left: offset});
						$tab.css({left: 0});
					} else {
						$(obj).css({right: offset});
						$tab.css({right: 0});
					}
					break;
				}
				
				$(obj).css(objcss).addClass('sliding');;
				$tab.css(tabcss).css({height: tabHeightPx, width: tabWidthPx});
			}
			
			function staticSetup(obj){
				$(obj).addClass('static');
				tabHeight = $('li',$tab).outerHeight();
				$tab.css({height: tabHeight+'px'});
			}

		});
	};
})(jQuery);