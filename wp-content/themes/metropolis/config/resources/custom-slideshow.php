<?php

/**
 * Setting the right MIME type
 */
header('Content-type: text/javascript');

$background_container_height = thb_get_option("_style_slideshow_height");

?>

var slide_index = 0;

$j(document).ready(function() {

	var body = $j("body");
	
	$j.fullBackground({
		speed: 350,
		height: <?php echo $background_container_height != "" ? $background_container_height : 700; ?>
	});

	var slides = $j("#background_slider").children(".slide");

	$j("#background_slider iframe").each(function() {
		var src = $j(this).attr('src');
		if( src != "" ) {
	        var wmode = "wmode=transparent";
	        if(src.indexOf('?') != -1) {
	            var getQString = src.split('?');
	            var oldString = getQString[1];
	            var newString = getQString[0];
	            $j(this).attr('src',newString+'?'+wmode+'&'+oldString);
	        }
	        else $j(this).attr('src',src+'?'+wmode);
		}
    });

    $j("#background_slider .slide_type_video").each(function() {
    	slide_index = $j(this).attr("data-index");
    	var id;

    	if( $j(this).find("div.youtube").length > 0 ) {

    		var ytcontainer = $j(this).find("div.youtube");

	    	id = ytcontainer.attr("id");
	    	var code = ytcontainer.attr("data-video");
	    	var params = { allowScriptAccess: "always" };
			var atts = { id: id };
			swfobject.embedSWF("http://www.youtube.com/v/"+code+"?enablejsapi=1&playerapiid=ytplayer&version=3&controls=0",
								id, "100%", "100%", "8", null, null, params, atts);

			var index = id.replace("player", "");
			addPlayPauseEvent(index, id);

    	} else {

    		var vmcontainer = $j(this).find("iframe.vimeo");
    		Froogaloop(vmcontainer.get(0)).addEvent('ready', function(player_id) {
    			froogaloop = Froogaloop(player_id);
    			var index = player_id.replace("player", "");
    			addPlayPauseEvent(index, player_id);
    		});

    	}

    	function addPlayPauseEvent(index, id) {
    		$j(".playpause[data-index="+index+"]").click(function() {
    			playpauseVideo(id, $j(this));
    			return false;
    		});
    	}

    	function playVideo(id, playPauseButton) {
    		$j("#" + id).prev("img").stop().animate({opacity: 0}, 350);
    		playPauseButton.html(playPauseButton.attr("data-text-pause"));
    		videoStatus = "paused";

    		if( document.getElementById(id) && document.getElementById(id).playVideo ) {
    			document.getElementById(id).playVideo();
    		}
    		else if( Froogaloop(id) !== undefined ) {
    			Froogaloop(id).api("play");
    		}
    	}

    	function pauseVideo(id, playPauseButton) {
    		$j("#" + id).prev("img").stop().animate({opacity: 1}, 350);
    		playPauseButton.html(playPauseButton.attr("data-text-play"));
    		videoStatus = "playing"

    		if( document.getElementById(id) && document.getElementById(id).playVideo ) {
    			document.getElementById(id).pauseVideo();
    		}
    		else if( Froogaloop(id) !== undefined ) {
    			Froogaloop(id).api("pause");
    		}
    	}

    	function playpauseVideo(id, playPauseButton) {
    		if( videoStatus == "playing" ) {
    			$j("#background_slider").cycle('pause');
    			playVideo(id, playPauseButton);
    		} else {
    			pauseVideo(id, playPauseButton);
    		}
	    }

	    $j(".bg-prev, .bg-next").click(function() {

	    	if( $j(".active_slide").hasClass("slide_type_video") ) {
	    		var index = $j(".active_slide").attr("data-index");
	    		pauseVideo("player" + index, $j(".playpause[data-index="+index+"]"));
	    		$j("#background_slider").cycle('resume');
	    	}

	    	return true;
		});
   	});

    // Vimeo

	if( slides.length == 1 ) {
		$j(".slide-box-caption .slide-overlay").css({ opacity : 1});
	} else {

	    <?php
	    	$timeout = thb_get_option("_slideshow_timeout");
	    	$transition = thb_get_option("_slideshow_transition_speed");
	    	$effect = thb_get_option("_slideshow_effects");

	    	if( empty($timeout) ) $timeout = 6;
	    	if( empty($transition) ) $transition = 2.5;
	    	if( empty($effect) ) $effect = 'fade';

	    	// Setting everything to be expressed in milliseconds
	    	$timeout *= 1000;
	    	$transition *= 1000;
	    ?>

	    function onBefore(currSlideElement, nextSlideElement, opts) { 
	    	var index = $j(currSlideElement).index();
	    	var nextCaption = $j(".slide-box-caption .slide-overlay-"+index);

	    	$j(currSlideElement).removeClass("active_slide");
	    	$j(nextSlideElement).addClass("active_slide");

	    	if( $j("body").hasClass("transitions") ) {
	    		nextCaption.removeClass("slide-in");
	    		nextCaption.addClass("slide-out");
	    	} else {
	    		$j(".slide-box-caption .slide-overlay").css({ opacity : 0});
	    		$j('.slide-overlay').stop().animate({ opacity : 0}, 350);
	    	}
	    }
	    
	    function onAfter(currSlideElement, nextSlideElement, opts) { 
	    	var index = $j(nextSlideElement).index();
	    	var nextCaption = $j(".slide-box-caption .slide-overlay-"+index);

	    	if( $j("body").hasClass("transitions") ) {
	    		nextCaption.addClass("slide-in");
	    		nextCaption.removeClass("slide-out");
	    	}
	    	else {
	    		$j(".slide-box-caption .slide-overlay").css({ opacity : 0});
	    		nextCaption.stop().animate({ opacity : 1}, 350);
	        }
	    }

	    var videoStatus = "playing";

		$j("#background_slider").cycle({
			fx: '<?php echo $effect; ?>',
			cleartypeNoBg: true,
			fit: true,
		    timeout: <?php echo $timeout; ?>,
			speed: <?php echo $transition; ?>,
		    pause: 0,
		    prev: $j(".bg-prev"),
		    next: $j(".bg-next"),
		    startingSlide: 0,
		    after: onAfter,
		    before: onBefore
		});
		
	}

});