<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php';

$db = DBWorker::getInstance();

$sql = <<<SQL
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for api_users
-- ----------------------------
DROP TABLE IF EXISTS `api_users`;
CREATE TABLE `api_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of api_users
-- ----------------------------
BEGIN;
INSERT INTO `api_users` VALUES (1, 'admin', '$2y$10\$wdHtunopxN0uXMZOEBmCIOdEWULhsFgXhLjc8KyVK7lH9XBRx480O');
COMMIT;

-- ----------------------------
-- Table structure for students
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of students
-- ----------------------------
BEGIN;
INSERT INTO `students` VALUES (1, 'stud1');
INSERT INTO `students` VALUES (2, 'stud2');
INSERT INTO `students` VALUES (3, 'stud3');
INSERT INTO `students` VALUES (4, 'stud4');
INSERT INTO `students` VALUES (5, 'stud5');
INSERT INTO `students` VALUES (6, 'stud6');
INSERT INTO `students` VALUES (7, 'stud7');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
SQL;


print_r($db->Query($sql));

