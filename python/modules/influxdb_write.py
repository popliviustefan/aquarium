#!usr/bin/python3

import requests

def __send_request(data):
    params = (
        ('db', 'aquarium'),
        ('precision', 's'),
    )

    try:
        response = requests.post('http://192.168.1.20:8086/write', auth=('aquarium_usr', 'CrocodilulElvis'), params=params, data=data)
        return 0
    except:
        return 1

def log_tank_temp(temp):
    data = 'temp,type=tank value=' + str(temp)
    __send_request(data)

def log_env_temp(temp):
    data = 'temp,type=env value=' + str(temp)
    __send_request(data)

def log_ph(ph):
    data = 'ph,type=spot value=' + str(ph)
    __send_request(data)

def log_tank_temp_avg(temp):
    data = 'temp,type=tanka value=' + str(temp)
    __send_request(data)

def log_env_temp_avg(temp):
    data = 'temp,type=enva value=' + str(temp)
    __send_request(data)

def log_ph_avg(ph):
    data = 'ph,type=avg value=' + str(ph)
    __send_request(data)
