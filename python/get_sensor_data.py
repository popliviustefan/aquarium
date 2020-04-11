import sys
from modules.aquarium_file_io import file_read, file_read_int, C

l = []


def main():
    #same order in the js/details.js
    l.append(file_read(1, C.TANK_TEMP))
    l.append(file_read(1, C.ENV_TEMP))
    l.append(file_read(1, C.TANK_PH))
    l.append(file_read_int(1, C.TANK_FANS))
    l.append(file_read_int(1, C.TANK_AC))
    l.append(file_read_int(1, C.TANK_OVERFLOW))
    
    #print(l)
    for i in l: print (i, end=" ", flush=True)
    
if __name__ == '__main__':
    main()
