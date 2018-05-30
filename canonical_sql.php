CREATE TABLE canonical (
  `can_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `can_table` varchar(50) NOT NULL DEFAULT '',
  `can_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `can_title` varchar(250) NOT NULL DEFAULT '',
  `can_url` varchar(250) NOT NULL DEFAULT '',
   PRIMARY KEY  (`can_id`),
   KEY `can_pid` (`can_pid`)
) ENGINE=MyISAM;
