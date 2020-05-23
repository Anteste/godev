DROP TABLE IF EXISTS `membres`;

CREATE TABLE `membres` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
