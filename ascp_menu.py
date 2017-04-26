import requests
import json
import re
class Menu(object):
	def __init__(self):
		self.data = None
		
		self.processed_food = []
	def getMenu(self,din_hall, date, lunch_dinner):

		response = requests.get(
		'https://aspc.pomona.edu/api/menu/dining_hall/'+str(din_hall)+'/day/'+str(date)+'/meal/'+str(lunch_dinner)+'?',
		params = {
			'auth_token': '774ced2c7165d750e70f699a9a4af6ca36ad5409'
		}
		)

		data = json.loads(response.text)
		list_food = data[0]['food_items']
		regex = re.compile('[^a-zA-Z ]')
		for item in list_food:
			str_food = str(item)
			str_food = regex.sub('', str_food).lower()
			self.processed_food.append(str_food)
		

		print(type(self.processed_food[0]),self.processed_food[0])
		
		print(self.processed_food)
		return data
	def process_data(self):
		return 0

men = Menu()
men.getMenu('cmc','fri','dinner')
