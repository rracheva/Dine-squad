import requests
import json
import re
import datetime
from pprint import pprint
import menu_analysis as score

class Menu(object):
	def __init__(self):
		self.data = None
		
		# get the menu using the dining hall,date and specific meal
	def getMenu(self,din_hall, date, breakfast_lunch_dinner):

		response = requests.get(
		'https://aspc.pomona.edu/api/menu/dining_hall/'+str(din_hall)+'/day/'+str(date)+'/meal/'+str(breakfast_lunch_dinner)+'?',
		params = {
			'auth_token': '774ced2c7165d750e70f699a9a4af6ca36ad5409'
		}
		)

		data = json.loads(response.text)
		foodList= []
		# when no data is obtained, dinnig hall is marked as closed
		if len(data)==0:
			foodList.append("closed")
			return foodList
		else:
			list_food = data[0]['food_items']
			regex = re.compile('[^a-zA-Z ]')
			
			for item in list_food:
				str_food = str(item)
				str_food = regex.sub('', str_food).lower()
				foodList.append(str_food)
			
			# a list of strings representing the menu
			return foodList


# split a menu list to single words to help score them
def split_list(lst):

	new_list = []

	for string in lst:
		new_list.append(string.split())

	final_list = []

	for new_lst in new_list:
		for i in new_lst:
			final_list.append(i)

	return final_list

def main():
	# get the day to run getMenu
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
	
	# menu
	menu= Menu()

	# get brunch and dinner data if its the weekend
	if day == 'sun' or day =='sat':

		# gets epecific meals 
		frankBr=menu.getMenu('frank',day,'brunch')
		frankDn=menu.getMenu('frank',day,'dinner')

		fraryBr=menu.getMenu('frary',day,'brunch')
		fraryDn=menu.getMenu('frary',day,'dinner')

		cmcBr=menu.getMenu('cmc',day,'brunch')
		cmcDn=menu.getMenu('cmc',day,'dinner')

		muddBr=menu.getMenu('mudd',day,'brunch')
		muddDn=menu.getMenu('mudd',day,'dinner')

		scrippsBr=menu.getMenu('scripps',day,'brunch')
		scrippsDn=menu.getMenu('scripps',day,'dinner')

		pitzerBr=menu.getMenu('pitzer',day,'brunch')
		pitzerDn=menu.getMenu('pitzer',day,'dinner')

		allMenus= {'frank':[frankBr,frankDn],
					'frary':[fraryBr,fraryDn],
					'cmc':[cmcBr,cmcDn],
					'mudd':[muddBr,muddDn],
					'scripps':[scrippsBr,scrippsDn],
					'pitzer' :  [pitzerBr,pitzerDn]
					}

		# cuisines
		cuisines = ["italian", "mexican", "greek", "thai", "korean"]
		
		# score the menus using the cuisines
		score.to_JSON("breakfast", cuisines, [split_list(frankBr), split_list(fraryBr), \
			split_list(cmcBr), split_list(pitzerBr), split_list(muddBr), split_list(scrippsBr)])
		score.to_JSON("lunch", cuisines, [split_list(frankBr), split_list(fraryBr), \
			split_list(cmcBr), split_list(pitzerBr), split_list(muddBr), split_list(scrippsBr)])
		score.to_JSON("dinner", cuisines, [split_list(frankDn), split_list(fraryDn), \
			split_list(cmcDn), split_list(pitzerDn), split_list(muddDn), \
			split_list(scrippsDn)])
		json_data=json.dumps(allMenus)

		# passes json object of all menus as a string to main.php
		pprint(json_data)



	else: 
		# gets breakfast/lunch/dinner if weekday
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

		pitzerBF=menu.getMenu('pitzer',day,'breakfast')
		pitzerLn=menu.getMenu('pitzer',day,'lunch')
		pitzerDn=menu.getMenu('pitzer',day,'dinner')



		allMenus= {'frank':[frankBF,frankLn,frankDn],
					'frary':[fraryBF,fraryLn,fraryDn],
					'oldenborg':[oldenborgLn],
					'cmc':[cmcBF,cmcLn,cmcDn],
					'mudd':[muddBF,muddLn,muddDn],
					'scripps':[scrippsBF,scrippsLn,scrippsDn],
					'pitzer' :  [pitzerBF,pitzerLn,pitzerDn]
					}


		cuisines = ["italian", "mexican", "greek", "thai", "korean"]
		score.to_JSON("breakfast", cuisines, [split_list(frankBF), split_list(fraryBF), \
			split_list(cmcBF), split_list(pitzerBF), split_list(muddBF), \
			split_list(scrippsBF)])
		score.to_JSON("lunch", cuisines, [split_list(frankLn), split_list(fraryLn), \
			split_list(cmcLn), split_list(pitzerLn), split_list(muddLn), \
			split_list(scrippsLn), split_list(oldenborgLn)])
		score.to_JSON("dinner", cuisines, [split_list(frankDn), split_list(fraryDn), \
			split_list(cmcDn), split_list(pitzerDn), split_list(muddDn), \
			split_list(scrippsDn)])

		json_data=json.dumps(allMenus)

		pprint(json_data)

if __name__=='__main__':
	main()

	
