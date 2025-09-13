<div 
	class="forecastOuter" 
	data-idx="<?php print($this->idx); ?>"
	style="display: none"
>
	<div>
		<?php print($this->dt->format('l, j. F Y H:i')); ?>
	</div>
	<div>
		<?php print($this->forecastData->temperature_2m); ?>
		<?php print($this->forecastData->units->temperature_2m);?>
		<img 
			src="<?php print($this->wmoCode->getUrl($this->forecastData)); ?>" 
			alt="wmo code <?php print($this->forecastData->weather_code);?>"
		>
		<?php print($this->wmoCode->getDescription($this->forecastData)); ?>
	</div>
	<div>
		Regenwahrscheinlichkeit:
		<?php print($this->forecastData->precipitation_probability)?> %
	</div>
	<div>
		Luftdruck:
		<?php print($this->forecastData->surface_pressure); ?>
		<?php print($this->forecastData->units->surface_pressure);?>
	</div>
	<div>
		Luftfeuchtigkeit:
		<?php print($this->forecastData->relative_humidity_2m); ?><?php print($this->forecastData->units->relative_humidity_2m);?>
	</div>


	<?php /*
    <table>
    	<tbody>
    		<?php foreach ($this->forecastData->getPropertiesNames() as $prop) { ?>
    			<tr>
    				<th><?php print($prop); ?></th>
    				<td><?php print($this->forecastData->$prop); ?></td>
    				<td><?php
        					try {
        					   print($this->forecastData->units->$prop);
        					} catch (Exception) {
        					    ;
        					}
    				   ?></td>
    			</tr>
    			<?php } ?>
    	</tbody>
    </table>
    */ ?>
</div>
	