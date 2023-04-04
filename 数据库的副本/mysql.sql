/*
Navicat MySQL Data Transfer

Source Server         : localhost_3308
Source Server Version : 50723
Source Host           : localhost:3308
Source Database       : tp5_demo

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2020-06-09 20:07:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(11) DEFAULT NULL,
  `trip` varchar(100) DEFAULT NULL,
  `from` varchar(100) DEFAULT NULL,
  `to` varchar(100) DEFAULT NULL,
  `from_time` datetime DEFAULT NULL,
  `to_time` datetime DEFAULT NULL,
  `seat` varchar(100) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '1正常 0删除',
  `create_time` datetime DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('1', '1', 'G123', '北京', '南京', '2020-06-07 11:00:00', '2020-06-07 12:00:00', '5', '1', '2020-05-28 23:43:01', '2020-06-07 10:59:55');
INSERT INTO `order` VALUES ('2', '1', 'G123', '北京', '南京', '2020-06-03 05:53:00', '2020-06-07 07:07:00', '2', '1', '2020-05-28 23:43:13', '2020-05-28 23:43:13');
INSERT INTO `order` VALUES ('8', '15', 'G9004', '天津南', '北京南', '2020-06-03 07:48:00', '2020-06-03 08:23:00', '1', '1', '2020-06-08 12:20:12', '2020-06-08 12:20:12');
INSERT INTO `order` VALUES ('12', '14', 'G9004', '天津南', '北京南', '2020-06-03 07:48:00', '2020-06-03 08:23:00', '1', '1', '2020-06-09 19:48:17', '2020-06-09 19:48:17');

-- ----------------------------
-- Table structure for ticket
-- ----------------------------
DROP TABLE IF EXISTS `ticket`;
CREATE TABLE `ticket` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `trip` varchar(100) DEFAULT NULL COMMENT '车次',
  `from` varchar(100) DEFAULT NULL COMMENT '出发站',
  `to` varchar(100) DEFAULT NULL COMMENT '到达站',
  `from_time` datetime DEFAULT NULL COMMENT '出发时间',
  `to_time` datetime DEFAULT NULL COMMENT '到达时间',
  `seat` tinyint(3) DEFAULT '1' COMMENT '1一等座 2二等座 3软卧 4硬卧 5无座',
  `status` tinyint(2) DEFAULT '1' COMMENT '1正常 0删除',
  `create_time` datetime DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ticket
-- ----------------------------
INSERT INTO `ticket` VALUES ('1', 'G123', '北京', '南京', '2020-05-28 22:40:55', '2020-05-28 22:48:00', '2', '1', '2020-05-28 22:40:55', '2020-05-28 22:48:00');
INSERT INTO `ticket` VALUES ('2', 'G101', '北京南', '上海虹桥', '2020-06-03 06:36:00', '2020-06-03 12:40:00', '5', '1', '2020-06-02 19:01:09', '2020-06-02 19:01:11');
INSERT INTO `ticket` VALUES ('4', 'T109', '北京', '上海', '2020-06-03 20:05:38', '2020-06-04 11:00:00', '3', '1', '2020-06-02 19:04:07', '2020-06-02 19:04:12');
INSERT INTO `ticket` VALUES ('5', 'D709', '北京南', '上海', '2020-06-03 19:46:00', '2020-06-04 07:44:00', '1', '1', '2020-06-02 19:08:34', '2020-06-02 19:08:37');
INSERT INTO `ticket` VALUES ('6', 'Z281', '北京', '上海南', '2020-06-03 19:10:00', '2020-06-04 09:54:00', '3', '1', '2020-06-02 19:08:44', '2020-06-02 19:49:10');
INSERT INTO `ticket` VALUES ('7', 'D718', '天津西', '北京', '2020-06-03 05:53:00', '2020-06-07 07:07:00', '1', '1', '2020-06-02 19:23:36', '2020-06-02 19:23:36');
INSERT INTO `ticket` VALUES ('8', 'G9004', '天津南', '北京南', '2020-06-03 07:48:00', '2020-06-03 08:23:00', '1', '1', '2020-06-02 19:31:49', '2020-06-02 19:31:49');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '',
  `password` varchar(100) DEFAULT NULL,
  `sex` tinyint(4) DEFAULT '1' COMMENT '1男 2女',
  `birthday` datetime DEFAULT NULL,
  `address` varchar(500) DEFAULT '',
  `remarks` text,
  `status` tinyint(2) DEFAULT '1' COMMENT '1正常 0删除',
  `create_time` datetime DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '123456', '1', '1998-04-24 00:00:00', '集美大学诚毅学院软件', '', '1', '2020-06-01 13:52:40', '2020-06-01 13:52:51');
INSERT INTO `user` VALUES ('21', '王一', '000000', '1', '2020-01-01 00:00:00', '北京', '', '1', '2020-06-02 17:49:34', '2020-06-02 18:15:31');
INSERT INTO `user` VALUES ('20', '赵六', '666666', '1', '2020-04-24 00:00:00', '河北省石家庄市', '', '1', '2020-06-02 17:47:48', '2020-06-02 17:47:48');
INSERT INTO `user` VALUES ('14', '王翔名', '111111', '1', '1998-04-24 00:00:00', '天津', '', '1', '2020-06-02 15:47:24', '2020-06-02 15:47:24');
INSERT INTO `user` VALUES ('15', '花花', '999999', '2', '1999-04-11 00:00:00', '上海市', '', '1', '2020-06-02 17:12:22', '2020-06-02 17:12:22');
INSERT INTO `user` VALUES ('18', '小7', '778778', '2', '2020-06-01 00:00:00', '河北省石家庄市', '', '1', '2020-06-02 17:40:15', '2020-06-02 17:40:15');
INSERT INTO `user` VALUES ('19', '张三', '222222', '1', '2014-04-01 00:00:00', '河北省石家庄市', '', '1', '2020-06-02 17:42:05', '2020-06-02 17:42:05');
INSERT INTO `user` VALUES ('22', '小李', '456456', '1', '2015-04-01 00:00:00', '河北省石家庄市', '', '1', '2020-06-02 17:52:03', '2020-06-02 17:52:03');
INSERT INTO `user` VALUES ('23', '太极', '868686', '1', '2014-06-03 00:00:00', '福建省厦门市', '', '1', '2020-06-02 17:58:34', '2020-06-02 17:58:34');
INSERT INTO `user` VALUES ('31', '钱九', '111111', '1', '2020-06-09 00:00:00', '天津', '', '1', '2020-06-09 19:45:45', '2020-06-09 19:45:45');
INSERT INTO `user` VALUES ('25', 'jack', '123456', '1', '2020-04-05 00:00:00', '北京', '', '1', '2020-06-02 18:08:09', '2020-06-02 18:08:09');
INSERT INTO `user` VALUES ('26', '赵钱', '166166', '1', '2013-03-08 00:00:00', '天津', '', '1', '2020-06-02 18:20:23', '2020-06-02 18:20:23');
