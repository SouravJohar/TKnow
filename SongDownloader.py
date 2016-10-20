import requests
from bs4 import BeautifulSoup
import os
import dryscrape


def youtubedl(search): #calling the main function of code
    media_type_type = "audio"
    media_url = 'https://www.youtube.com/results?search_query=' + \
          search[:len(search)-3]
    sc = requests.get(media_url)
    soup = BeautifulSoup(sc.content, 'html.parser')
    media_title = soup.findAll('h3', {'class': 'yt-lockup-title '})
    link = []
    for i in range(len(media_title)):
        link.append(media_title[i].find('a')['href'])
    for i in range(len(media_title)):
        print(str(i + 1) + '. ' + media_title[i].find('a').text)

    while True:
        try:
            user_input = int(raw_input(">"))
            if user_input == 999:  # override code
                continue
            if user_input not in range(1, 20):
                print('!')
                continue
            break
        except NameError:
            print('!')
            continue
    f_link = 'https://www.youtube.com' + link[user_input - 1]

    if search[::-1][:3] == 'v- ':
        media_type_type = "defvideo"
    if search[::-1][:3] == "r- ":
        res = ListRes(f_link)
        media_type_type = "video"

    if media_type == "video":
        os.system("youtube-dl -f {} ".format(res) + f_link)
    if media_type == "defvideo":
        os.system("youtube-dl " + f_link)
    if media_type == "audio":
        os.system("youtube-dl -f 140 " + f_link)
    print "Download Complete"


flag = ""
headers = {
    "User-agent":
    "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.80 Safari/537.36"
}
search = raw_input(">")
for song in search.split(', '):
    if song[len(song) - 3:] == ' -y':
        youtubedl(song)
    else:
        base_url = "http://mp3brainz.cc/v1/"
        query_url = "http://mp3brainz.cc/v1/#!q=" + song
        session = dryscrape.Session()
        session.visit(query_url)
        response = session.body()
        soup = BeautifulSoup(response, 'lxml')
        links = soup.findAll('a')
        link_ = []
        link__ = []
        for link in links:
            try:
                if len(link['href']) == 71:

                    link_.append(link)
                    link__.append(link['href'][2:])
            except:
                pass
        if len(links) > 10:
            for i in range(20):
                temp = link_[i].text.split('\n')
                print str(i + 1) + ".", temp[2], temp[3], temp[5]
            n = int(raw_input(">"))
            if n == 0:
                youtubedl(search)
            if n == 999:
                continue
            else:
                download = base_url + link__[n - 1]
                session2 = dryscrape.Session()
                session2.visit(download)
                response2 = session2.body()
                soup1 = BeautifulSoup(response2, 'lxml')
                final_link = soup1.findAll('span', {'class': 'url'})
                final_link = str(final_link)[19:].split('<')
                print "Downloading from: \n", final_link[0], "\n\n"
                os.system("curl -O " + final_link[0])
                print "Download complete"

        else:
            youtubedl(search) #calling the function back 
