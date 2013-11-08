<?php
/*
	Author: The Happy Bit
	Author URI: http://thehappybit.com
	License: GNU General Public License version 3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	Version: 1.0
*/
?>
<style type="text/css">
	.debug {
		position: fixed !important;
		z-index: 100 !important;
		background-color: rgba(0, 255, 255, 0.2);
		left: 50%;
		margin-left: -480px;
		height: 100%;
	}
	
	.debug .col {
		height: 6%;
		margin-bottom: 2.333333333%;
		background-color: rgba(255, 0, 0, 0.3);
	}
	.control {
		display: block;
		position: fixed;
		left: 0;
		top: 50px;
		background-color: #fff;
		padding: 5px 20px;
		z-index: 100000;
		color: #000;
	}

	.hide {
		display: none;
	}

	@media only screen and (min-width: 768px) and (max-width: 959px), (device-width: 768px) {
		.debug {
			margin-left: -384px;
		}
	}

	@media only screen and (max-width: 767px) {
		.debug {
			left: 0;
			margin-left: 0;
		}
	}
</style>

<script type="text/javascript">
	$j(document).ready(function() {
		$j('.control').click(function() {
			$j('.debug').toggleClass('hide');
		});
	});
</script>

<a href="#" class="control">hide/show grid</a>

<div class="extended-container debug">
	<div class="col span-1"></div>
	<div class="col span-1"></div>
	<div class="col span-1"></div>
	<div class="col span-1"></div>
	<div class="col span-1"></div>
	<div class="col span-1"></div>
	<div class="col span-1"></div>
	<div class="col span-1"></div>
	<div class="col span-1"></div>
	<div class="col span-1"></div>
	<div class="col span-1"></div>
	<div class="col span-1"></div>

	<div class="col span-2"></div>
	<div class="col span-2"></div>
	<div class="col span-2"></div>
	<div class="col span-2"></div>
	<div class="col span-2"></div>
	<div class="col span-2"></div>

	<div class="col span-3"></div>
	<div class="col span-3"></div>
	<div class="col span-3"></div>
	<div class="col span-3"></div>

	<div class="col span-4"></div>
	<div class="col span-4"></div>
	<div class="col span-4"></div>

	<div class="col span-5"></div>
	<div class="col span-5"></div>
	<div class="col span-2"></div>

	<div class="col span-6"></div>
	<div class="col span-6"></div>

	<div class="col span-7"></div>
	<div class="col span-5"></div>

	<div class="col span-8"></div>
	<div class="col span-4"></div>

	<div class="col span-9"></div>
	<div class="col span-3"></div>

	<div class="col span-10"></div>
	<div class="col span-2"></div>

	<div class="col span-11"></div>
	<div class="col span-1"></div>

	<div class="col span-12"></div>
</div>