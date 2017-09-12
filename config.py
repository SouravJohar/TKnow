HEADERS = {
    'User-agent': 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.80 Safari/537.36'
}

DL_SOURCES = {
    'youtube': {
        'base_url': 'https://www.youtube.com/',
        'search_url': 'https://www.youtube.com/results?search_query=',
        'command': "youtube-dl {params} {url}",
    },
    'mp3brainz': {
        'base_url': 'http://mp3brainz.cc/v1/',
        'search_url': 'http://mp3brainz.cc/v1/#!q=',
        'command': 'curl -O {url}',
    }
}