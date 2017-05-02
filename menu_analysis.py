"""

MENU ANALYSIS PROGRAM

get_score(cuisine_file, menu): returns the score for a given 
cuisine and menu

to_JSON(meal, list_of_cuisines, list_of_menus): writes all of the cuisine
and menu score dictionaries to a JSON file, entitled meal+"data.json"

"""
import os
import numpy as np
import json

# global info

# change according to cuisine files
cuisines = {"italian": "italian.txt", "mexican": "mexican.txt", "greek": "greek.txt", "thai":"thai.txt", "korean":"korean.txt"}
# used to name things in JSON file
menus = ["frank", "frary", "collins", "pitzer", "mudd", "scripps", "oldenborg"]

def separate_words(file_name):
    """
    
    This function returns a list of all of the words in a document. 
    
    """
    
    file = open(file_name, 'r')

    all_words = []
    new_word_list = []
    
    for line in file:
        
        for char in line:
            
            if char.isalpha():
                
                new_word_list.append(str(char).lower())
                
            elif not char.isalpha() and len(new_word_list) > 0:
                
                all_words.append("".join(new_word_list))
                
                new_word_list = []

    all_words.append("".join(new_word_list))
                
    return list(all_words)
    
def count_all_words(file_name):
    """
    
    This function counts how many words are in the given file_name
    
    """

    return len(separate_words(file_name))
    

def count_same_words(cuisine_file, menu):
    """
    
    This function counts how many words are the same between the cuisine file
    and menu list. 
    
    """

    cuisine_list = separate_words(cuisine_file)
    
    same_word_count = 0
    
    for i in cuisine_list:
        for j in menu:
            if i == j:
                same_word_count += 1
                
    return same_word_count


def get_score(cuisine_file, menu):

    return float(count_same_words(cuisine_file, menu))/len(menu)


def to_JSON(meal, list_of_cuisines, list_of_menus):
    """
    Writes a dictionary of cuisines, scores per dining hall menu to a JSON file

    meal: string describing name of meal - "breakfast", "lunch", or "dinner"
    list_of_cuisines: list of cuisine names - ["italian", "mexican"]
    list_of_menus: list of menu lists - [["egg, bacon"], ["pancakes"], ...]
        order matters; should  be in this order:
                "frank", "frary", "collins", "pitzer", "mudd", "scripps", "oldenborg"

    """
    data = {}

    for cuisine in list_of_cuisines:
        cuisine_list = separate_words(cuisines[cuisine])

        scores = {}

        for i in range(len(list_of_menus)):

            scores[menus[i]] = get_score(cuisines[cuisine], list_of_menus[i])

        data[cuisine] = scores

    with open(meal+'data.json', 'w') as f:
       json.dump(data, f)

    return data


