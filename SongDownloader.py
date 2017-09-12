from .engines import SongDownloader


if __name__ == "__main__":

    # input song name
    songs = raw_input(">")

    for song in songs.split(', '):
        # PS: i don't get this part but yeah!
        if song[len(song) - 3:] == ' -y':
            # source will be youtube
            source='youtube'
        else:
            # source will be mp3brainz
            source='mp3brainz'

        # Initialize Song downloader class
        sd = SongDownloader(source=source)

        # search for result. this will auto print
        # the result into the command line
        sd.search(song, print_result=True)

        # download song
        while True:
            song_id = raw_input(">")
            if '0' in song_id:
                # go to the next song.
                continue
            elif song_id:
                sd.download(int(song_id))
                continue