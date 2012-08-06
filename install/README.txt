============================================
ABOUT AJAX-FilmDB version 1.2.4 (08-Sep-2010)
============================================
AJAX-FilmDB is a powerful, ajax/php/mysql 
powered movie data base.

features:
	* feels like a desktop application
	* stores detailed information about your 
	  movies (inc. media)
	* genre support lets you store and browse 
	  genres for your movies
	* automatically downloads all the information
	  from IMDb, the largest on-line movie database
	* lets you organize your movie collection 
	  in user-defined categories
	* online configurable, easy to use
	  (inc. font type and font size)
	* powerful search and sort function
	* management of loaned movies
	* PDA & mobile phone support via "mobile" folder
	* RSS support via "rss" folder
	* support for GD lib (image shrinking)
	* supports poster saving as file or blob
	* supports poster import as file or url
	* support for IE 5.5 & 6 (fixes)
	* rescanning of already existing movies
	* im/export of movies as XML (inc. DTD)
	* supports complex admin functions
	  backup and restore database and
	  poster files (inc. logbook entries)
	* simple export API
	* english, german, dutch, spanish, italian

for more information, please read the PDF.

============================================
  INSTALLATION
============================================

	SERVER CONDITIONS: MYSQL 4.x AND PHP 4.3.x!

	* unzip the received archive "Install_AJAX-FilmDB_1.2.4.zip"


MANUALLY:
	* add a new database (e.g. 'filmdb') and create the 
	  necessary MySQL tables using the file install/db_defs.sql
	  (it's simple by using phpMyAdmin - if available)
	* unzip the archive "filmdb_1.2.4.zip"
	* rename the folder "filmdb_1.2.4" to "filmdb"
	* edit the file "mysql.php" in the folder "filmdb/config/"
	  and insert the access data (hostname/username/password/
	  dbname) for MySQL
	* copy the folder "filmdb" to a web accessible directory
	* all folders should have the permission 755
	  except the folder "poster" should have 777
	* all files should have the permission 644
	* except the files "people.php", "prefs.php", "user.php"  
	  and "upload.tmp" in folder "config/" and "debug.log"  
	  in folder "admin/" should have permission 666
	* point your browser to where you installed AJAX-FilmDB

AUTOMATICALLY:
	* copy the files "filmdb_1.2.4.zip" and "install.php"
	  to a web accessible directory
	* point your browser to "install.php"
	* follow the installer instructions
	* delete the file "install.php" from web directory

	* login as "admin" with password "admin"

	* change the password via config requester

	* have fun

	* please note that magic_quotes must be switched off! 
	  (php.ini: magic_qoutes = off) otherwise you'll get
	  SQL error messages


============================================
  CONFIGURATION
============================================

to configure the program, you can use the builtin
requester online. first of all you need to change
the admin's password from "admin" to anything else!
**** [login as UN: "admin" with PW: "admin"] ****
you don't need to edit the file 'config/config.php'
but if you wan't to - the details are described in 
the file.

other configurable files in the folder 'config/':

* ajax_filmdb.dtd (xml export dtd)
* language-de.php (german strings)
* language-en.php (english strings)
* language-nl.php (dutch strings)
* language-es.php (spanish strings)
* language-it.php (italian strings)
* mysql.php (mysql access configuration)
* people.php (borrower configuration for users/
  admin - editable online via requester)
* users.php (user configuration for admin only
  - editable online via requester)
* prefs.php (basic configuration for admin only
  - editable online via requester)
* iefixes.css (IE style sheet workaround)
* win.css (windows browser basic font size declaration)
* oos.css (all other browser basic font size declaration)


============================================
  THANKS TO...
============================================

* David Fuchs for php4flicks which AJAX-FilmDB
  is originally based on
* Niko for the original IMDB fetch scripts
* Eric Mueller and Denis125 for zip.lib 2.4 
* Holger Boskugel for the php unzip.lib 1.2 
* Walter Zorn for the javascript tooltip script
* Henri Torgemane for the javascript MD5 script
* Angus Turnbull for the IE5.5+ PNG Alpha Fix
* Andrew Clover for the javascript fixed.js
* Mario Sansone for the php installer script
* Hans Anderson for the php script xmlize()
* Rudi Vader for the Dutch translation
* Alfons Herráiz for the Spanish translation
* Simone Giusti for the Italian translation


============================================
  LICENSE
============================================
(c) 2005-2010 by Christian Effenberger.

AJAX-FilmDB is distributed under the terms of the GNU General Public License:

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.


============================================
to contact me use the address youcan[]gmx.net!
especially if you find any bugs or wrote any
improvements, do not hesitate to contact me!

