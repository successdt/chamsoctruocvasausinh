/* =========================================================
 * params/all.js v0.0.1
 * =========================================================
 * Copyright 2012 Wpbakery
 *
 * Visual composer javascript functions to enable fields.
 * This script loads with settings form.
 * ========================================================= */

var wpb_change_tab_title, wpb_change_accordion_tab_title;

 !function($) {
    wpb_change_tab_title = function($element, field) {
        $('.tabs_controls a[href=#tab-' + $(field).val() +']').text($('.wpb-edit-form [name=title].wpb_vc_param_value').val());
    }
     wpb_change_accordion_tab_title = function($element, field) {
         var $section_title = $element.prev();
         $section_title.find('a').text($(field).val());
     }

    function init_textarea_html($element) {
        /*
         Simple version without all this buttons from Wordpress
         tinyMCE.init({
         mode : "textareas",
         theme: 'advanced',
         editor_selector: $element.attr('name') + '_tinymce'
         });
         */
        window.wpActiveEditor = false;
        var textfield_id = $element.attr("id"),
            wpautop = false;
        $element.closest('.edit_form_line').find('.wp-switch-editor').removeAttr("onclick");
        $element.closest('.edit_form_line').find('.switch-tmce').click(function () {
            $element.closest('.edit_form_line').find('.wp-editor-wrap').removeClass('html-active').addClass('tmce-active');
            if(wpautop) {
                var val = window.switchEditors.wpautop($(this).closest('.edit_form_line').find("textarea.visual_composer_tinymce").val());
                $("textarea.visual_composer_tinymce").val(val);
            }
            // Add tinymce
            window.tinyMCE.execCommand("mceAddControl", true, textfield_id);
        });

        $element.closest('.edit_form_line').find('.switch-html').click(function () {
            $element.closest('.edit_form_line').find('.wp-editor-wrap').removeClass('tmce-active').addClass('html-active');
            window.tinyMCE.execCommand("mceRemoveControl", true, textfield_id);
        });

        $('#wpb_tinymce_content-html').trigger('click');
        $('#wpb_tinymce_content-tmce').trigger('click'); // Fix hidden toolbar
        wpautop = true;
    }
    $('#wpb-elements-list-modal .textarea_html').each(function(){
        init_textarea_html($(this));
    });

    $('#wpb-elements-list-modal .vc-color-picker-block').each(function(){
        var $this = $(this),
            $block = $(this).closest('.color-group'),
            $color_input = $block.find('.colorpicker_field'),
            color = $color_input.val();
        $this.data('color_input', $color_input);
        $color_input.data('color_picker', $(this).farbtastic(function (color) {
            $color_input.val(color).css({
                backgroundColor:color,
                color:this.hsl[2] > 0.5 ? '#000' : '#fff'
            });
        }));
        if(color.length=='7') {
            var f = new jQuery._farbtastic();
            $color_input.css({
                backgroundColor:color,
                color:f.RGBToHSL(color)[2] > 0.5 ? '#000' : '#fff'
            });
        }
        $.farbtastic(this).setColor($color_input.val());
        $color_input.data('color_picker').hide();
        $color_input.focus(
         function () {
             var pos = $color_input.offset();
             if(pos.top-$('body').scrollTop()>300) {
                 $color_input.data('color_picker').removeClass('bottom');
             } else {
                 $color_input.data('color_picker').addClass('bottom');

             }
             $color_input.data('color_picker').show();
         }).blur(function () {
             $color_input.data('color_picker').hide();
         });

    });

	//additemlist button
	$("#wpb_visual_composer .additembutton").click(function(){
		var listitemwindow = $(this).parent().parent().next().find(".listitemwindow");
		listitemwindow.css({
			"display": "block",
			"top": "220px"
		});
		listitemwindow.find("[name='item_type']").val("items");
		listitemwindow.find("[name='item_value'], [name='item_content'], [name='item_url'], [name='item_content_color'], [name='item_value_color'], [name='item_border_color']").val("");
	});
	$(".cancel-item-options").click(function(event){
		event.preventDefault();
		$(".listitemwindow").css("display", "none");
	});
	$("#add-item-shortcode").click(function(event){
		event.preventDefault();
		var editor = window.tinyMCE.get('wpb_tinymce_content');
		var currentContent = editor.getContent();
		var text_color = $("[name='additemwindow'] [name='item_content_color']").val();
		var value_color = $("[name='additemwindow'] [name='item_value_color']").val();
		var border_color = $("[name='additemwindow'] [name='item_border_color']").val();
		var item = '[item type="' + $("[name='additemwindow'] [name='item_type']").val() + '" value="' + $("[name='additemwindow'] [name='item_value']").val() + '" url="' + $("[name='additemwindow'] [name='item_url']").val() + '" url_target="' + $("[name='additemwindow'] [name='item_url_target']").val() + '" icon="' + $("[name='additemwindow'] [name='item_icon']").val() + '"' + (text_color!="" ? ' text_color="' + text_color + '"' : '') + (value_color!="" ? ' value_color="' + value_color + '"' : '') + (border_color!="" ? ' border_color="' + border_color + '"' : '') + ']' + $("[name='additemwindow'] [name='item_content']").val() + '[/item]';
		editor.setContent(currentContent+item);
		$(".listitemwindow").css("display", "none");
	});
	//small slider show/hide images dependency fields
	$(".gallery_widget_attached_images_ids").change(function(){
		var val_split = $(this).val().split(",");
		var count = 0;
		if(parseInt(val_split[0]))
			count = val_split.length;
		$("[data-dependency='images']").css("display", "none");
		var multipler = ($(this).hasClass("carousel_images") ? 5 : ($(this).hasClass("slider_images") ? 3 : 4));
		if(count)
		{
			for(var i=0; i<count*multipler; i++)
				$("[data-dependency='images']:eq("+i+")").css("display", "block");
			$("[data-dependency='images']:last").css("display", "block");
		}
		
	});
	setTimeout(function(){
		$(".gallery_widget_attached_images_ids").trigger("change");
	}, 1);
	//testimonials
	$(".wpb_bootstrap_modals [name^='testimonials_title'], .wpb_bootstrap_modals [name^='testimonials_author']").parent().parent().css("display", "none");
	$(".wpb_bootstrap_modals [name='testimonials_count']").change(function(){
		var self = $(this);
		$(".wpb_bootstrap_modals [name^='testimonials_title'], .wpb_bootstrap_modals [name^='testimonials_author']").parent().parent().css("display", "none");
		self.parent().parent().nextUntil('', ':lt(' + (self.val()*2) + ')').css("display", "block");
	});
	setTimeout(function(){
		$("[name='testimonials_count']").trigger("change");
	}, 1);

}(window.jQuery);