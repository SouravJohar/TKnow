import os
from cleanerutil import *
from os import rename as move

PATH = os.path.dirname(os.path.abspath(__file__))
prep()

# start here
mydirectory = os.listdir()

for file in mydirectory:

print "Done"
