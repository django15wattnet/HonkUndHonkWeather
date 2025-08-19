from datetime import datetime, timezone
from dateutil import tz
from json import dumps


class WeatherForecast(dict):
	lon: float
	lat: float
	dt: datetime
	tz: timezone
	temperature_2m: float
	relative_humidity_2m: float
	cloud_cover: float
	rain: float
	weather_code: int
	wind_direction_10m: float
	surface_pressure: float
	precipitation_probability: float
	
	
	@classmethod
	def fromOpenMeteoHourlyData(cls, idxTime: int, openMeteoData: dict) -> 'WeatherForecast':
		
		tzFrom = tz.gettz(openMeteoData['timezone'])
		tzTo = tz.gettz('Europe/Berlin')
		
		wf     = cls()
		wf.lat = openMeteoData['latitude']
		wf.lon = openMeteoData['longitude']
		wf.dt  = datetime.fromisoformat(openMeteoData['hourly']['time'][idxTime])
		wf.dt  = wf.dt.astimezone(tzTo)
		wf.tz  = tzFrom
		
		# Iteration over the forecast values
		for key in openMeteoData['hourly'].keys():
			if 'time' == key:
				continue
			
			setattr(wf, key, openMeteoData['hourly'][key][idxTime])
		
		return wf
	
	
	def toJson(self):
		return "".join([
			"{",
			f'"lat": {self.lat}, ',
			f'"lon": {self.lon}, ',
			f'"time": "{self.dt.isoformat()}", ',
			f'"tz": "{self.tz.tzname(self.dt)}", ',
			f'"temperature_2m": {self.temperature_2m}, ',
			f'"relative_humidity_2m": {self.relative_humidity_2m}, ',
			f'"cloud_cover": {self.cloud_cover}, ',
			f'"rain": {self.rain}, ',
			f'"weather_code": {self.weather_code}, ',
			f'"wind_direction_10m": {self.wind_direction_10m}, ',
			f'"surface_pressure": {self.surface_pressure}, ',
			f'"precipitation_probability": {self.precipitation_probability}',
			"}"
		])
	
	
	def __str__(self) -> str:
		return (f"WeatherForecast(lat={self.lat}, lon={self.lon}, dt={self.dt.isoformat()}, "
				f"tz={self.tz}, temperature_2m={self.temperature_2m}, "
				f"relative_humidity_2m={self.relative_humidity_2m}, cloud_cover={self.cloud_cover}, "
				f"rain={self.rain}, weather_code={self.weather_code}, "
				f"wind_direction_10m={self.wind_direction_10m}, surface_pressure={self.surface_pressure}, "
				f"precipitation_probability={self.precipitation_probability})")
