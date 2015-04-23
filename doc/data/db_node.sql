/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-23 23:55:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `db_node`
-- ----------------------------
DROP TABLE IF EXISTS `db_node`;
CREATE TABLE `db_node` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `link` varchar(50) default NULL,
  `title` varchar(50) default NULL,
  `status` int(11) default NULL,
  `remark` varchar(225) default NULL,
  `sort` int(11) default NULL,
  `pid` int(11) default NULL,
  `level` int(11) default NULL,
  `group_id` int(11) default NULL,
  `show` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=452 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of db_node
-- ----------------------------
INSERT INTO `db_node` VALUES ('1', 'Syweblg2015', 'Syweblg2015', '后台管理', '1', '后台项目', '0', '0', '1', '0', '0');
INSERT INTO `db_node` VALUES ('20', 'LRole', 'LRole', '角色管理', '1', '模块', '10', '1', '2', '3', '0');
INSERT INTO `db_node` VALUES ('32', 'Public', 'Public', '公共模块', '1', '控制器', '360', '1', '2', '0', '0');
INSERT INTO `db_node` VALUES ('33', 'add', 'add', '新增', '1', '动作', '361', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('34', 'insert', 'insert', '写入', '1', '动作', '364', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('35', 'edit', 'edit', '编辑', '1', '动作', '362', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('36', 'index', 'index', '列表', '1', '动作', '363', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('37', 'resume', 'resume', '恢复', '1', '动作', '365', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('38', 'forbid', 'forbid', '禁用', '1', '动作', '366', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('39', 'update', 'update', '更新', '1', '动作', '367', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('40', 'delAll', 'delAll', '删除', '1', '动作', '368', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('41', 'Index', 'Index', '默认模块', '1', '控制器', '370', '1', '2', '0', '0');
INSERT INTO `db_node` VALUES ('42', 'index', 'index', '首页模块', '1', '动作', '372', '41', '3', '0', '0');
INSERT INTO `db_node` VALUES ('43', 'main', 'main', '空白首页', '1', '动作', '371', '41', '3', '0', '0');
INSERT INTO `db_node` VALUES ('44', 'DbGroup', 'DbGroup', '分组管理', '1', '模块', '15', '1', '2', '3', '0');
INSERT INTO `db_node` VALUES ('45', 'add', 'add', '增加分组', '1', '动作', '16', '44', '3', '0', '0');
INSERT INTO `db_node` VALUES ('46', 'edit', 'edit', '修改分组', '1', '动作', '17', '44', '3', '0', '0');
INSERT INTO `db_node` VALUES ('47', 'del', 'dl', '删除分组', '1', '动作', '18', '44', '3', '0', '0');
INSERT INTO `db_node` VALUES ('65', 'DzSport', 'DzSport', '赛事分类', '1', '模块', '40', '1', '2', '9', '0');
INSERT INTO `db_node` VALUES ('86', 'ZjTypes?types=house', 'ZjTypes', '房屋相关', '1', '控制器', '60', '1', '2', '9', '0');
INSERT INTO `db_node` VALUES ('93', 'DzActivityVenue', 'DzActivityVenue', '活动|场馆分类', '1', '模块', '50', '1', '2', '9', '0');
INSERT INTO `db_node` VALUES ('95', 'LUser', 'LUser', '管理员', '1', '模块', '1', '1', '2', '3', '0');
INSERT INTO `db_node` VALUES ('127', 'DbNode', 'DbNode', '权限管理', '1', '模块', '20', '1', '2', '3', '0');
INSERT INTO `db_node` VALUES ('132', 'second', 'second', '赛事详情页面', '1', '操作', '41', '0', '3', '0', '0');
INSERT INTO `db_node` VALUES ('451', 'DbGame', 'DbGame', '赛事管理', '1', '模块', '60', '1', '2', '4', '1');
INSERT INTO `db_node` VALUES ('188', 'ZjTypes', 'ZjTypes', '相关', '1', '模块', '59', '1', '2', '0', '0');
INSERT INTO `db_node` VALUES ('189', 'insert_second', 'insert_second', '赛事详情更新', '1', '操作', '42', '65', '3', '0', '0');
INSERT INTO `db_node` VALUES ('200', 'foreverdelete', 'foreverdelete', '彻底删除', '1', '操作', '369', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('258', 'node', 'node', '分组节点', '1', '操作', '21', '127', '3', '0', '0');
