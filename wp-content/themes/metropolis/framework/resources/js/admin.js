/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/

jQuery(document).ready(function() {
	Admin.init();
	Duplicable.init();
	LinkedFields.init();

	background();
	font();
	googleFont();
});

/**
 * ****************************************************************************
 * THB Admin controller
 * 
 * ****************************************************************************
 */
(function($) {
	Admin = {

		parameters: {
			speed: 250
		},

		init: function() {
			$(".numberfield").numericInput();
			$(".date").datepicker({
				'dateFormat': 'yy-mm-dd'
			});
			styleSelect.init();
			$(".stripe").layoutSelect();
			Upload.init(".hb-row.upload, .hb-row.slide");
			CustomPostTypes.init();
			$(".notice").delay(4000).vanish(Admin.parameters.speed);
			Tabs.init();
			Admin.prettifyWidget();
		},

		refresh: function(field) {
			field.find(".numberfield").numericInput();
			field.find(".date").datepicker({
				'dateFormat': 'yy-mm-dd'
			});
			styleSelect.init(field);
			field.find(".stripe").layoutSelect();
			Upload.init(field);
		},

		prettifyWidget: function() {
			$(".widget").each(function() {
				if($(this).attr("id").indexOf("_thb_") != -1)
					$(this).addClass("thb");
			})
		}

	}
})(jQuery);

/**
 * ****************************************************************************
 * THB Linked fields
 * 
 * ****************************************************************************
 */
(function($) {
				
	LinkedFields = {
		parameters: {
			fieldClass: ".hb-row",
			dataSwitchAttr: "data-switch"
		},

		linkedFieldsStack: [],		
		init: function() {
			var fields = $(LinkedFields.parameters.fieldClass);
			fields.each(function() {
				var field = $(this);
				LinkedFields.selectChange(field);
			});
		},
		getLinkedFields: function(field) {
			var dataswitch = field.attr(LinkedFields.parameters.dataSwitchAttr);

			if( dataswitch == "" )
				return;

			var fieldsList = eval("("+dataswitch+")");
			var fields = [];
				
			if( fieldsList ) {
				for(f in fieldsList) {
					var i=0;
					if( f )
						i = f;
					
					var buildFields = "#" + themeprefix + fieldsList[i].replace(/,/g, ",#" + themeprefix);
					fields[i] = $(buildFields);
				}
			}
			
			return fields;
		},
		selectChange: function(field) {
			var select = field.find("select");
			select.change(function() {
				LinkedFields.linkedFieldsStack = [];
				LinkedFields.doAction(field);
			});
		},
		doAction: function(field, action) {
			if( !field )
				return;

			var val = field.find("select").val();
			var fields = LinkedFields.getLinkedFields(field);

			if( fields && fields[val] && fields[val].length > 0 && (action != 'close') ) {
				$.each(fields[val], function(index, field) {
					field = $(field);
					LinkedFields.linkedFieldsStack.push(field.attr("id"));
					LinkedFields.open(field);
				});
			}

			for(index in fields) {
				if( (action && action != 'close') || (!action && (index == val || $.inArray(fields[index].attr("id"), LinkedFields.linkedFieldsStack) != -1)) ) {
					continue;
				}
				LinkedFields.close( fields[index] );
			}
		},
		open: function(field) {
			if( !field )
				return;

			field
				.appear(Admin.parameters.speed);
			LinkedFields.doAction(field);
		},
		close: function(field) {
			if( !field )
				return;
				
			field
				.vanish(Admin.parameters.speed, { remove: false });
			LinkedFields.doAction(field, 'close');
		}
	}
})(jQuery);

/**
 * ****************************************************************************
 * THB Custom post types utils
 * 
 * ****************************************************************************
 */
(function($) {
	CustomPostTypes = {

		types: ["post", "page", "works", "events", "promotions", "testimonials", "staff"],

		init: function() {
			for(i=0; i<CustomPostTypes.types.length; i++) {
				$("#" + themeprefix + "_background").toggleMetabox(CustomPostTypes.types[i], "slideshow", 1);
			}
		}

	}
})(jQuery);

(function($) {
	$.fn.toggleMetabox = function(post_type, target, value) {
		return this.each(function() {
			var select_container = $(this);
			select_container.find("select").change(function() {
				var metabox = $("#metabox_" + post_type + "_" + target),
					open = !metabox.hasClass("closed");

				if( $(this).val() == value ) {
					if( !open ) {
						metabox.find(".handlediv").trigger("click");
						metabox.removeClass("closed");
					}
				} else {
					if( open ) {
						metabox.find(".handlediv").trigger("click");
						metabox.addClass("closed");
					}
				}
			}).trigger("change");
		});
	}
})(jQuery);

/**
 * ****************************************************************************
 * THB Javascript controller
 * 
 * ****************************************************************************
 */
var THB = {
	/*
		Getter
		Eg. THB.get(".selector")
	*/
	get: function(selector) {
		var element = selector;
		if(typeof(selector)=='string')
			element = jQuery(selector);
		return element;
	},
	
	/*
		Drawer
		Eg. THB.drawer("#contentbox", "a#trigger");
		Eg. THB.drawer("#contentbox", "a#trigger", { event: 'doubleclick' });
	*/
	drawer: function(content, trigger, parameters) {
		var params = {
			event: 'click',
			openClass: 'open',
			transition: 350,
			easing: 'linear'
		};
		jQuery.extend(params, parameters);
		
		var trigger_elements = THB.get(trigger);
		var content_elements = THB.get(content);
		content_elements.hide();

		trigger_elements.each(function(index, trigger_element) {
			jQuery(trigger_element).bind(params.event, function(evt) {
				var trigger_element = jQuery(this);
				var content_element = trigger_element.next(content);
				content_element.slideToggle(params.transition, params.easing);
				trigger_element.toggleClass(params.openClass);
				return false;
			});
		});
	},
	
	/*
		Remove
		Eg. THB.remove("#element_id", { delay: 0, transition: 500, easing: 'linear' });
	*/
	remove: function(selector, parameters) {
		var params = {
			transition: 350,
			easing: 'linear',
			delay: 0,
			callback: function() {}
		};
		jQuery.extend(params, parameters);
		
		var element = THB.get(selector);

		element
			.vanish(params.transition, { remove: true }, params.callback);
	},
	
	/*
		Scroller
		Eg. THB.scroll_to("#section_id");
		Eg. THB.scroll_to("#section_id", { transition: 500, easing: 'linear' });
	*/
	scroll_to: function(selector, parameters) {
		var params = {
			transition: 350,
			easing: 'linear',
			offset: 0
		};
		jQuery.extend(params, parameters);
		
		var element = THB.get(selector);
		var y = element.position().top + params.offset;
		jQuery('html, body').animate({scrollTop: y}, params.transition, params.easing);
		return false;
	}
};

/**
 * ****************************************************************************
 * THB Duplicable fields
 * 
 * Duplicable.init();
 * ****************************************************************************
 */
(function($) {

	Duplicable = {

		fields: null,

		findFields: function() {
			Duplicable.fields = $(".duplicable-section > .hb-row.duplicable");
		},

		init: function() {

			Duplicable.findFields();

			$(".duplicable-section").sortable({
				handle: '.move-duplicable-item',
				placeholder: 'ui-state-highlight',
				axis: 'y',
				opacity: 0.75,
				update: function(event, ui) {
					Duplicable.reorder();
				},
				start: function(event, ui) {
					$(this).addClass("dragging");
				},
				stop: function(event, ui) {
					$(this).removeClass("dragging");
				}
			});

			Duplicable.fields.each(function() {

				var field = $(this);
				Duplicable.attachEvents(field);

			});

			Duplicable.reorder();
			Duplicable.add();

		},

		attachEvents: function(field) {

			field
				.find(".remove-duplicable-item")
				.click(function() {
					field.vanish(250, { remove: true}, function() {
						Duplicable.reorder();
						Duplicable.findFields();
						if( Duplicable.fields.length == 0 )
							$(".infobox")
								.slideDown(Admin.parameters.speed);
					});

					return false;
				});

			if( field.hasClass("slide") ) {
				// Slide
				field
					.find("select")
					.change(function() {
						var value = $(this).val();
						Duplicable.Slide.init(value, field);
					})
					.trigger("change");
			}

		},

		reorder: function() {
			Duplicable.findFields();
			Duplicable.fields.each(function(index) {
				$(this).find(".order").val(index);
			});
		},

		add: function() {
			$(".add-btn")
				.click(function() {
					var infobox = $(".infobox");
					var template = $("#" + $(this).attr("data-template"));
					var newtmpl = template.tmpl({});

					newtmpl
						.css("display", "none")
						.insertBefore(template)
						.appear(Admin.parameters.speed);

					infobox
						.slideUp(Admin.parameters.speed);

					Admin.refresh(newtmpl);
					Duplicable.attachEvents(newtmpl);
					Duplicable.reorder();
					THB.scroll_to(newtmpl);

					return false;
				});
		},

		Slide: {

			init: function(value, field) {

				field.attr("data-slide-type", value);
				field
					.removeClass("slide-type-")
					.removeClass("slide-type-picture")
					.removeClass("slide-type-video")
					.addClass("slide-type-" + value);

			}

		}

	}

})(jQuery);

/**
 * ****************************************************************************
 * THB Tabs
 * 
 * Tabs.init();
 * ****************************************************************************
 */
(function($) {

	Tabs = {

		// Parameters
		parameters: {
			speed: Admin.parameters.speed,
			tabClass: ".hb-section",
			tabNavigationClass: ".hb-nav",
			activeTabClass: "active"
		},

		init: function( parameters ) {

			$.extend(Tabs.parameters, parameters);

			if( $(Tabs.parameters.tabNavigationClass).length == 0 )
				return;

			var navItems = $(Tabs.parameters.tabNavigationClass +" li");
			navItems.click(function() {

				if( $(this).hasClass(Tabs.parameters.activeTabClass) )
					return false;

				var tabs = $(Tabs.parameters.tabClass);
				// var currentTab = navItems.filter("." + Tabs.parameters.activeTabClass).find("a").attr("href");
		
				navItems.removeClass(Tabs.parameters.activeTabClass); 
				$(this).addClass(Tabs.parameters.activeTabClass); 

				var activeTab = $(this).find("a").attr("href");

				tabs.hide();
				$(activeTab).stop().fadeIn(Tabs.parameters.speed); 

				return false;
			});

		}

	}

})(jQuery);

/**
 * ****************************************************************************
 * THB Layout select
 * 
 * $(".stripe").layoutSelect();
 * ****************************************************************************
 */
(function($) {
	$.fn.layoutSelect = function() {
		return this.each(function() {
			var number = $(this).find(".columns-number"),
				layout = $(this).find(".columns-layout");

			var layouts = {
				"0": {},
				"1": { 
					"full": "Full" 
				},
				"2": { 
					"one-half,one-half": "1/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/2",
					"one-third,two-third": "1/3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2/3",
					"two-third,one-third": "2/3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/3",
					"one-fourth,three-fourth": "1/4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3/4",
					"three-fourth,one-fourth": "3/4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/4"
				},
				"3": { 
					"one-third,one-third,one-third": "1/3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/3",
					"one-half,one-fourth,one-fourth": "1/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/4",
					"one-fourth,one-half,one-fourth": "1/4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/4",
					"one-fourth,one-fourth,one-half": "1/4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/2"
				},
				"4": {
					"one-fourth,one-fourth,one-fourth,one-fourth": "1/4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1/4"
				}
			};

			number
				.change(function() {
					layout.children().remove();
					layout.prev("span").html("");

					var val = $(this).val();

					if( val == 0 )
						layout.parent(".select-wrapper").css("visibility", "hidden");
					else
						layout.parent(".select-wrapper").css("visibility", "visible");

					// Adding the options
					for( c in layouts[val] ) {
						var opt = $("<option value='"+c+"'>"+layouts[val][c]+"</option>");
						opt.appendTo(layout);
					}

					if( layout.attr("data-selected") != "" ) {
						layout.find("option").removeAttr("selected");
						layout.find("option[value='" + layout.attr("data-selected") + "']").attr("selected", "selected");
						layout.attr("data-selected", "");
					}

					layout.prev("span").html(layout.find("option:selected").text());
				})
				.trigger("change");
		});
	};
})(jQuery);

/**
 * ****************************************************************************
 * THB Button switch
 * 
 * $(".switch").switch();
 * ****************************************************************************
 */
(function($) {
	$.fn.switch = function(callback) {

		// Set the button class
		function setButtonClass(button, i) {
			if( i == 0 )
				button.removeClass("switch-on");
			else
				button.addClass("switch-on");
		}

		return this.each(function() {
			var button = $(this),
				name = button.attr("data-name"),
				value = button.attr("data-value"),
				values = button.attr("data-values").split(",");
			var hiddenValueField = $("<input type='hidden' name='"+name+"' />");
			
			button.after(hiddenValueField);

			this.i = $.inArray(value, values);

			if( value == "" ) {
				value = values[0];
				this.i = 0;
			}
			hiddenValueField.val(value);
			setButtonClass(button, this.i);

			if( callback ) {
				callback(values[this.i]);
			}
			
			button
				.click(function() {
					if( this.i == values.length - 1 )
						this.i = 0;
					else
						this.i++;
						
					hiddenValueField.val(values[this.i]);
					setButtonClass(button, this.i);

					if( callback ) {
						callback(values[this.i]);
					}

					return false;
				});
		});

	}
})(jQuery);

/*
function slideContent(){
	THB.drawer('.infobox-container', '.infobox-trigger', {
		transition: 250,
		openClass: 'active'
	});
}
*/

/*
	Set color
*/
function setColor(color, defaultcolor) {
	// Default color when no color is set for text, headline, link and hover elements
	if(defaultcolor === undefined)
		defaultcolor = "000000";

	return color != "" ? "#"+color : "#"+defaultcolor;
}

/*
	Set preview
*/
function setPreview(background) {

	// Preview
	var preview = background.find(".preview");
	var previewtext = preview.find(".text");
	var previewheadline = preview.find(".headline");
	var previewlink = preview.find("a.link");

	preview.css("background-repeat", "repeat");
	preview.find("a.link").click(function() {
		return false;
	});

	// Color text
	var colortext = background.find(".color-text input.color");
	colortext
		.change(function() {
			var color = jQuery(this).val();
			previewtext.css("color", setColor(color));
		})
		.trigger("change");
	
	// Color headline
	var colorheadline = background.find(".color-headline input.color");
	colorheadline
		.change(function() {
			var color = jQuery(this).val();
			previewheadline.css("color", setColor(color));
		})
		.trigger("change");

	// Color link
	var colorlink = background.find(".color-link input.color");
	colorlink
		.change(function() {
			var color = jQuery(this).val();
			previewlink.css("color", setColor(color));
		})
		.trigger("change");

	// Color hover
	var colorhover = background.find(".color-hover input.color");
	colorhover
		.change(function() {
			var color = jQuery(this).val();
			if(color == "") {
				previewlink
					.unbind("mouseenter")
					.unbind("mouseleave");
			} else {
				previewlink
					.mouseenter(function() {
						previewlink.css("color", setColor(color, colorlink.val()));
					})
					.mouseout(function() {
						previewlink.css("color", setColor(colorlink.val()));
					});
			}
		})
		.trigger("change");

	// Background color
	background.find(".backgroundcolor")
		.change(function() {
			var color = jQuery(this).val();
			var bgcolor = color != "" ? "#"+color : "transparent";
			preview.css("background-color", bgcolor);
		})
		.trigger("change");

	// Pattern
	background.find(".pattern")
		.change(function() {
			var image = jQuery(this).val();
			preview.css("background-image", "url("+image+")");
		})
		.trigger("change");
}

/*
	Background
*/
function background() {
	var backgrounds = jQuery(".background");
	backgrounds.each(function(i,e) {
		var background = jQuery(e);

		setPreview(background);
	});
}

/*
	Font
*/
function font() {
	var fonts = jQuery(".font");
	fonts.each(function(i,e) {
		var font = jQuery(e);
		var family = font.find("select.fontface");
		var preview = font.find(".fontpreview");
		var support = font.find(".support");

		// Family
		family.change(function() {
			var fam = jQuery(this).val();
			preview.attr("data-preview", fam);

			if( support.length > 0 ) {
				var sup = customfonts[fam].supports;
				support.html("Supports: normal");
				if(sup.length > 0)
					support.html("Supports: " + customfonts[fam].supports.join(", "));
			}
		})
		.trigger("change");
	});
}

function googleFont() {
	var fonts = jQuery(".googlefont");
	fonts.each(function() {
		var font = jQuery(this);
		var family = font.find("select.fontface");
		var size = font.find(".font-size input");
		var lineheight = font.find(".font-lineheight input");
		var weight = font.find(".weight-switchbutton");
		var style = font.find(".style-switchbutton");

		var preview = font.find(".fontpreview");

		// Family
		family.change(function() {
			var fam = jQuery(this).val();
			var famval = jQuery(this).find("option:selected").text();

			var fontLink = jQuery("<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family="+fam+":100,300,normal,italic,bold,bolditalic\">");
			font.find("link").remove();
			fontLink.appendTo(font);

			preview.css({
				'font-family': "'" + famval + "'"
			});
		});


		size.bind("numericInputChange", function() { 
			preview.css({'font-size': size.val() + "px"}) 
		});

		lineheight.bind("numericInputChange", function() { 
			preview.css({'line-height': lineheight.val() }) 
		});

		weight.switch(function(weight) { 
			preview.css({ 'font-weight': weight }); 
		});
		style.switch(function(style) { 
			preview.css({ 'font-style': style }) 
		});

		family.trigger("change");
		size.trigger("numericInputChange");
		lineheight.trigger("numericInputChange");
	});
}

/*
	Utilities
*/
function getParameterByName(name, myWindow)
{
	return getUrlParameter(name, myWindow.location.href);
}

function getUrlParameter(name, url)
{
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var results = regex.exec(url);
  if(results == null)
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

/**
 * ****************************************************************************
 * THB smooth appear
 * 
 * $(".myelement").appear(250);
 * ****************************************************************************
 */
 (function($) {
 	$.fn.appear = function(speed) {
 		return this.each(function() {
 			if( $(this).css("display") != "none" )
 				return;

 			$(this)
 				.css("opacity", 0)
 				.slideDown(speed, function() {
 					$(this)
 						.css("visibility", "visible")
 						.animate({ "opacity": 1 }, speed);
 				});
 		});
 	}
 })(jQuery);

/**
 * ****************************************************************************
 * THB vanish and remove element
 * 
 * $(".myelement").vanish(250);
 * ****************************************************************************
 */
(function($) {
	$.fn.vanish = function(speed, parameters, callback) {
		var params = {
			remove: true
		};
		$.extend(params, parameters);

		return this.each(function() {
			if( $(this).css("display") == "none" )
				return;

			$(this).animate({ "opacity": 0 }, speed, function() {
				$(this)
					.css("visibility", "hidden")
					.slideUp(speed, function() {
						if( params.remove ) 
							$(this).remove();
						if( callback )
							callback();
					});
			});
		});
	}
})(jQuery);

/**
 * ****************************************************************************
 * THB Upload
 * 
 * Upload.init(".hb-row.upload");
 * ****************************************************************************
 */
(function($) {

	Upload = {

		// Parameters
		parameters: {
			speed: Admin.parameters.speed,
			uploadButtonSelector: ".upload-btn",
			resetUploadButtonSelector: ".reset-upload-btn",
			valueSelector: ".image"
		},

		// Init
		init: function( selector, parameters ) {

			$.extend(Upload.parameters, parameters);

			var tb_show_temp = window.tb_show;
			window.tb_show = function() {
				tb_show_temp.apply(null, arguments);

				var iframe = jQuery('#TB_iframeContent');
				iframe.load(function() {
					var win = iframe[0].contentWindow;
					var $ = win.jQuery;

					if( $ == undefined )
						return;

					var post_id = getParameterByName("post_id", win);

					if( post_id == "0" ) {
						var hide = ["image_alt", "align", "post_title", "post_excerpt", "post_content"/*, "image-size"*/];
						var style = "";
						
						for( i=0; i<hide.length; i++ ) {
							hide[i] = "tr." + hide[i];
						}

						style = hide.join() + " { display: none; }";

						$("body").append('<style type="text/css">'+style+'</style>');

				    	/*
				    	$("td.field input").removeAttr("checked");
				    	$("td.field input[value='full']").attr("checked", "checked");
				    	$("form").submit(function() {
				    		$("td.field input").removeAttr("checked");
				    		$("td.field input[value='full']").attr("checked", "checked");
				    		return false;
				    	});
						*/
					}

				});
			}

			Upload.execute(selector);

		},

		// Execute
		execute: function( selector ) {

			var uploadFields = selector;

			if( typeof(selector) == 'string' )
				uploadFields = $(selector);

			uploadFields.each(function() {

				var uploadField = $(this),
					uploadLabel = uploadField.find("> label"),
					uploadButton = uploadField.find(Upload.parameters.uploadButtonSelector),
					resetUploadButton = uploadField.find(Upload.parameters.resetUploadButtonSelector),
					image = uploadField.find("img"),
					value = uploadField.find(Upload.parameters.valueSelector);

				// Upload button click
				uploadButton.live('click', function() {
					var text = '';
					if( uploadLabel.length > 0 )
						text = uploadLabel.text(); 
					
					window.send_to_editor = function(html) {
						html = "<div>" + html + "</div>";
						var src = $("img", html).attr("src");
						
						// When the upload is done and the image has been selected, valorize the fields
						value.val(src);

						image
							.attr("src", src)
							.fadeIn(Upload.parameters.speed);

						uploadButton
							.fadeOut(Upload.parameters.speed);

						resetUploadButton
							.delay(Upload.parameters.speed)
							.fadeIn(Upload.parameters.speed);

						tb_remove();
					}
					
					tb_show(text, 'media-upload.php?post_id=0&amp;title='+text+'&amp;TB_iframe=true');
					
					return false;
				});

				// Reset upload button click
				resetUploadButton.live('click', function() {
					image
						.fadeOut(Upload.parameters.speed, function() {
							image.attr("src", "");
						});

					resetUploadButton
						.fadeOut(Upload.parameters.speed);

					uploadButton
						.delay(Upload.parameters.speed)
						.fadeIn(Upload.parameters.speed);

					value.val("");

					return false;
				});

			});

		}

	}

})(jQuery);

/**
 * ****************************************************************************
 * THB Numeric input
 * 
 * $(".number").numericInput();
 * ****************************************************************************
 */
(function($) {
	$.fn.numericInput = function(callback) {
		return this.each(function() {
			var input = $(this);
			this.interval = 0;
			this.useKeys = true;

			// Set this to be a numeric field
			input.numeric();

			// If we have a callback, let's bind it!
			if( callback ) {
				input.bind("numericInputChange", callback);
			}
			
			// Retrieving data parameters
			var parameters = {};
			if( input.attr("data-min") ) 	parameters.min = input.attr("data-min");
			if( input.attr("data-max") ) 	parameters.max = input.attr("data-max");
			if( input.attr("data-step") ) 	parameters.step = input.attr("data-step");
			
			var settings = $.extend({
				min: 0,
				max: null,
				step: 1
			}, parameters);
			
			settings.type = 'integer';
			settings.decimal_figures = 0;
			
			if( settings.step.toString().indexOf(".") != -1 ) {
				settings.type = 'decimal';
				settings.decimal_figures = settings.step.split(".")[1].length;
			}

			this.process = function(action) {
				var value = $(this).val(),
					step = settings.step,
					max = settings.max,
					min = settings.min;

				if( value == "" )
					value = min;
				
				if( settings.type == 'integer' ) {
					value = parseInt(value);
					step = parseInt(step);
					max = parseInt(max);
					min = parseInt(min);
				}
				else {
					value = parseFloat(value);
					step = parseFloat(step);
					max = parseFloat(max);
					min = parseFloat(min);
				}
				
				if( action == 'increment' ) {
					if( max != NaN && value + step > max )
						value = max;
					else
						value += step;
				}
				else if( action == 'decrement' ) {
					if( min != NaN && value - step < min )
						value = min;
					else
						value -= step;
				}
				else {
					if( min != NaN && value < min )
						value = min;
					else if( max != NaN && value > max )
						value = max;
				}
				
				if( value.toFixed )
					value = value.toFixed(settings.decimal_figures);
				
				$(this).val(value);

				// Firing the callback
				$(this).trigger("numericInputChange");
			}
			
			this.increment = function() {
				this.process('increment');
			}
			
			this.decrement = function() {
				this.process('decrement');
			}

			input.blur(function() {
				this.process('type');
			});
			
			// Creating the hooks for increment and decrement
			var incrementButton = $("<span class='btn increment'>&plus;</span>");
			var decrementButton = $("<span class='btn decrement'>&minus;</span>");

			input
				.after(incrementButton);
			incrementButton.click(function() {
				input.get(0).increment();
				return false;
			});
				
			input
				.before(decrementButton);
			decrementButton.click(function() {
				input.get(0).decrement();
				return false;
			});

			this.clearIntervals = function() {
				clearInterval(this.interval);
				this.useKeys = true;
			}

			decrementButton.bind("mousedown", function() { return true; });
			decrementButton.bind("mouseup", function() { return true; });
			incrementButton.bind("mousedown", function() { return true; });
			incrementButton.bind("mouseup", function() { return true; });

			/*
			decrementButton.bind("mousedown", function() {
				if( input.get(0).useKeys == false ) {
					return false;
				};
				input.get(0).useKeys = false;

				input.get(0).interval = setInterval(function() {
					input.get(0).decrement();
				}, 125);

				return false;
			});

			incrementButton.bind("mousedown", function() {
				if( input.get(0).useKeys == false ) {
					return false;
				};
				input.get(0).useKeys = false;

				input.get(0).interval = setInterval(function() {
					input.get(0).increment();
				}, 125);

				return false;
			});

			decrementButton.mouseup(function() {
				input.get(0).clearIntervals();
			});

			incrementButton.mouseup(function() {
				input.get(0).clearIntervals();
			});

			decrementButton.mouseleave(function() {
				input.get(0).clearIntervals();
			});

			incrementButton.mouseleave(function() {
				input.get(0).clearIntervals();
			});
			*/

			input.keydown(function(e) {
				var key = e.which;
				
				if( key == 38 ) {
					incrementButton.trigger("click");
				}
				if( key == 40 ) {
					decrementButton.trigger("click");
				}
				if( key == 13 ) {
					this.process('type');
				}

				return true;
			});

			input.keyup(function() {
				this.clearIntervals();

				// Firing the callback
				$(this).trigger("numericInputChange");
			});
			
		});
	}
})(jQuery);

/**
 *
 * Style Select
 *
 * Replace Select text
 * Dependencies: jQuery
 *
 */
(function ($) {
	styleSelect = {
    	init: function (field) {

	    	var wrappers = $(".select-wrapper");
	    	if( field !== undefined )
	    		wrappers = field.find(".select-wrapper");

    		wrappers.each(function () {
        		$(this).prepend( '<span>' + $(this).find( '.thb-input option:selected').text() + '</span>' );
      		});
      		
      		$('select.thb-input').live( 'change', function () {
				$(this).prev( 'span').replaceWith( '<span>' + $(this).find( 'option:selected').text() + '</span>' );
			});

      		$('select.thb-input').bind($.browser.msie ? 'click' : 'change', function(event) {
				$(this).prev( 'span').replaceWith( '<span>' + $(this).find( 'option:selected').text() + '</span>' );
			}); 

		}
  	};
})(jQuery);


/*
 *
 * Copyright (c) 2006-2011 Sam Collett (http://www.texotela.co.uk)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 * 
 * Version 1.3.1
 * Demo: http://www.texotela.co.uk/code/jquery/numeric/
 *
 * Allows only valid characters to be entered into input boxes.
 * Note: fixes value when pasting via Ctrl+V, but not when using the mouse to paste
 *      side-effect: Ctrl+A does not work, though you can still use the mouse to select (or double-click to select all)
 *
 * @name     numeric
 * @param    config      { decimal : "." , negative : true }
 * @param    callback     A function that runs if the number is not valid (fires onblur)
 * @author   Sam Collett (http://www.texotela.co.uk)
 * @example  $(".numeric").numeric();
 * @example  $(".numeric").numeric(","); // use , as separater
 * @example  $(".numeric").numeric({ decimal : "," }); // use , as separator
 * @example  $(".numeric").numeric({ negative : false }); // do not allow negative values
 * @example  $(".numeric").numeric(null, callback); // use default values, pass on the 'callback' function
 *
 */
(function(a){a.fn.numeric=function(b,c){if(typeof b==="boolean"){b={decimal:b}}b=b||{};if(typeof b.negative=="undefined")b.negative=true;var d=b.decimal===false?"":b.decimal||".";var e=b.negative===true?true:false;var c=typeof c=="function"?c:function(){};return this.data("numeric.decimal",d).data("numeric.negative",e).data("numeric.callback",c).keypress(a.fn.numeric.keypress).keyup(a.fn.numeric.keyup).blur(a.fn.numeric.blur)};a.fn.numeric.keypress=function(b){var c=a.data(this,"numeric.decimal");var d=a.data(this,"numeric.negative");var e=b.charCode?b.charCode:b.keyCode?b.keyCode:0;if(e==13&&this.nodeName.toLowerCase()=="input"){return true}else if(e==13){return false}var f=false;if(b.ctrlKey&&e==97||b.ctrlKey&&e==65)return true;if(b.ctrlKey&&e==120||b.ctrlKey&&e==88)return true;if(b.ctrlKey&&e==99||b.ctrlKey&&e==67)return true;if(b.ctrlKey&&e==122||b.ctrlKey&&e==90)return true;if(b.ctrlKey&&e==118||b.ctrlKey&&e==86||b.shiftKey&&e==45)return true;if(e<48||e>57){var g=a(this).val();if(g.indexOf("-")!=0&&d&&e==45&&(g.length==0||a.fn.getSelectionStart(this)==0))return true;if(c&&e==c.charCodeAt(0)&&g.indexOf(c)!=-1){f=false}if(e!=8&&e!=9&&e!=13&&e!=35&&e!=36&&e!=37&&e!=39&&e!=46){f=false}else{if(typeof b.charCode!="undefined"){if(b.keyCode==b.which&&b.which!=0){f=true;if(b.which==46)f=false}else if(b.keyCode!=0&&b.charCode==0&&b.which==0){f=true}}}if(c&&e==c.charCodeAt(0)){if(g.indexOf(c)==-1){f=true}else{f=false}}}else{f=true}return f};a.fn.numeric.keyup=function(b){var c=a(this).value;if(c&&c.length>0){var d=a.fn.getSelectionStart(this);var e=a.data(this,"numeric.decimal");var f=a.data(this,"numeric.negative");if(e!=""){var g=c.indexOf(e);if(g==0){this.value="0"+c}if(g==1&&c.charAt(0)=="-"){this.value="-0"+c.substring(1)}c=this.value}var h=[0,1,2,3,4,5,6,7,8,9,"-",e];var i=c.length;for(var j=i-1;j>=0;j--){var k=c.charAt(j);if(j!=0&&k=="-"){c=c.substring(0,j)+c.substring(j+1)}else if(j==0&&!f&&k=="-"){c=c.substring(1)}var l=false;for(var m=0;m<h.length;m++){if(k==h[m]){l=true;break}}if(!l||k==" "){c=c.substring(0,j)+c.substring(j+1)}}var n=c.indexOf(e);if(n>0){for(var j=i-1;j>n;j--){var k=c.charAt(j);if(k==e){c=c.substring(0,j)+c.substring(j+1)}}}this.value=c;a.fn.setSelection(this,d)}};a.fn.numeric.blur=function(){var b=a.data(this,"numeric.decimal");var c=a.data(this,"numeric.callback");var d=this.value;if(d!=""){var e=new RegExp("^\\d+$|\\d*"+b+"\\d+");if(!e.exec(d)){c.apply(this)}}};a.fn.removeNumeric=function(){return this.data("numeric.decimal",null).data("numeric.negative",null).data("numeric.callback",null).unbind("keypress",a.fn.numeric.keypress).unbind("blur",a.fn.numeric.blur)};a.fn.getSelectionStart=function(a){if(a.createTextRange){var b=document.selection.createRange().duplicate();b.moveEnd("character",a.value.length);if(b.text=="")return a.value.length;return a.value.lastIndexOf(b.text)}else return a.selectionStart};a.fn.setSelection=function(a,b){if(typeof b=="number")b=[b,b];if(b&&b.constructor==Array&&b.length==2){if(a.createTextRange){var c=a.createTextRange();c.collapse(true);c.moveStart("character",b[0]);c.moveEnd("character",b[1]);c.select()}else if(a.setSelectionRange){a.focus();a.setSelectionRange(b[0],b[1])}}}})(jQuery)