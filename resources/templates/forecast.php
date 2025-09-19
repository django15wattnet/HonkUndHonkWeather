<link rel="stylesheet" href="/wp-content/plugins/HonkUndHonkWeather/resources/css/styles.css">
<script type="text/javascript" src="/wp-content/plugins/HonkUndHonkWeather/resources/js/forecastPager.js"></script>
<div class="honkWeatherOuter">
	<?php if ('' !== $this->shortCode->headline) {?>
		<h3>
			<a 
				href="https://www.openstreetmap.org/?#map=15/<?php print($this->shortCode->lon) ?>/<?php print($this->shortCode->lat) ?>"
				target="_blank"
			>
				<?php print($this->shortCode->headline); ?>
			</a>
		</h3>
	<?php } ?>
	
	<?php print($this->forecastDaySlider); ?>
	
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
