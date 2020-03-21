# How To Use It 

Installation, build/run containers:

    $ git clone git@github.com:taras-by/youtube-to-rss.git
    $ cd youtube-to-rss
    $ cp .env.dist .env
    $ docker-compose build
    $ docker-compose up -d 
    $ ./docker/console composer install
    
Edit config file: `app/Config.php`

Run application: `http://localhost:835`
    