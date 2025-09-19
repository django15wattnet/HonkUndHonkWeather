#!/usr/bin/python3

from pathlib import Path
from Importer.DirList import DirList
from Importer.Importer import Importer
from Importer.Point import Point

dirCache = str(Path(__file__).absolute()) + '/../../resources/data'
dirCache = str(Path(dirCache).resolve())

for nameFile in DirList(basePath=dirCache).dirList:
	parts = nameFile.split('_')
	point = Point(lat=float(parts[0]), lon=float(parts[1]))
	
	try:
		importer = Importer(point=point)
		filePath = importer.saveJson()
		print(f"Imported for {point}")
	except Exception as e:
		print(f"error: {e}")
