/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/
var shortcodesEd;
var shortcodesUrl;

(function() {
	tinymce.create('tinymce.plugins.shortcodes', {
		init : function(ed, url) {
			shortcodesEd = ed;
			shortcodesUrl = url;
		},
		createControl: function(n, cm) {
			
			switch (n) {
				case 'shortcodes':
					var c = cm.createMenuButton('shortcodes', {
						title : 'shortcodes',
						image : shortcodesUrl+'/icon.png',
						icons:false
				});

				c.onRenderMenu.add(function(c, m) {
					sub = m.addMenu({title : 'Typography'});

					sub.add({title : 'Header 1', onclick : function() {
						var str = '[h1]Header H1[/h1]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Header 2', onclick : function() {
						var str = '[h2]Header H2[/h2]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Header 3', onclick : function() {
						var str = '[h3]Header H3[/h3]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Header 4', onclick : function() {
						var str = '[h4]Header H4[/h4]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
				   
					sub.add({title : 'Header 5', onclick : function() {
						var str = '[h5]Header H5[/h5]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Medium text size', onclick : function() {
						var str = '[medium]Medium text size example[/medium]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Code', onclick : function() {
						var str = '[code]Preformatted code example[/code]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Cite', onclick : function() {
						var str = '[cite author="author name" link="authorsite.com"]2011[/cite]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Highlight', onclick : function() {
						var str = '[highlight]Highlighted text example[/highlight]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Acronym', onclick : function() {
						var str = '[acronym title="acronym description"]acronym[/acronym]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Abbreviation', onclick : function() {
						var str = '[abbr title="abbreviation description"]abbreviation[/abbr]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Deleted text', onclick : function() {
						var str = '[del]deleted text example[/del]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Widget icon', onclick : function() {
						var str = '[icon url=""]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub = m.addMenu({title : 'Utility'});
					
					sub.add({title : 'Divider element', onclick : function() {
						var str = '[divider]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Icon boxes', onclick : function() {
						var str = '[iconbox url="image url" iconsize="64" title="Title"]descriptive text[/iconbox]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Icon boxes centered', onclick : function() {
						var str = '[iconbox center url="image url" title="Title"]descriptive text[/iconbox]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub = m.addMenu({title : 'Drop caps'});

					sub.add({title : 'Colored', onclick : function() {
						var str = '[dropcap1]A[/dropcap1]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Colored custom', onclick : function() {
						var str = '[dropcap3 color="#ff0000"]A[/dropcap3]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Big letter', onclick : function() {
						var str = '[dropcap2]A[/dropcap2]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					m.addSeparator();

					sub = m.addMenu({title : 'Messages'});

					sub.add({title : 'Notice', onclick : function() {
						var str = '[message type="notice"]Your message[/message]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Error', onclick : function() {
						var str = '[message type="error"]Your message[/message]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Warning', onclick : function() {
						var str = '[message type="warning"]Your message[/message]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Success', onclick : function() {
						var str = '[message type="success"]Your message[/message]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Info', onclick : function() {
						var str = '[message type="info"]Your message[/message]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					m.addSeparator();
					
					m.add({title : "Pricing table", onclick : function() {
						var str = '[pricingtable cols="3"][plan color="" head_color="" title="Starter" price="FREE" price_tag="" button_url="http://www.google.com" button_text="sign up" button_color="grey"]<ul><li>feature 1</li><li>feature 2</li><li>feature 3</li></ul>[/plan][plan featured color="#5B7825" title="Premium" price="99" price_tag="USD" button_url="http://www.google.com" button_text="sign up" button_color="green"]<ul><li>feature 1</li><li>feature 2</li><li>feature 3</li></ul>[/plan][plan title="Ultimate" price="299" price_tag="USD" button_url="http://www.google.com" button_text="sign up" button_color="grey"]<ul><li>feature 1</li><li>feature 2</li><li>feature 3</li></ul>[/plan][/pricingtable]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					m.addSeparator();
					
					sub = m.addMenu({title : 'Small button'});
					
					sub.add({title : "Red", onclick : function() {
						var str = '[button-small color="red" link="www.google.com"]Small button Red[/button-small]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Blue", onclick : function() {
						var str = '[button-small color="blue" link="www.google.com"]Small button Blue[/button-small]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Green", onclick : function() {
						var str = '[button-small color="green" link="www.google.com"]Small button Green[/button-small]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Yellow", onclick : function() {
						var str = '[button-small color="yellow" link="www.google.com"]Small button Yellow[/button-small]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Brown", onclick : function() {
						var str = '[button-small color="brown" link="www.google.com"]Small button Brown[/button-small]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Purple", onclick : function() {
						var str = '[button-small color="purple" link="www.google.com"]Small button Purple[/button-small]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Graphite", onclick : function() {
						var str = '[button-small color="graphite" link="www.google.com"]Small button Graphite[/button-small]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Grey", onclick : function() {
						var str = '[button-small color="grey" link="www.google.com"]Small button Grey[/button-small]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
							   
					sub = m.addMenu({title : 'Medium button'});

					sub.add({title : "Red", onclick : function() {
						var str = '[button-medium color="red" link="www.google.com"]Medium button Red[/button-medium]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Blue", onclick : function() {
						var str = '[button-medium color="blue" link="www.google.com"]Medium button Blue[/button-medium]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Green", onclick : function() {
						var str = '[button-medium color="green" link="www.google.com"]Medium button Green[/button-medium]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Yellow", onclick : function() {
						var str = '[button-medium color="yellow" link="www.google.com"]Medium button Yellow[/button-medium]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Brown", onclick : function() {
						var str = '[button-medium color="brown" link="www.google.com"]Medium button Brown[/button-medium]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Purple", onclick : function() {
						var str = '[button-medium color="purple" link="www.google.com"]Medium button Purple[/button-medium]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Graphite", onclick : function() {
						var str = '[button-medium color="graphite" link="www.google.com"]Medium button Graphite[/button-medium]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Grey", onclick : function() {
						var str = '[button-medium color="grey" link="www.google.com"]Medium button Grey[/button-medium]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub = m.addMenu({title : 'Large button'});
					
					sub.add({title : "Red", onclick : function() {
						var str = '[button-large color="red" link="www.google.com"]Large button Red[/button-large]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Blue", onclick : function() {
						var str = '[button-large color="blue" link="www.google.com"]Large button Blue[/button-large]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Green", onclick : function() {
						var str = '[button-large color="green" link="www.google.com"]Large button Green[/button-large]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Yellow", onclick : function() {
						var str = '[button-large color="yellow" link="www.google.com"]Large button Yellow[/button-large]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Brown", onclick : function() {
						var str = '[button-large color="brown" link="www.google.com"]Large button Brown[/button-large]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Purple", onclick : function() {
						var str = '[button-large color="purple" link="www.google.com"]Large button Purple[/button-large]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Graphite", onclick : function() {
						var str = '[button-large color="graphite" link="www.google.com"]Large button Graphite[/button-large]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : "Grey", onclick : function() {
						var str = '[button-large color="grey" link="www.google.com"]Large button Grey[/button-large]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					m.add({title : "Custom color button", onclick : function() {
						var str = '[button-custom color="#5E80A6" link="www.google.com"]Button with custom color[/button-custom]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					m.addSeparator();

					sub = m.addMenu({title : 'Columns'});
					
					sub.add({title : 'Third', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					
					sub.add({title : 'One third', onclick : function() {
						var str = '[one-third]Your content here[/one-third]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Two third', onclick : function() {
						var str = '[two-third]Your content here[/two-third]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Fourth', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					
					sub.add({title : 'One Fourh', onclick : function() {
						var str = '[one-fourth]Your content here[/one-fourth]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Two Fourh', onclick : function() {
						var str = '[two-fourth]Your content here[/two-fourth]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Three Fourh', onclick : function() {
						var str = '[three-fourth]Your content here[/three-fourth]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Fifth', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					
					sub.add({title : 'One Fifth', onclick : function() {
						var str = '[one-fifth]Your content here[/one-fifth]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Two Fifth', onclick : function() {
						var str = '[two-fifth]Your content here[/two-fifth]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Three Fifth', onclick : function() {
						var str = '[three-fifth]Your content here[/three-fifth]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					sub.add({title : 'Four Fifth', onclick : function() {
						var str = '[four-fifth]Your content here[/four-fifth]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Full width', onclick : function() {
						var str = '[full]Your content here[/full]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					m.addSeparator();

					sub = m.addMenu({title : 'Tabs'});
					
					sub.add({title : 'Tab container', onclick : function() {
						var str = '[tabs][tab title="The title of your tab"]Content of the tab[/tab] [tab title="The title of your tab 2"]Content of the tab 2[/tab][/tabs]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub.add({title : 'Single tab', onclick : function() {
						var str = '[tab title="The title of your tab"]Content of the tab[/tab]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});

					sub = m.addMenu({title : 'Accordion'});
					
					sub.add({title : 'Accordion', onclick : function() {
						var str = '[accordion_container][accordion title="Title example"]Content of accordion[/accordion] [accordion title="Title example 2"]Content of accordion 2[/accordion][/accordion_container]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					
					/*
					sub.add({title : 'Nested accordion', onclick : function() {
						var str = '[accordion-container][nested-accordion title="Title example"]Content of accordion[/nested-accordion][nested-accordion title="Title example 2"]Content of accordion 2[/nested-accordion][accordion-container]';
						window.tinyMCE.activeEditor.selection.setContent(str);
					}});
					*/
					
					m.add({title : 'Toggle item', onclick : function() {
						var str = '[toggle title="Title example"]Content of your toggle[/toggle]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});
					
					m.addSeparator();
					
					m.add({title : 'Youtube/Vimeo video', onclick : function() {
						var str = '[video id="Insert the video URL here"]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});

					m.addSeparator();

					sub = m.addMenu({title : 'Widgets'});

					sub.add({title : 'Page', onclick : function() {
						var str = '[thb_page id="2"]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});

					sub.add({title : 'Latest posts', onclick : function() {
						var str = '[thb_latest_posts numposts="3" showthumb="1"]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});

					sub.add({title : 'Popular posts', onclick : function() {
						var str = '[thb_popular_posts title="" numposts="3" showthumb="1"]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});

					sub.add({title : 'Posts from a category', onclick : function() {
						var str = '[thb_category_posts title="" numposts="3" showthumb="1" cat="2"]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});

					sub.add({title : 'Latest works', onclick : function() {
						var str = '[thb_latest_works numposts="3" showthumb="1"]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});

					sub.add({title : 'Twitter', onclick : function() {
						var str = '[thb_twitter twitter_id="thehappybit" twitter_count="3"]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});

					sub.add({title : 'Flickr', onclick : function() {
						var str = '[thb_flickr flickr_id="Your flickr ID (via idGettr)" flickr_count="3"]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});

					sub.add({title : 'Social', onclick : function() {
						var str = '[thb_social]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});

					sub.add({title : 'Map', onclick : function() {
						var str = '[thb_map title="" latlong="10,10" zoom="10", height="200" width="300"]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});

					sub.add({title : 'Contact infos', onclick : function() {
						var str = '[thb_contact]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});

					sub.add({title : 'Testimonials', onclick : function() {
						var str = '[thb_testimonials id="" items="3" style="1" title=""]';
						window.tinyMCE.activeEditor.selection.setContent(str);	
					}});
					
				});

				// Return the new splitbutton instance
				return c;
			}
			return null;
		}
	});
	tinymce.PluginManager.add('shortcodes', tinymce.plugins.shortcodes);

})();