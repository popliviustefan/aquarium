#!usr/bin/python3

from collections import deque

from modules.ph_sensor_i2c_read import AtlasI2C as PhSensor
import modules.temp_sensor_read as TempSensor
import modules.influxdb_write as Log


ATT = [0.23, 0.19, 0.15, 0.12, 0.1, 0.08, 0.06, 0.04, 0.02, 0.01]
q_temp_tank = deque(maxlen=10)
q_temp_env = deque(maxlen=10)
q_ph = deque(maxlen=10)

ph_sensor = PhSensor()
ph_sensor.set_i2c_address(100)

def init(init_temp, init_ph):
    TempSensor.init_temp()

    global q_temp_tank, q_temp_env, q_ph
    #init FIFO queues with "set" values
    for i in range (0,10):
        q_temp_tank.appendleft(init_temp)
        q_temp_env.appendleft(init_temp)
        q_ph.appendleft(init_ph)
    
    
def get_tank_temp():
    global q_temp_tank
    t = TempSensor.read_temp(0)
    avg = 0
    for i in range (0, 10):
        avg = avg + ATT[i] * q_temp_tank[i]
    avg = round(avg, 1)
    Log.log_tank_temp(t)
    Log.log_tank_temp_avg(avg)
    if (abs(t - avg) < 20):
        q_temp_tank.appendleft(t)
    return avg
    
def get_env_temp():
    global q_temp_env
    t = TempSensor.read_temp(1)
    avg = 0
    for i in range (0, 10):
        avg = avg + ATT[i] * q_temp_env[i]
    avg = round(avg, 1)
    Log.log_env_temp(t)
    Log.log_env_temp_avg(avg)
    if (abs(t - avg) < 20):
        q_temp_env.appendleft(t)
    return avg    


def get_ph(tank_temp):
    global q_ph
    ph_res = ph_sensor.query("RT," + str(tank_temp))
    print ('ph_res: ' + ph_res)
    ph_val = float(ph_res[18:-25])
    avg = 0
    for i in range (0, 10):
        avg = avg + ATT[i] * q_ph[i]
    avg = round(avg, 3)
    Log.log_ph(ph_val)
    Log.log_ph_avg(avg)
    if (abs(ph_val - avg) < 1):
        q_ph.appendleft(ph_val)
    return avg

        


