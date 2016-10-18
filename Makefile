UNAME=${shell uname -s}

all: install

install:
	if [ ${UNAME} = Linux ]; then \
		sudo apt-get install qt5-default \
			libqt5webkit5-dev \
			build-essential \
			python-lxml \
			python-pip \
			xvfb; \
	elif [ $(UNAME) = Darwin ]; then \
		command -v brew >/dev/null 2>&1 || { echo >&2 "Installation requires brew to install qt. Please install brew and try again"; exit 1; }; \
		brew install qt; \
	fi
	pip install virtualenv; \
	virtualenv virtualenv; \
	source virtualenv/bin/activate; \
	pip install -r requirements.txt; \
	echo "Activate the virtualenv by running 'source virtualenv/bin/activate'"
