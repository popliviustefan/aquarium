import sys
from modules.aquarium_file_io import file_write

lst = sys.argv[1:]

def file_write_both(file, val):
    file_write(0, file, val)
    file_write(1, file, val)

def main():
    for i in range(0, len(lst), 2):
        file_write_both(lst[i], lst[i+1])
"""    
    j = 0
    file_write_both('set_tank_temp', lst[j])
    j += 1
    file_write_both('set_ph', lst[j])
    for i in range(1, 9):
        j += 1
        file_write_both('set_priza_' + str(i), lst[j])
        j += 1
        t = lst[j]
        val = int(t[0:2])* 60 + int(t[3:])
        file_write_both('set_priza_' + str(i) + '_start', val)
        j += 1
        t = lst[j]
        val = int(t[0:2])* 60 + int(t[3:])
        file_write_both('set_priza_' + str(i) + '_stop', val)
"""

if __name__ == '__main__':
    main()
