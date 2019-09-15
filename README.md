Kottu 2012
==========

Code by [Janith Leanage](http://janithl.blogspot.com)

This is the 2012 update of [Kottu](https://github.com/janithl/Kottu),
which gets rid of ugly URLs, loads of bugs and large spaghetti code files :P



Installation
------------

We've moved installation to Docker to make it easier to set up Kottu on either
your local machine or on a server. You need to have `docker` and `docker-compose`
installed for this.

1. Simply clone the repository and run `docker-compose up -d` inside it. This will
set up three Docker containers, and the output of `docker ps` should look similar
to the following:

```
CONTAINER ID        IMAGE                                 COMMAND                  CREATED             STATUS              PORTS                               NAMES
3836dc148c6a        php:5.6-fpm                           "docker-php-entrypoi…"   5 hours ago         Up 5 hours          9000/tcp                            kottu2012_php_1
e833ce2641e6        mysql:5.7                             "docker-entrypoint.s…"   6 hours ago         Up 6 hours          0.0.0.0:3306->3306/tcp, 33060/tcp   kottu2012_db_1
652ee5c63ac2        nginx:alpine                          "nginx -g 'daemon of…"   6 hours ago         Up 6 hours          0.0.0.0:8000->80/tcp                kottu2012_webserver_1
```

2. After setting these containers up, you will need to do the initial DB migration
using the `kottu.sql` script. For this, we will run the script against the mysql
client installed on the PHP container:

`docker-compose exec php mysql -h db -u root -pyour_mysql_root_password kottu < kottu.sql`

3. Now, if you go to `http://localhost:8000`, this should show you an empty Kottu screen.

4. You can log in to the admin panel at `http://localhost:8000/admin` using the default 
username `indi` and password `indi`. 

**Important!** Please change these values in the `users` table to ensure 
security.

5. You can add new blogs using the interface there.

6. When you want to fetch the posts belonging to those blogs, you need to navigate to
`http://localhost:8000/admin/feedget/<secretkey>`, where the secret key can be found 
inside the config.php file. It is `backendsecretkeywithunicorns` by default.

7. If you go back to `http://localhost:8000`, you should see the posts having been 
populated. If the screen is stuck at empty, that is probably due to caching. Manually 
clear the cache by navigating to `http://localhost:8000/admin/clearcache/<secretkey>`.

8. To get Facebook share/like information for posts in order to calculate "spice", you
will need to create a Facebook app and copy the app ID and secret into `config.php`.



License
-------

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU Affero General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Affero General Public License for more details.

	You should have received a copy of the GNU Affero General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>. 

(see `license.txt` for full AGPL license)

**(For those who don't get the legal lingo: Basically what we're saying is
feel free to copy our code, but please share back any changes or improvements
that you make, in the spirit of free software)**



External Libraries
------------------

This software uses the following external libraries and CSS files:

* [SimplePie](http://simplepie.org/)   
	Version 1.2.1-dev   
	Copyright 2004-2010 Ryan Parman, Geoffrey Sneddon, Ryan McCue   
	Released under the [BSD License]
	(http://www.opensource.org/licenses/bsd-license.php)   

* [Timthumb](http://code.google.com/p/timthumb/)   
	Version 2.8.2   
	Copyright Ben Gillbanks and Mark Maunder   
	Based on work done by Tim McDaniels and Darren Hoyt   
	Released under [GNU General Public License, version 2]
	(http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)   

* [YUI CSS Reset](http://yuilibrary.com/license/)   
	Version 3.4.1 (build 4118)   
	Copyright 2011 Yahoo! Inc. All rights reserved.   
	Licensed under the BSD License   

* [Facebook PHP SDK](http://developer.facebook.com/)  
	Copyright 2011 Facebook, Inc.  
	Licensed under the [Apache License, Version 2.0]
	(http://www.apache.org/licenses/LICENSE-2.0)  
	
* [Simple HTML DOM](http://sourceforge.net/projects/simplehtmldom/)  
	Version 1.11 (Rev: 184)  
	Copyright S.C. Chen, John Schlick and Rus Carroll  
 	Licensed under [The MIT License]
	(http://www.opensource.org/licenses/mit-license.php)

Structure
---------

* `./lib` is the most important folder, and contains the Kottu API, the Kottu 
back-end, the database connection class, templates class, as well as the 
SimplePie, Simple HTML DOM and Facebook libraries.

* `./static` has the static files such as javascripts and CSS files.

* `./img` is the images folder, and has the Timthumb file at `./img/index.php`.
This folder contains the image resources used by Kottu, the icon files, and
the Timthumb cache.

* `./templates` contains all the web, admin panel, rss and mobile templates, 
which are filled with data and rendered.

* `./webcache` contains cached web pages (Kottu cache).

* All traffic is directed by `.htaccess` to the `./index.php` file. Routing and
stuff is handled inside that.

* `./config.php` contains all the configuration details for Kottu.



cronjobs
--------

For our setup at http://kottu.org, we use the following setup. Your needs may
vary.

* `http://<basepath>/admin/cacheclear/<secretkey>` should run every hour or so.

* `http://<basepath>/admin/calculatespice/<secretkey>` should run every 15 minutes or so.

* `http://<basepath>/admin/feedget/<secretkey>` should run every 5 minutes or so.
