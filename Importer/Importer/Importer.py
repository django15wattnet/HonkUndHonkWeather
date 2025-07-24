from requests import get
from Importer.Point import Point
from Importer.WeatherForecast import WeatherForecast
from json import dumps


class Importer(object):
	__uriTmpl = "https://api.open-meteo.com/v1/forecast?latitude={lat}&longitude={lon}&hourly=temperature_2m,relative_humidity_2m,cloud_cover,wind_speed_10m,rain,weather_code,wind_direction_10m,surface_pressure,precipitation_probability&models=best_match"
	
	def __init__(self, point: Point):
		self.__point = point
		self.__openMeteoData = self.__readForecastData()
		
		lstProps = list(self.__openMeteoData['hourly'].keys())
		lstUnits = list(self.__openMeteoData['hourly_units'].values())
		lstWeatherForecasts = []
		
		for idxTime in range(len(self.__openMeteoData['hourly']['time'])):
			lstWeatherForecasts.append(
				WeatherForecast.fromOpenMeteoHourlyData(
					idxTime=idxTime,
					openMeteoData=self.__openMeteoData
				)
			)
		
		print(dumps(lstWeatherForecasts))

	
	def __readForecastData(self) -> object:
		response = get(self.__uriTmpl.format(lat=self.__point.lat, lon=self.__point.lon))
		response.raise_for_status()  # Raise an error for bad responses
		return response.json()
