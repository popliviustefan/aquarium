#!usr/bin/python3

from time import sleep
import subprocess
#import os
import shutil


path = ["/var/www/html/aquarium/settings/", "/dev/shm/aquarium/"]

class C: #definitions copied from functions.php file 
    SET_TEMP = 'SET_TEMP'
    SET_PH = 'SET_PH'
    ENV_TEMP = 'ENV_TEMP'
    TANK_TEMP = 'TANK_TEMP'
    TANK_PH = 'TANK_PH'
    TANK_FANS = 'TANK_FANS'
    TANK_AC = 'TANK_AC'
    TANK_OVERFLOW = 'TANK_OVERFLOW'
    SET_SOCKET_ = ['0', 'SET_SOCKET_1', 'SET_SOCKET_2', 'SET_SOCKET_3', 'SET_SOCKET_4', 'SET_SOCKET_5', 'SET_SOCKET_6', 'SET_SOCKET_7', 'SET_SOCKET_8']
    SET_SOCKET_SCHEDULE_ = ['0', 'SET_SOCKET_SCHEDULE_1', 'SET_SOCKET_SCHEDULE_2', 'SET_SOCKET_SCHEDULE_3', 'SET_SOCKET_SCHEDULE_4', 'SET_SOCKET_SCHEDULE_5', 'SET_SOCKET_SCHEDULE_6', 'SET_SOCKET_SCHEDULE_7', 'SET_SOCKET_SCHEDULE_8']
    LABEL_SOCKET_ = ['0', 'LABEL_SOCKET_1', 'LABEL_SOCKET_2', 'LABEL_SOCKET_3', 'LABEL_SOCKET_4', 'LABEL_SOCKET_5', 'LABEL_SOCKET_6', 'LABEL_SOCKET_7', 'LABEL_SOCKET_8']
    TANK_SOCKET_ = ['0', 'TANK_SOCKET_1', 'TANK_SOCKET_2', 'TANK_SOCKET_3', 'TANK_SOCKET_4', 'TANK_SOCKET_5', 'TANK_SOCKET_6', 'TANK_SOCKET_7', 'TANK_SOCKET_8']


#def create_mem_dir():
#    shutil.rmtree('/dev/shm/aquarium', ignore_errors=True)
#    os.makedirs("/dev/shm/aquarium/")


def create_mem_dir():
    shutil.rmtree(path[1], ignore_errors=False)
    shutil.copytree(path[0], path[1])    
    subprocess.run(["sudo", "chown", "-R", "www-data:www-data", path[1]])
    #shutil.chown(path[1], "www-data", "www-data")  #- doesn't work because of privilegies
    
#def mem_dir_set_owner():
#    subprocess.run(["sudo", "chown", "-R", "www-data:www-data", "/dev/shm/aquarium"])

#def __ret_path(shm):
#    if (shm): return "/dev/shm/aquarium/"
#    else: return "/var/www/html/aquarium/settings/"

def __file_read(shm, file_name):
    try:
        #path = __ret_path(shm)
        f = open(path[shm] + file_name, "r")
        r = f.read()
        f.close()
    except:
        r = -1
    return r

def file_read_raw(shm, file_name):
    attempts_to_read = 0
    while (attempts_to_read < 3):
        r = __file_read(shm, file_name)
        if (r == -1):
            sleep(0.01)
            attempts_to_read += 1
            continue
        return r
    return -1

def file_read(shm, file_name):
    return (float)(file_read_raw(shm, file_name))

def file_read_int(shm, file_name):
    return (int) (file_read(shm, file_name))

def __file_write(shm, file_name, value):
    try:
        #path = __ret_path(shm)
        f = open(path[shm] + file_name, "w")
        f.write(str(value))
        f.close()
        return 0
    except IOError:
        return -1

def file_write(shm, file_name, value):
    attempts_to_write = 0
    while (attempts_to_write < 10):
        r = __file_write(shm, file_name, value)
        if (r == -1):
            sleep(0.01)
            attempts_to_write += 1
            continue
        return r
    return -1