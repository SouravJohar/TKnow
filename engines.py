import os
import requests
import dryscrape

from bs4 import BeatifulSoup
from .config import YOUTUBE_SEARCH_URL, DL_SOURCE


class YoutubeDL(object):

    def __init__(self, *args, **kwargs):
        return super(YoutubeDL, self).__init__(*args, **kwargs)

    def youtube_search(self, search_item):
        searchitem = search_item[:len(search) - 3]
        sc = requests.get("{url}{item}".format(
            url=DL_SOURCES['youtube']['search_url'],
            item=searchitem,
        ))
        html_content = BeatifulSoup(sc.content, 'html.parser')

        # get the list of items
        urls = []
        for content in html_content.findAll('h3', {'class', 'yt-lockup-title'}):
            item = content.find('a')    
            urls.append({
                'url': item.get('href'),
                'title': item.text,
                'source': 'youtube',
                'text': item.text,
            })

        return urls

    def youtubedl_download(self, item):
        try:
            os.system(DL_SOURCES['youtube']['command'].format(
                params="", url=item['url'],
            ))
        except Exception as e:
            print (e)


class Mp3Brainz(object):

    def __init__(self, *args, **kwargs):
        return super(Mp3Brainz, self).__init__(*args, **kwargs)

    def mp3brainz_search(self, search_item):
        session = dryscrape.Session()
        session.visit("{url}{item}".format(
            url=DL_SOURCES['mp3brainz']['search_url'],
            item=search_item,
        ))

        resp = session.body()
        html_content = BeatifulSoup(resp, 'lxml')

        # get the list of items
        urls = []
        for content in html_content.findAll('a'):
            if len(content['href']) >= 71:
                # this is a valid song url
                urls.append({
                    'url': content['href'][2:],
                    'title': content,
                    'source': 'mp3brainz',
                    'text': content,
                })

        return urls

    def _get_download_url(self, url):
        download = "{base}{url}".format(
            base=DL_SOURCES['mp3brainz']['base_url'],
            url=url,
        )
        session = dryscrape.Session()
        session.visit(download)
        resp = session.body()
        html_content = BeatifulSoup(resp, 'lxml')
        link = html_content.findAll('span', {'class': 'url'})

        return str(link)[19:].split('<')[0]

    def mp3brainz_download(self, item):
        try:
            url = self._get_download_url(item['url'])
            os.system(DL_SOURCES['mp3brainz']['command'].format(
                url=url,
            ))
        except Exception as e:
            print (e)


class SongDownloader(YoutubeDL, Mp3Brainz):
    result_items = []

    def __init__(self, *args, **kwargs):
        self.source = kwargs.get('source')
        return super(SongDownloader, self).__init__(*args, **kwargs)

    def _print_list(self, items):
        overall_count = len(self.result_items)

        for count, item in enumerate(items):
            print ("{count} {text}".format(
                count=overall_count + int(count),
                text=item['text'],
            ))

        return

    def search(self, search_item, print_result=False):
        if self.source == 'youtube':
            items = self.youtube_search(search_item)
        elif self.source == 'mp3brainz':
            items = self.mp3brainz_search(search_item)
        else:
            print ("Download Source is not supported.")

        # print list
        if print_result:
            self._print_list(items)

        # add it to the result items
        self.result_items += items

        return items

    def download(self, result_id):
        item = self.result_items[result_id - 1]
        if item['source'] == 'youtube':
            self.youtubedl_download(item)
        elif item['source'] == 'mp3brainz':
            self.mp3brainz_download(item)
        else:
            print ("Download Source is not supported.")

        return



