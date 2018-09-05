import json
import csv
import random

def generate():
    x = random.randint(1,81)
    if x > 60:
        return 0
    else:
        return x


name = []
longitude = []
latitude = []
status = []
genre = []
rate = []
time = []
with open('Places.csv', newline='', encoding='ISO-8859-1') as csvfile:
    spamreader = csv.reader(csvfile, delimiter=',', quotechar='|')
    for row in spamreader:
        name += [row[0]]
        longitude += [row[3]]
        latitude += [row[4]]
        status += [row[5]]
        genre += [row[6]]
        rate += [row[12]]
        time += [str(generate())]
        if time[-1] != 0: status[-1] = 0


data = {'name' : name,
        'longitude': longitude,
        'latitude': latitude,
        'status': status,
        'genre': genre,
        'rate': rate,
        'time': time}

with open('data.json', 'w') as f:
    json.dump(data, f)

