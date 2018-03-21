CREATE TABLE IF NOT EXISTS `#__jvportfolio_item` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate` text,
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `desc` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `tag` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `extrafields` text NOT NULL,
  `date_created` datetime NOT NULL,
  `pfo_t` text NOT NULL,
  `pfo_v` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `#__jvportfolio_liked` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pfid` int(11) DEFAULT NULL COMMENT 'Portfolio id',
  `u` varchar(255) DEFAULT NULL COMMENT 'User created',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
