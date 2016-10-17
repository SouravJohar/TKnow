import time
import itertools
password = "_tknow_"
print "Cracking..."
start = time.time()
for test in itertools.product('abcdefghijklmnopqrstuvwxyz_', repeat = 7):
    if "".join(test) == password:
        stop = time.time()
        print "".join(test), "match found! Process took {0} seconds".format(stop - start)
        
        break
    else:
        continue
        
    
