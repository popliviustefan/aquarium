#!usr/bin/python3

import serial           #serial communication library for communication with arduino
from time import sleep
import RPi.GPIO as GPIO     #library to manipulate GPIO pins
import datetime
import logging

from modules.aquarium_file_io import file_read, file_write, create_mem_dir, C, file_read_raw #,mem_dir_set_owner
import modules.aquarium_sensors as Aqs

logging.basicConfig(filename='/var/log/aquarium.log', filemode='w+', format='%(levelname)s:%(asctime)s - %(message)s', level=logging.INFO)

RELAY_PINS = [0, 43, 41, 39, 37, 35, 33, 31, 29]    #arduino MEGA pins connected to the relay board

SOCKET_LIGHT = 1
SOCKET_WATER_VALVE = 2
SOCKET_CO2_VALVE = 6
SOCKET_HEATER = 4

#GPIO init
GPIO.setwarnings(False)
GPIO.setmode(GPIO.BCM)
GPIO.setup(47, GPIO.OUT)

#init sensors
Aqs.init(25, 7)

ser = serial.Serial('/dev/ttyACM0', 9600)
if not ser.isOpen(): ser.open()

sleep(1)

set_temp_curent = 25
set_ph_curent = 7.0
#set_socket_current[[0 for x in range(10)]]
set_priza_curent = [0, 0, 0, 0, 0, 0, 0, 0, 0]

socket = [[0 for x in range(11)] for y in range(9)]
#above zero initialized matrix stores the socket info in memory as follows:
#socket[i] - represents info for socket i
#socket[i][0] - is the requested state for socket i (can be 0 - OFF, 1 - ON, 2 - schedule)
#socket[i][x] - where x = (1,3,5,7,9) is the start mins for the 5 possible intervals
#socket[i][x] - where x = (2,4,6,8,10) is the end mins for the 5 possible intervals


#set_priza_start_memory = []
#set_priza_stop_memory = []




create_mem_dir()

#read settings from sd card
#set_temp_memory = file_read(0, 'set_tank_temp')
#set_ph_memory = file_read(0, 'set_ph')
#write settings into memory files
#file_write(1, "set_tank_temp", set_temp_memory)
#file_write(1, "set_ph", set_ph_memory)



#for i in range (1,9):
    #read settings from sd card
#    socket[i][0] = (file_read(0, C.SET_SOCKET_[i]))
#    set_priza_start_memory.append(file_read(0, 'set_priza_' + str(i) + '_start'))
#    set_priza_stop_memory.append(file_read(0, 'set_priza_' + str(i) + '_stop'))
    #write settings into memory files
#    file_write(1, C.SET_SOCKET_[i], socket[i][0])
#    file_write(1, 'set_priza_' + str(i) + '_start', set_priza_start_memory[i])
#    file_write(1, 'set_priza_' + str(i) + '_stop', set_priza_stop_memory[i])


def set_pin(pin_type, pin_number, value):
    msg = ''
    value = int(value)
    if (pin_type == 'digital'):
        if (value > 0):
            msg = 'D' + str(pin_number).zfill(2) + '000'
        else:
            msg = 'D' + str(pin_number).zfill(2) + '001'
    elif (pin_type == 'analog'):
        msg = 'A' + str(pin_number).zfill(2) + str(value).zfill(3)
    elif (pin_type == 'pwm'):
        msg = 'P' + str(pin_number).zfill(2) + str(value).zfill(3)
    
    ser.write(str.encode(msg))
    ser.flush()


def relay(relay_number, desired_state):
    set_pin('digital', RELAY_PINS[relay_number], desired_state)


if __name__ == "__main__":
    #permission_set = 0
    logging.info('program loop started...')
    while True:
        tank_temp = Aqs.get_tank_temp()
        env_temp = Aqs.get_env_temp()
        ph_val = Aqs.get_ph(tank_temp)
        #get status of overflow sensor
        
        #read data from memory files
        set_temp_memory = file_read(1, C.SET_TEMP)
        set_ph_memory = file_read(1, C.SET_PH)
        for i in range (1, 9):
            socket[i] = str(file_read_raw(1, C.SET_SOCKET_SCHEDULE_[i])).split("~")
            socket[i] = [int(a[0:2])*60 + int(a[3:5]) for a in socket[i]]
            socket[i].insert(0, file_read(1, C.SET_SOCKET_[i])) #socket[i][0] = file_read(1, C.SET_SOCKET_[i])
            
            #set_priza_start_memory[i] = file_read(1, 'set_priza_' + str(i) + '_start')
            #set_priza_stop_memory[i] = file_read(1, 'set_priza_' + str(i) + '_stop')
        
        #get current time in minutes
        current_time = datetime.datetime.now().hour * 60 + datetime.datetime.now().minute
        
        #compare with current values
        for i in range (1, 9):
            if (i == SOCKET_CO2_VALVE or i == SOCKET_HEATER): continue

            if (socket[i][0] != 2 and set_priza_curent[i] != socket[i][0]):
                set_priza_curent[i] = socket[i][0]
                relay(i, set_priza_curent[i])

            if (socket[i][0] == 2):
                b = 0
                for j in range (1, 11, 2):
                    if (socket[i][j] <= current_time and current_time < socket[i][j+1]):
                        b = 1
                        break
                if (b != set_priza_curent[i]):
                    set_priza_curent[i] = b
                    relay(i, b)
                    


#        GPIO.output(47, True)
#        sleep(1)
#        GPIO.output(47, False)
        
        #write status to status files
        file_write(1, C.TANK_TEMP, tank_temp)
        file_write(1, C.ENV_TEMP, env_temp)
        file_write(1, C.TANK_PH, ph_val)
        file_write(1, C.TANK_FANS, 0) #get tank fans status
        file_write(1, C.TANK_OVERFLOW, 0) #get tank overflow status
        file_write(1, C.TANK_AC, 0)
        
        for i in range (1, 9):
            file_write(1, C.TANK_SOCKET_[i], set_priza_curent[i])
        
        #if (not permission_set):
        #mem_dir_set_owner()
        #    permission_set = 1
        sleep(5)
        




