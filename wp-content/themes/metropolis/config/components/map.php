<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<div 
	class="map" 
	data-height="<?php echo !isset($height) ? 240 : $height; ?>" 
	data-width="<?php echo !isset($width) ? 400 : $width; ?>" 
	data-latlong="<?php echo $latlong; ?>"
	data-zoom="<?php echo !isset($zoom) ? 10 : $zoom; ?>"
	data-address="<?php echo !isset($address) ? '' : $address; ?>"
></div>