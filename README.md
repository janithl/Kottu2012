Kottu 2012
==========

Code by [Janith Leanage](http://janithl.blogspot.com)

This is the 2012 update of [Kottu](https://github.com/janithl/Kottu),
which gets rid of ugly URLs, loads of bugs and large spaghetti code files :P



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

* `./templates` contains all the web, rss and mobile templates, which are filled
with data and rendered.

* `./webcache` contains cached web pages (Kottu cache).

* All traffic is directed by `.htaccess` to the `./index.php` file. Routing and
stuff is handled inside that.

* `./config.php` contains all the configuration details for Kottu.



How to set up Kottu 2012
------------------------

* Run `kottu2012.sql` in a mySQL server.
 
* Copy the files into the server's webroot, and set up all the values in
`config.php` correctly.

* Create a Facebook app (to get Facebook share/like information for posts) and 
copy the app ID and secret into `config.php`



cronjobs
--------

For our setup at http://kottu.org, we use the following setup. Your needs may
vary.

* `http://basepath/admin/clearcache/secretkey` should run every hour or so.

* `http://basepath/admin/spicecalc/secretkey` should run every 15 minutes or so.

* `http://basepath/admin/feedget/secretkey` should run every 5 minutes or so.
