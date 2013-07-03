CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  UNIQUE KEY `id` (`id`)
) DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

# User: admin
# Pass: admin
INSERT INTO `users` (`id`, `username`, `password`, `admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1);

ALTER TABLE `soa` ADD `owner` INT( 11 ) NOT NULL AFTER `ttl` 