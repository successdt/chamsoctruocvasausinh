/**
 * ****************************************************************************
 * THB add/remove class on hover
 * 
 * $(".myelement").hoverClass("classname");
 * ****************************************************************************
 */
(function($) {
	$.fn.hoverClass = function(c) {
		return this.each(function(){
			$(this).hover( 
				function() { $(this).addClass(c);  },
				function() { $(this).removeClass(c); }
			);
		});
	};
})(jQuery);

/**
 * ****************************************************************************
 * THB menu
 * 
 * $("#menu-container").menu();
 * ****************************************************************************
 */
(function($) {

	$.fn.menu = function(params) {

		// Parameters
		// --------------------------------------------------------------------
		var settings = {
			'speed': 350,
			'easing': 'linear',
			'showCallback': function() {},
			'hideCallback': function() {}
		};

		// Parameters
		$.extend(settings, params);

		// Menu instance
		// --------------------------------------------------------------------
		var instance = {

			showSubMenu: function(subMenu) {
				subMenu
					.stop(true, true)
					.fadeIn(settings.speed, settings.easing, function() {
						settings.showCallback();
					});
			},

			hideSubMenu: function(subMenu) {
				subMenu
					.stop(true, true)
					.fadeOut(settings.speed / 2, settings.easing, function() {
						settings.hideCallback();
					});
			}

		};

		return this.each(function() {
			var menuContainer = $(this),
				menu = menuContainer.find("> ul"),
				menuItems = menu.find("> li"),
				subMenuItems = menuItems.find('li').andSelf();

			menuItems.each(function() {
				$(this)
					.find("> ul")
					.css({
						display: 'none'
					});
			});

			// Binding events
			subMenuItems.each(function() {
				var item = $(this),
					subMenu = item.find("> ul");

				if( subMenu.length ) {
					item
						.mouseenter(function() {
							instance.showSubMenu(subMenu);
						})
						.mouseleave(function() {
							instance.hideSubMenu(subMenu);
						});
				}
			});
		});

	}

})(jQuery);

/**
 * ****************************************************************************
 * THB go top
 * 
 * $(".gotop").gotop();
 * ****************************************************************************
 */
(function($) {
	
	$.fn.gotop = function(params) {

		var settings = {
			'speed': 350,
			'easing': 'linear'
		};

		// Parameters
		$.extend(settings, params);

		return this.each(function(index, button) {
			
			button = $(button);
			button
				.click(function() {
					$('html, body').animate({ scrollTop: 0 }, settings.speed, settings.easing);
					return false;
				});

		});

	}

})(jQuery);

/**
 * ****************************************************************************
 * THB image preload
 * 
 * $(".preload").preload();
 * ****************************************************************************
 */
(function($) {
	
	$.fn.preload = function(params) {

		var settings = {
			'image_delay': 350,
			'image_transition': 350,
			'image_easing': 'linear',
			'sequenced': false
		};

		// Parameters
		$.extend(settings, params);

		return this.each(function(index, preload) {
			
			preload = $(preload);

			// Images
			// ----------------------------------------------------------------
			var images = preload.find("img");

			images.each(function(j, image) {

				var image = $(image);

				image.css({
					"visibility": "hidden",
					"opacity": 0
				});

				// Image URL
				var src = image.attr("src");

				// The loading action
				var sequence = settings.sequenced ? index : 1;

				image
					.attr("src", "")
					.one("load", function() {
						image.css("visibility", "visible");
						image.delay(settings.image_delay * sequence).animate({
							"opacity": 1
						}, settings.image_transition, settings.image_easing, function() {
							preload.css("background-image", "none");
							image.css("filter", "none");
						});
					})
					.attr("src", src);

				if(image.get(0).complete)
					$(this).trigger("load");

			});

		});
	}

})(jQuery);

/**
 * ****************************************************************************
 * THB full background image
 * 
 * $.fullBackground();
 * ****************************************************************************
 */
(function($) {

	$.fullBackground = function(parameters) {
		
		// Parameters
		// --------------------------------------------------------------------
		var p = $.extend({
			speed: 500,
			easing: 'linear',
			backgroundContainerId: 'background_slider',
			slideClass: 'slide',
			slideLoadedClass: 'slide_loaded',
			height: 0,
			offsetHeight: 'center' // 'center', 'top', 'bottom'
		}, parameters);

		// Full background instance
		// --------------------------------------------------------------------
		var instance = {
			
			// Window dimensions
			w_width: 0,
			w_height: 0,

			// Slides dimensions
			width: 0,
			height: 0,
			offsetTop: 0,
			offsetLeft: 0,

			// Canvas support
			canvas_support: false,

			// Container
			container: $("#" + p.backgroundContainerId),

			// Slides
			slides: $("#" + p.backgroundContainerId).find("." + p.slideClass),

			// Check for canvas support
			checkCanvasSupport: function () {
				var canvas = document.createElement("canvas");
				// instance.canvas_support = !!(canvas.getContext && canvas.getContext('2d'));

				if( instance.canvas_support )
					$("body").addClass("canvas");
			},

			// Window resize
			windowResize: function() {
				setTimeout(function() {
					instance.slides.each(function(i, slide) {
						slide = $(slide);
						instance.slideResize(slide);
					});
				}, 10);
			},

			// Calculate image dimensions
			calculateDimensions: function(imgObj) {
				var w_ratio = instance.w_width / instance.w_height,
					img_height = imgObj.height,
					img_width = imgObj.width,
					img_ratio = img_width / img_height;

				if( w_ratio < img_ratio ) {
					// The window is smaller than the image
					instance.height = instance.w_height;
					instance.width = (instance.w_height/img_height) * img_width;
				} else {
					instance.height = (instance.w_width/img_width) * img_height;
					instance.width = instance.w_width;
				}

				instance.offsetTop = (instance.height - instance.w_height) / -2;
				instance.offsetLeft = (instance.width - instance.w_width) / -2;

				if( p.offsetHeight == 'top' )
					instance.offsetTop = 0;

				if( p.offsetHeight == 'bottom' ) {
					instance.offsetTop = instance.w_height - instance.height;
				}

			},
			
			// Slide loading
			slideLoad: function(slide) {
				var img = slide.find("img");
				var src = img.attr("src");

				img.attr("src", "");
				img
					.one("load", function() {
						instance.slideRender(slide);
					})
					.attr("src", src)
					.mousedown(function() {
						return false;
					});
			},

			// Slide render
			slideRender: function(slide) {
				var img = slide.find("img"),
					canvas = slide.find("canvas");
				var imgObj = img.get(0);
				
				instance.calculateDimensions(imgObj);

				var obj = img;
				if( instance.canvas_support )
					obj = canvas;
					
				if( instance.canvas_support ) {
					var ctx = canvas.get(0).getContext('2d');
					ctx.drawImage(imgObj, instance.offsetLeft, instance.offsetTop, instance.width, instance.height);
				} else {
					var shiftLeft = (instance.width - instance.w_width) / 2 * -1,
						shiftTop = (instance.height - instance.w_height) / 2 * -1;

					if( p.offsetHeight == 'top' ) {
						shiftTop = 0;
					}

					if( p.offsetHeight == 'bottom' ) {
						shiftTop = instance.w_height - instance.height;
					}

					img
						.css({ 
							height: instance.height, 
							width: instance.width,
							"max-width": "none",
							position: "relative",
							left: shiftLeft,
							top: shiftTop
						});
				}

				if( !slide.hasClass(p.slideLoadedClass) ) {
					obj.animate({ opacity: 1 }, p.speed, p.easing, function() {
						slide.addClass(p.slideLoadedClass);
					});
				}
			},

			// Get the slide type
			getSlideType: function(slide) {
				if( slide.hasClass("slide_type_picture") )
					return "picture";
				else if( slide.hasClass("slide_type_video") )
					return "video";
				else
					return "html";
			},

			// Slide resize
			slideResize: function(slide) {

				// Getting the viewport's dimension right on iOS
				instance.w_width = instance.container.width();
				instance.w_height = instance.container.height();

				// Slide type
				var type = instance.getSlideType(slide);

				if( type == "video" ) {

					var iframe = slide.find("iframe");
					var object = slide.find("object");

					if( iframe.length > 0 ) {
						iframe
							.attr({ height: instance.w_height, width: instance.w_width });
					}

					if( object.length > 0 ) {
						object
							.attr({ height: instance.w_height, width: instance.w_width });
					}
					
				} else {
					
					if( instance.canvas_support ) {

						var canvas = slide.find("canvas");

						if( canvas.length == 0 ) {
							canvas = $('<canvas class="slide_canvas" height="'+instance.w_height+'" width="'+instance.w_width+'"></canvas>');
							canvas
								.css({ opacity: 0 })
								.appendTo(slide);
						}
						else
							canvas
								.attr({ height: instance.w_height, width: instance.w_width });

					}

				}

				if( !slide.hasClass(p.slideLoadedClass) )
					instance.slideLoad(slide);
				else
					instance.slideRender(slide);
				
			}

		};

		// Bindings
		// --------------------------------------------------------------------
		$(window)
			.resize(function() {
				instance.windowResize();
			});
		window.onorientationchange = function() {
			instance.windowResize();
		}

		// Boot
		// --------------------------------------------------------------------
		instance.checkCanvasSupport();
		$(window).trigger("resize");

	}

})(jQuery);

/**
 * ****************************************************************************
 * THB toggle
 * 
 * $(".toggle").toggle();
 * ****************************************************************************
 */
(function($) {
	
	$.fn.toggle = function(parameters) {

		var parameters = jQuery.extend( {
			speed: '500',
			easing: 'linear',
			contentClass: 'slide_container',
			activeClass: 'open',
			openedByDefaultClass: 'default_open'
		}, parameters);

		$("."+parameters.contentClass).hide();
		return this.each(function(i,e) {
			var item = $(e);
			item.click(function() {
				$(this)
					.toggleClass(parameters.activeClass)
					.next()
						.toggleClass(parameters.activeClass)
						.slideToggle(parameters.speed, parameters.easing);
				return false;
			});

			if(item.hasClass(parameters.openedByDefaultClass))
				item.trigger("click");
		});
		
	}

})(jQuery);

/**
 * ****************************************************************************
 * THB tabs
 * 
 * $(".tabs_container").tabs();
 * ****************************************************************************
 */
(function($) {
	
	$.fn.tabs = function(parameters) {
		var parameters = jQuery.extend( {
			speed: '500',
			easing: 'linear',
			contentClass: 'tab-content',
			navigationClass: 't-nav',
			activeClass: 'active',
			contentActiveClass: 'content-active'
		}, parameters);

		return this.each(function(i,e) {
			var tabs = $(e);
			var navigation = tabs.find("."+parameters.navigationClass);
			var items = navigation.children();
			items.first().addClass(parameters.activeClass);
			var contents = tabs.find("."+parameters.contentClass+":eq(0)").addClass(parameters.contentActiveClass);

			items.each(function(j, item) {
				var item = $(item);
				item.find("a").click(function() {
					var a = $(this);
					if(item.hasClass(parameters.activeClass))
						return false;

					items.removeClass(parameters.activeClass);
					item.addClass(parameters.activeClass);
					var contents = tabs.find("."+parameters.contentClass).slideUp(parameters.speed, parameters.easing);
					var activeTab = a.attr("href");
					$(activeTab).slideDown(parameters.speed, parameters.easing);
					
					return false;
				});
			});
		});
	}

})(jQuery);

/**
 * ****************************************************************************
 * THB accordion
 * 
 * $(".accordion_container").accordion();
 * ****************************************************************************
 */
(function($) {
				
	$.fn.accordion = function(parameters) {
		var parameters = jQuery.extend( {
			speed: '500',
			easing: 'linear',
			itemClass: 'acc_item',
			contentClass: 'acc_container',
			titleClass: 'acc_trigger',
			openClass: 'open',
			firstElementOpenedByDefaultClass: 'first_element_opened',
			firstElementOpenedByDefault: false
		}, parameters);
		
		return this.each(function(i,e) {
			var accordion = $j(e);
			var items = accordion.children("."+parameters.itemClass);
			
			items.each(function(j,item) {
				var item = $j(item);
				var title = item.find("."+parameters.titleClass);
				title.click(function() {
					var parent = $j(this).parent("."+parameters.itemClass);
					items.not(parent).find("."+parameters.contentClass).slideUp(parameters.speed, parameters.easing);
					items.not(parent).find("."+parameters.titleClass).removeClass(parameters.openClass);
					var content = parent.find("."+parameters.contentClass);
					if(content.css("display") == "none") {
						parent.find("."+parameters.contentClass).slideDown(parameters.speed, parameters.easing);
						$j(this).addClass(parameters.openClass);
					}
					else {
						parent.find("."+parameters.contentClass).slideUp(parameters.speed, parameters.easing);
						$j(this).removeClass(parameters.openClass);
					}

					return false;
				});

				if( j==0 && ((parameters.firstElementOpenedByDefault) || accordion.hasClass(parameters.firstElementOpenedByDefaultClass)) )
					title.trigger("click");
			});
		});
	}
	
})(jQuery);