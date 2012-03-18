# $Id$
#
# Copyright 2012, Pollenizer Pty. Ltd.
#
# Licensed under The MIT License
# Redistributions of files must retain the above copyright notice.
# MIT License (http://www.opensource.org/licenses/mit-license.php)

CREATE TABLE `routes` (
 `id` INT(10) NOT NULL AUTO_INCREMENT,
 `uid` CHAR(40) NOT NULL,
 `name` VARCHAR(255) NOT NULL,
 `value` VARCHAR(255) NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `uid` (`uid`),
 KEY `name` (`name`),
 KEY `value` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
