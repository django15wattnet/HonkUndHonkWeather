<div 
	class="forecastOuter" 
	data-idx="<?php print($this->idx); ?>"
	style="display: none"
>
	<div>
		<?php honkUndHonkWeatherPrDateLong($this->dt); ?>
	</div>
	<div>
		<?php print($this->forecastData->temperature_2m); ?>
		<?php print($this->forecastData->units->temperature_2m);?>
		<img 
			src="<?php print($this->wmoCode->getUrl($this->forecastData)); ?>" 
			alt="wmo code <?php print($this->forecastData->weather_code);?>"
		>
		<?php _e($this->wmoCode->getDescription($this->forecastData), 'honkUndHonkWeather'); ?>
	</div>
	<div>
		<?php _e('Regenwahrscheinlichkeit', 'honkUndHonkWeather'); ?>:
		<?php print($this->forecastData->precipitation_probability)?> %
	</div>
	<div>
		<?php _e('Luftdruck', 'honkUndHonkWeather'); ?>:
		<?php print($this->forecastData->surface_pressure); ?>
		<?php print($this->forecastData->units->surface_pressure);?>
	</div>
	<div>
		<?php _e('Luftfeuchtigkeit', 'honkUndHonkWeather'); ?>:
		<?php print($this->forecastData->relative_humidity_2m); ?><?php print($this->forecastData->units->relative_humidity_2m);?>
	</div>
</div>
	