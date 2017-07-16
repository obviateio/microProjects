import serial
ser = serial.Serial(
    port='/dev/cu.usbmodem14521',\
    baudrate=9600,\
    parity=serial.PARITY_NONE,\
    stopbits=serial.STOPBITS_ONE,\
    bytesize=serial.EIGHTBITS,\
        timeout=0)  # open serial port
print(ser.name)         # check which port was really used

line = ""
while True:
    for c in ser.read():
        if c == '\r' or c == '\n':
            if len(line) > 1:
                print(line)
                line = ""
                break
        else:
            line += str(c)

#//ser.write(b'hello')     # write a string
ser.close() 

