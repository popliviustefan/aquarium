#!usr/bin/python3

# we use GPIO4
# we use 4.7k resistor between GPIO4 and 3.3V
# the other 2 pins get connected to GND

from os import system
from time import sleep


def init_temp():
    system('modprobe w1-gpio')
    system('modprobe w1-therm')



def __read_temp_raw(i):
    base_dir = '/sys/bus/w1/devices/'
    sensor_tank = '28-0000056ef65f'
    sensor_env = '28-0000056e6576'

    if i == 0:
        f = open(base_dir + sensor_tank + '/w1_slave', 'r')
    else:
        f = open(base_dir + sensor_env + '/w1_slave', 'r')
    lines = f.readlines()
    f.close()
    return lines

def read_temp(i):
    lines = __read_temp_raw(i)
    while lines[0].strip()[-3:] != 'YES':
        sleep(0.2)
        lines = __read_temp_raw(i)
    equals_pos = lines[1].find('t=')
    if equals_pos != -1:
        temp_string = lines[1][equals_pos+2:]
        temp_c = round(float(temp_string) / 1000.0, 1)
        return temp_c

# init_temp()
# while True:
#     i=(read_temp(0))
#     sleep(1)
#     j=(read_temp(1))
#     print (i,j, 'Degree Celsius')
#     sleep(1)
