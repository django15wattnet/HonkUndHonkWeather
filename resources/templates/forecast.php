<link rel="stylesheet" href="/wp-content/plugins/HonkUndHonkWeather/resources/css/styles.css">
<script type="text/javascript" src="/wp-content/plugins/HonkUndHonkWeather/resources/js/forecastPager.js"></script>
<div class="honkWeatherOuter">
	<h2>Die Honk &amp; Honk Wettervorhersage</h2>
	<div class="content">
    	<div class="direction back"></div>
    	<div class="list">
        	<?php 
        	   foreach($this->forecastRenderers as $forecastData) { 
        	       print($forecastData);
        	   }
            ?>	
        </div>
        <div class="direction next"></div>
	</div>
	
</div>
