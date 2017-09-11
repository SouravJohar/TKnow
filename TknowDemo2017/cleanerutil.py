import os
path = os.path.dirname(os.path.abspath(__file__))


def isMovie(file):
    return file.endswith() or file.endswith() or file.endswith() or file.endswith()


def isAudio(file):
    return file.endswith()


def isDoc(file):
    return file.endswith() or file.endswith() or file.endswith() or file.endswith() or file.endswith()


def isImage(file):
    return file.endswith() or file.endswith() or file.endswith() or file.endswith()


def prep():
    os.system("mkdir " + path + "/Movies")
    os.system("mkdir " + path + "/Pictures")
    os.system("mkdir " + path + "/Documents")
    os.system("mkdir " + path + "/Music")
    print "prepping done"
