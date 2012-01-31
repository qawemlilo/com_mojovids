CREATE TABLE IF NOT EXISTS `#__mojo_orders` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) NOT NULL,
  `surname` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL default '',
  `pack` varchar(8) default NULL,
  `foldername` varchar(150) NOT NULL,
  `music` varchar(30) NOT NULL,
  `paid` int(1) default 0,
  `ts` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__price`;

CREATE TABLE IF NOT EXISTS `#__price` (
  `id` int(11) NOT NULL auto_increment,
  `packages` varchar(25) NOT NULL,
  `price` int(3) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__price` (`packages`, `price`) VALUES ('Economy', 79), ('Premium', 99);
