import requests
import json
import re
import datetime
from pprint import pprint
class Menu(object):
	def __init__(self):
		self.data = None
		
		self.processed_food = []
	def getMenu(self,din_hall, date, breakfast_lunch_dinner):

		response = requests.get(
		'https://aspc.pomona.edu/api/menu/dining_hall/'+str(din_hall)+'/day/'+str(date)+'/meal/'+str(breakfast_lunch_dinner)+'?',
		params = {
			'auth_token': '774ced2c7165d750e70f699a9a4af6ca36ad5409'
		}
		)

		data = json.loads(response.text)
		list_food = data[0]['food_items']
		regex = re.compile('[^a-zA-Z ]')
		foodList= []
		for item in list_food:
			str_food = str(item)
			str_food = regex.sub('', str_food).lower()
			# self.processed_food.append(str_food)
			foodList.append(str_food)
		
		return foodList


def main():
	dayNum=datetime.datetime.today().weekday()
	day=""
	if(dayNum==0):
		day='mon'
	
	elif(dayNum==1):
		day='tue'
	
	elif(dayNum==2):
		day='wed'
	elif(dayNum==3):
		day='thu'
	
	elif(dayNum==4):
		day='fri'
	
	elif(dayNum==5):
		day='sat'
	
	elif(dayNum==6):
		day='sun'
	
	menu= Menu()
	frankBF=menu.getMenu('frank',day,'breakfast')
	frankLn=menu.getMenu('frank',day,'lunch')
	frankDn=menu.getMenu('frank',day,'dinner')

	fraryBF=menu.getMenu('frary',day,'breakfast')
	fraryLn=menu.getMenu('frary',day,'lunch')
	fraryDn=menu.getMenu('frary',day,'dinner')

	oldenborgLn=menu.getMenu('oldenborg',day,'lunch')

	cmcBF=menu.getMenu('cmc',day,'breakfast')
	cmcLn=menu.getMenu('cmc',day,'lunch')
	cmcDn=menu.getMenu('cmc',day,'dinner')

	muddBF=menu.getMenu('mudd',day,'breakfast')
	muddLn=menu.getMenu('mudd',day,'lunch')
	muddDn=menu.getMenu('mudd',day,'dinner')

	scrippsBF=menu.getMenu('scripps',day,'breakfast')
	scrippsLn=menu.getMenu('scripps',day,'lunch')
	scrippsDn=menu.getMenu('scripps',day,'dinner')

	allMenus= [[frankBF,frankLn,frankDn],
				[fraryBF,fraryLn,fraryDn],
				[oldenborgLn],
				[cmcBF,cmcLn,cmcDn],
				[muddBF,muddLn,muddDn],
				[scrippsBF,scrippsLn,scrippsDn]
				]
	pprint(allMenus)

if __name__=='__main__':
	main()

	
