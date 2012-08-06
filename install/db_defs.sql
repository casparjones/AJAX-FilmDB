-- 
-- Table structure for table `movies`
-- 

CREATE TABLE `movies` (
  `fid` smallint(5) unsigned NOT NULL auto_increment,				# pk
  `id` mediumint(7) unsigned zerofill NOT NULL default '0000000',	# imdb-key
  `nr` smallint(4) unsigned zerofill NOT NULL default '0000',
  `runtime` smallint(4) unsigned NOT NULL default '0',
  `inserted` date default NULL,
  `year` year(4) default NULL,
  `genre` set('Action','Adult','Adventure','Animation','Comedy','Crime','Documentary','Drama','Family','Fantasy','Film-Noir','Horror','Music','Musical','Mystery','Romance','Sci-Fi','Short','Thriller',' War','Western') default NULL,
  `lang` set('DE','EN','ES','FR','IT','RU','TR','?') default 'EN',
  `audio` enum('AC3','DTS','MP2','MP3','AAC','ATRAC','AMR','OGG','WMA') NOT NULL default 'AC3',
  `channel` enum('1.0','1/1','2.0','2.1','3.0','3.1','4.0','5.1','6.1','7.1') NOT NULL default '5.1',
  `herz` enum('24.0','32.0','44.1','48.0','96.0') NOT NULL default '48.0',
  `video` enum('MPEG-1','MPEG-2','MPEG-4','DivX','Xvid','3ivx','h263','h264','WMV') NOT NULL default 'MPEG-2',
  `width` mediumint(4) unsigned default NULL,
  `height` mediumint(4) unsigned default NULL,
  `container` enum('MPEG-1','MPEG-2','MP4','AVI','ASF','MOV','OGG','3GP','MKV') NOT NULL default 'MPEG-2',
  `ratio` enum('16:9','4:3','LetterBox','Pan&Scan','Flexibly') NOT NULL default '16:9',
  `format` enum('PAL','NTSC','FILM','15','20','24','25','30','50','60') NOT NULL default 'PAL',
  `medium` enum('VideoDVD','ISO-DVD','MiniDVD','ISO-CD','VideoCD','SuperVCD','UMD','BD','HD-DVD','Disk','Stick','Card') NOT NULL default 'VideoDVD',
  `type` enum('-R','+R','-RW','+RW','Ram','Rom','Worm','-') NOT NULL default '-R',
  `disks` tinyint(2) unsigned NOT NULL default '1',
  `rating` tinyint(2) unsigned default NULL,
  `name` varchar(100) NOT NULL default '',
  `local` varchar(100) default NULL,
  `aka` varchar(200) default NULL,
  `country` varchar(200) default NULL,
  `cat` varchar(10) default NULL,
  `comment` varchar(200) default NULL,
  `avail` tinyint(1) unsigned default '1',
  `lentsince` date default NULL,
  `lentto` tinyint(2) unsigned default NULL,
  `poster` blob,
  PRIMARY KEY  (`fid`),
  KEY `nr` (`nr`),
  FULLTEXT KEY `name` (`name`,`local`,`aka`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `people`
-- 

CREATE TABLE `people` (
  `id` mediumint(7) unsigned zerofill NOT NULL default '0000000',
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `plays_in`
-- 

CREATE TABLE `plays_in` (
  `movie_fid` smallint(5) unsigned NOT NULL default '0',
  `people_id` mediumint(7) unsigned zerofill NOT NULL default '0000000',
  PRIMARY KEY  (`movie_fid`,`people_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- Table structure for table `writes`
-- 

CREATE TABLE `writes` (
  `movie_fid` smallint(5) unsigned NOT NULL default '0',
  `people_id` mediumint(7) unsigned zerofill NOT NULL default '0000000',
  PRIMARY KEY  (`movie_fid`,`people_id`)
) TYPE=MyISAM;
        
-- --------------------------------------------------------

-- 
-- Table structure for table `directs`
-- 

CREATE TABLE `directs` (
  `movie_fid` smallint(5) unsigned NOT NULL default '0',
  `people_id` mediumint(7) unsigned zerofill NOT NULL default '0000000',
  PRIMARY KEY  (`movie_fid`,`people_id`)
) TYPE=MyISAM;
