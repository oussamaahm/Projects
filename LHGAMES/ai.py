from __future__ import print_function
from flask import Flask, request
from structs import *
import json
import numpy


app = Flask(__name__)

def create_action(action_type, target):
    actionContent = ActionContent(action_type, target.__dict__)
    return json.dumps(actionContent.__dict__)

def create_move_action(target):
    return create_action("MoveAction", target)

def create_attack_action(target):
    return create_action("AttackAction", target)

def create_collect_action(target):
    return create_action("CollectAction", target)

def create_steal_action(target):
    return create_action("StealAction", target)

def create_heal_action():
    return create_action("HealAction", "")

def create_purchase_action(item):
    return create_action("PurchaseAction", item)

def deserialize_map(serialized_map):
    """
    Fonction utilitaire pour comprendre la map
    """
    serialized_map = serialized_map[1:]
    rows = serialized_map.split('[')
    column = rows[0].split('{')
    deserialized_map = [[Tile() for x in range(40)] for y in range(40)]
    for i in range(len(rows) - 1):
        column = rows[i + 1].split('{')

        for j in range(len(column) - 1):
            infos = column[j + 1].split(',')
            end_index = infos[2].find('}')
            content = int(infos[0])
            x = int(infos[1])
            y = int(infos[2][:end_index])
            deserialized_map[i][j] = Tile(content, x, y)

    return deserialized_map

def bot():
    """
    Main de votre bot.
    """
    map_json = request.form["map"]

    # Player info

    encoded_map = map_json.encode()
    map_json = json.loads(encoded_map)
    p = map_json["Player"]
    print ("player:{}".format(p))
    pos = p["Position"]
    x = pos["X"]
    y = pos["Y"]
    house = p["HouseLocation"]
    player = Player(p["Health"], p["MaxHealth"], Point(x,y),
                    Point(house["X"], house["Y"]), p["Score"],
                    p["CarriedResources"], p["CarryingCapacity"])

    # Map
    serialized_map = map_json["CustomSerializedMap"]
    deserialized_map = deserialize_map(serialized_map)

    otherPlayers = []

    for players in map_json["OtherPlayers"]:
        player_info = players["Value"]
        p_pos = player_info["Position"]
        player_info = PlayerInfo(player_info["Health"],
                                     player_info["MaxHealth"],
                                     Point(p_pos["X"], p_pos["Y"]))

        otherPlayers.append(player_info)

    # jour a 10,10

    print(deserialized_map[10][10].Content)
    print(p["CarriedResources"])
    closestMin = closestMinerals(deserialized_map, x, y)
    closestH = closestHome(deserialized_map, x, y)

    showMap(deserialized_map)
    print("joueur", pos)
    print("Maison", closestH[0], closestH[1])
    print("mine", closestMin[0], closestMin[1])
    print("Score",p["Score"])


    if isFull(p["CarriedResources"] , p["CarryingCapacity"]) :
        print("home")
        if x == closestH[0] and y == closestH[1]:
            print("Deposit in home")
        else :
            coord = simpleGo(x, y, closestH[0], closestH[1])
            if tileIsWall(deserialized_map, coord[0], coord[1]):
                return create_attack_action(Point(coord[0], coord[1]))
            else:
                return create_move_action(Point(coord[0], coord[1]))

    elif (abs(x-closestMin[0]) + abs(y-closestMin[1]) == 1):
        print("mining")
        return create_collect_action(Point(closestMin[0], closestMin[1]))

    else :
        print("going mine")
        coord = simpleGo(x, y, closestMin[0], closestMin[1])
        if tileIsWall(deserialized_map, coord[0], coord[1]):
            return create_attack_action(Point(coord[0], coord[1]))
        else :
            return create_move_action(Point(coord[0], coord[1]))


    #return decision

tuiles = (".", "%", "M", "L", "R", "S", "P")

def tileIsWall (map,x,y):
    if tuiles[map[10 + x][10 + y].Content] == "%":
        return True
    return False



def isFull(carried, total) : # isFull(p["CarriedResources"] , p["CarryingCapacity"])
    if carried == total:
        return True
    else :
        return False



def simpleGo(xP,yP, x, y) :
    if abs(xP-x) > abs(yP-y) :
         if xP > x :
             return (xP-1, yP)
         else :
            return (xP + 1, yP)
    else :
        if yP > y :
           return (xP, yP - 1)

        else :
           return (xP, yP + 1)


def closestHome(map, x, y) :
    p = 10
    minerais = [(0,0)]
    minerais.pop(0)
    for i in range (0,20):
        for j in range (0,20) :
            if tuiles[map[i][j].Content] == "M" :
                minerais.append((i,j))

    minX = -1
    minY = -1
    minDistance = 1000
    for minerai in minerais :
        distance = math.sqrt((minerai[0] - 10) * (minerai[0] - 10) + (minerai[1] -  10) * (minerai[1] - 10))
        if distance < minDistance :
            minDistance = distance
            minX = minerai[0]
            minY = minerai[1]

    if minX == -1 or minY == -1:
        return (minX, minY)

    elif minX < 10 :
        minX = x + minX - p
    elif minX > 10 :
        minX = x + minX + p
    elif minX == 10:
        minX = x


    if minY < 10:
        minY = y + minY - p
    elif minY > 10:
        minY = y + minY + p
    elif minY == 10:
        minY = y
    return (minX, minY)

def closestMinerals(map, x, y) :
    p = 10
    minerais = [(0,0)]
    minerais.pop(0)
    for i in range (0,20):
        for j in range (0,20) :
            if tuiles[map[i][j].Content] == "R" :
                minerais.append((i,j))

    minX = -1
    minY = -1
    minDistance = 1000
    for minerai in minerais :
        distance = math.sqrt((minerai[0] - 10) * (minerai[0] - 10) + (minerai[1] -  10) * (minerai[1] - 10))
        if distance < minDistance :
            minDistance = distance
            minX = minerai[0]
            minY = minerai[1]

    if minX == -1 or minY == -1:
        return (minX, minY)
    elif minX > 10 :
        minX = x + minX - p
    elif minX > 10 :
        minX = x + minX + p
    elif minX == 10:
        minX = x


    if minY > 10:
        minY = y + minY - p
    elif minY < 10:
        minY = y + minY + p
    elif minY == 10:
        minY = y
    return (minX, minY)

def showMap(map) :
    for x in range(0,20) :
        for y in range (0,20) :
            print (tuiles[int(map[x][y].Content)], end='', )
        print("\n", end='')

@app.route("/", methods=["POST"])
def reponse():
    """
    Point d'entree appelle par le GameServer
    """
    return bot()

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=8080, debug=True)
