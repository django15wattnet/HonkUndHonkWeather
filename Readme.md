# HonkUndHonkWeather
a Wordpress plugin to display weather information 
from open-meteo.com for any location worldwide.  
The forecast are updated every hour, by fetching data 
from open-meteo.com API.

## Features
- Display current weather conditions
- Show a 7-day weather forecast

## Requirements
1. PHP >= 8.2
2. Wordpress >= 6.0
3. Python >= 3.0
4. Unix-like operating system (Linux, MacOs, BSD, ...)

## Installation
1. Download the plugin [zip file](https://github.com/django15wattnet/HonkUndHonkWeather/blob/main/honkUndHonkWeather.zip?raw=true)
2. unzip it to your Wordpress plugins directory (/wp-content/plugins)
3. Activate the plugin through the 'Plugins' menu in WordPress

Or clone the [github repro](https://github.com/django15wattnet/HonkUndHonkWeather/tree/main)
to your Wordpress plugins directory

## Usage
Add a shortcode like this example to your post or page:
> [honkUndHonkWeather lon=50.72633 lat=1.603076 headline="Boulogne-sur-Mer"]

This first release can display only one forecast per post or page.

## Screenshots
![Desktop](https://github.com/django15wattnet/HonkUndHonkWeather/blob/main/desktop.png?raw=true)
___
![Mobile](https://github.com/django15wattnet/HonkUndHonkWeather/blob/main/mobile.png?raw=true)

## ToDos
- Localisation
- Styling options
- Use [Erik Flowers Weather Icons](https://erikflowers.github.io/weather-icons/)
