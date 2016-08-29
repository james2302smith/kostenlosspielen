CREATE TABLE `kostenlosspielen_feeds` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(45) NOT NULL,
  `status` tinyint(4) DEFAULT '0',
  `from_user_id` bigint(20) NOT NULL,
  `time` datetime NOT NULL,
  `object_id` bigint(20) NOT NULL,
  `target_id` bigint(20) NOT NULL,
  `message` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
