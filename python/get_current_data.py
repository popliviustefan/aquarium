#import sys
from modules.aquarium_file_io import file_read, file_read_int, C, file_read_raw

l = []

def append(form, key):
    l.append(key)
    if (form == 'int') : l.append(file_read_int(1, key))
    if (form == 'flt') : l.append(file_read(1, key))
    if (form == 'txt') : l.append(file_read_raw(1, key))


def main():
    append('int', C.SET_TEMP)  
    append('flt', C.TANK_TEMP)
    append('flt', C.ENV_TEMP)
    append('int', C.TANK_FANS)
    append('int', C.TANK_AC)
    append('flt', C.SET_PH)
    append('flt', C.TANK_PH)
    append('int', C.TANK_OVERFLOW)
    
    for i in range(1, 9):
        append('txt', C.LABEL_SOCKET_[i])
        append('int', C.SET_SOCKET_[i])
        append('int', C.TANK_SOCKET_[i])
        append('txt', C.SET_SOCKET_SCHEDULE_[i])

    #print ('|'.join(map(str,l)))
    print(l)
    #for i in l: print (i, sep="|", flush=True) # can be changed with other character delimiter
    #a = str("|").join(l)
    #print(a)

"""
    l.append(file_read_int(1, 'set_tank_temp'))
    l.append(file_read(1, 'set_ph'))
    l.append(file_read(1, 'aquarium_tank_temp'))
    l.append(file_read(1, 'aquarium_env_temp'))
    l.append(file_read(1, 'aquarium_ph'))
    l.append(file_read_int(1, 'aquarium_fans'))
    
    for i in range(1, 9):
        l.append(file_read_int(1, 'aquarium_socket_' + str(i) + '_status'))
        l.append(file_read_int(1, 'set_priza_' + str(i)))
        s = file_read_int(1, 'set_priza_' + str(i) + '_start')
        l.append(f"{s // 60:02d}:{s % 60:02d}")
        e = file_read_int(1, 'set_priza_' + str(i) + '_stop')
        l.append(f"{e // 60:02d}:{e % 60:02d}")
"""





if __name__ == '__main__':
    main()
