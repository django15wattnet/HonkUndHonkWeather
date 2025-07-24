from os import listdir
from Importer.Point import Point


class DirList(object):
	
	def __init__(self, basePath: str = '/var/cache/HonkUndHonkWeather'):
		self.__basePath  = basePath
		self.__pointList = []
		self.__dirList   = []
		self.__readDataDirs()
		
	
	@property
	def basePath(self) -> str:
		return self.__basePath
	
	
	@property
	def dirList(self) -> list:
		return self.__dirList
	
	
	def __readDataDirs(self) -> list:
		for nameDir in listdir(self.__basePath):
			try:
				if nameDir.startswith('.'):
					continue
				
				self.__dirList.append(nameDir)
				self.__pointList.append(Point.fromString(pointStr=nameDir))
			except Exception as e:
				print(f"Error reading directory {nameDir}: {e}")
