from pathlib import Path
from requests import get
from Importer.Point import Point
from Importer.WeatherForecast import WeatherForecast


class Importer(object):
	__uriTmpl = 'https://api.open-meteo.com/v1/forecast?latitude={lat}&longitude={lon}&hourly=temperature_2m,relative_humidity_2m,cloud_cover,wind_speed_10m,rain,weather_code,wind_direction_10m,surface_pressure,precipitation_probability&models=best_match'
	
	def __init__(self, point: Point):
		self.__dirCache = str(Path(__file__).parent.absolute()) + '/../../resources/data'
		self.__dirCache = str(Path(self.__dirCache).resolve())
		self.__point = point
		self.__openMeteoData = self.__readForecastData()
		self.__strJson = ''
		
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
			
		self.__strJson = '{"units":{'
		for idx, prop in enumerate(lstProps):
			self.__strJson += f'"{prop}":"{lstUnits[idx]}",'
		self.__strJson = self.__strJson.rstrip(',') + '}'
		
		self.__strJson += ', "forecasts":['
		for wf in lstWeatherForecasts:
			self.__strJson += wf.toJson() + ','
		self.__strJson = self.__strJson.rstrip(',') + ']}'
		

	@property
	def json(self) -> str:
		return self.__strJson
	
	
	def saveJson(self) -> str:
		filePath = f"{self.__dirCache}/{self.__point}"
		with open(filePath, 'w') as file:
			file.write(self.json)
		return filePath
		
	
	def __readForecastData(self) -> object:
		response = get(self.__uriTmpl.format(lat=self.__point.lat, lon=self.__point.lon))
		response.raise_for_status()  # Raise an error for bad responses
		return response.json()
