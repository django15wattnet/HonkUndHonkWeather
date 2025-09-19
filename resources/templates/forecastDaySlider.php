<div class="forecastDaySliderOuter">
	<?php foreach ($this->arrDays as $day => $idx) { ?>
		<div data-show-idx="<?php print($idx); ?>">
			<?php print($day); ?>
		</div>
	<?php } ?>
</div>
