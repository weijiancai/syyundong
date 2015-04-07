/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-07 16:27:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `db_venue`
-- ----------------------------
DROP TABLE IF EXISTS `db_venue`;
CREATE TABLE `db_venue` (
  `id` int(11) NOT NULL auto_increment COMMENT '场馆ID',
  `name` varchar(64) NOT NULL COMMENT '场馆名称',
  `image` int(11) NOT NULL COMMENT '图片',
  `sport_id` int(11) NOT NULL COMMENT '运动项目',
  `province` varchar(32) NOT NULL COMMENT '省',
  `city` varchar(32) NOT NULL COMMENT '市',
  `region` varchar(32) NOT NULL COMMENT '区',
  `address` varchar(128) NOT NULL COMMENT '地点',
  `phone` varchar(32) default NULL COMMENT '电话',
  `person_cost` int(11) NOT NULL COMMENT '人均',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `input_user` int(11) NOT NULL COMMENT '录入人',
  `star_count` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_venue_sport_id` (`sport_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='场馆';

-- ----------------------------
-- Records of db_venue
-- ----------------------------
INSERT INTO `db_venue` VALUES ('1', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('2', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('3', '松原金钻羽毛球馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('4', '查干湖小区乒乓球馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('5', '铂金路游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('6', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('7', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('8', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('9', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('10', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('11', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('12', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('13', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('14', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('15', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('16', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('17', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
INSERT INTO `db_venue` VALUES ('18', '松原石油大厦游泳馆', '0', '14', '吉林省', '松原', '油田', '553号', '186867916479', '50', '2015-04-07 13:05:45', '0', null);
