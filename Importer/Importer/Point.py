

class Point(object):
	def __init__(self, lon: float, lat: float):
		self.__lon = lon
		self.__lat = lat
	
	
	@property
	def lon(self) -> float:
		return self.__lon
	
	@property
	def lat(self) -> float:
		return self.__lat
	
	
	@staticmethod
	def fromString(pointStr: str) -> 'Point':
		lon, lat = map(float, pointStr.split('_'))
		return Point(lon = lon, lat = lat)
	
	
	def __str__(self) -> str:
		return f"{self.lon}_{self.lat}"
