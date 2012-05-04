#
# Routes
#
# Licensed under The MIT License
# Redistributions of files must retain the below copyright notice.
#
# @author     Robert Love <robert@pollenizer.com>
# @copyright  Copyright 2012, Pollenizer Pty. Ltd. (http://pollenizer.com)
# @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
#
CREATE TABLE `routes` (
 `id` INT(10) NOT NULL AUTO_INCREMENT,
 `name` VARCHAR(255) NOT NULL,
 `value` VARCHAR(255) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `name` (`name`),
 KEY `value` (`value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
