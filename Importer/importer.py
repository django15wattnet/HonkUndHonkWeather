#!/usr/bin/python3

from Importer.Importer import Importer
from Importer.Point import Point
from Importer.WeatherForecast import WeatherForecast

urlApi = 'https://api.open-meteo.com/v1/forecast?latitude=51.961662&longitude=7.643496&hourly=temperature_2m,relative_humidity_2m,rain,weather_code,wind_speed_10m,wind_direction_10m,cloud_cover,surface_pressure'

wf = WeatherForecast()
importer = Importer(point=Point(lat=51.961662, lon=7.643496))
