/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 80012
Source Host           : 127.0.0.1:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 80012
File Encoding         : 65001

Date: 2025-12-06 13:54:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `columid` int(11) DEFAULT NULL,
  `des` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `img` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `video` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `click` int(11) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('2', '1', '10', '2', '3', '<p>ArticleModel<span style=\"text-wrap-mode: wrap;\">ArticleModel</span><span style=\"text-wrap-mode: wrap;\">胜多负少</span><span style=\"text-wrap-mode: wrap;\">ArticleModel</span><span style=\"text-wrap-mode: wrap;\">胜多负少</span><span style=\"text-wrap-mode: wrap;\">ArticleModel<span style=\"text-wrap-mode: wrap;\">ArticleModel</span><span style=\"text-wrap-mode: wrap;\">胜多负少</span><span style=\"text-wrap-mode: wrap;\">ArticleModel</span><span style=\"text-wrap-mode: wrap;\">胜多负少</span><span style=\"text-wrap-mode: wrap;\">ArticleModel</span></span></p>', '20251126/00833eef85a01cb7b2799e700c51c3a3.jpg', '20251126/123ca4ad4bcc516e35459a718c264a74.mp4', '2025-11-26 17:39:14', '0', '1');
INSERT INTO `article` VALUES ('3', '123', '9', '1234', '123456', '<p>123456789</p>', '', '', '2025-11-29 16:44:23', '0', '1');
INSERT INTO `article` VALUES ('4', '12', '9', '', '', null, '20251129/b8181120c5b48e91fad8c7ff756e199c.jpg', '', '2025-11-29 16:53:20', '0', '1');

-- ----------------------------
-- Table structure for auth_group
-- ----------------------------
DROP TABLE IF EXISTS `auth_group`;
CREATE TABLE `auth_group` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名称id',
  `status` int(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_group
-- ----------------------------
INSERT INTO `auth_group` VALUES ('44', '2', '1', '43,44,45');
INSERT INTO `auth_group` VALUES ('45', '1', '1', '43,44');

-- ----------------------------
-- Table structure for auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `auth_group_access`;
CREATE TABLE `auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of auth_group_access
-- ----------------------------
INSERT INTO `auth_group_access` VALUES ('1', '45');
INSERT INTO `auth_group_access` VALUES ('2', '44');

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '权限名称',
  `name` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '控制器方法路径',
  `type` int(1) NOT NULL DEFAULT '1' COMMENT '级别',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `pid` int(11) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '级别区别，增加的间隙----',
  `sort` int(11) NOT NULL DEFAULT '1',
  `condition` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------
INSERT INTO `auth_rule` VALUES ('44', '配置添加', 'conf/add', '1', '1', '43', '1', '1', null);
INSERT INTO `auth_rule` VALUES ('43', '配置管理', 'conf/index', '1', '1', '0', '0', '1', null);
INSERT INTO `auth_rule` VALUES ('38', '轮播管理', 'lunbo/index', '1', '1', '0', '0', '1', null);
INSERT INTO `auth_rule` VALUES ('42', '轮播修改', 'lunbo/memberedit', '1', '1', '38', '1', '1', null);
INSERT INTO `auth_rule` VALUES ('45', '配置修改', 'conf/update', '1', '1', '43', '1', '1', null);
INSERT INTO `auth_rule` VALUES ('46', '轮播添加', 'lunbo/memberadd', '1', '1', '38', '1', '1', null);

-- ----------------------------
-- Table structure for colum
-- ----------------------------
DROP TABLE IF EXISTS `colum`;
CREATE TABLE `colum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '100',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of colum
-- ----------------------------
INSERT INTO `colum` VALUES ('12', '222', '11', '100', '1');
INSERT INTO `colum` VALUES ('11', '111', '9', '100', '1');
INSERT INTO `colum` VALUES ('9', '1', '0', '100', '1');

-- ----------------------------
-- Table structure for conf
-- ----------------------------
DROP TABLE IF EXISTS `conf`;
CREATE TABLE `conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ename` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL COMMENT '1单行文本框 2多行文本框 3单选按钮 4多选按钮 5下拉菜单',
  `val` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '值',
  `vals` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '可选值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of conf
-- ----------------------------
INSERT INTO `conf` VALUES ('2', '网站关键字', 'keywords', '1', '否', '');
INSERT INTO `conf` VALUES ('3', '清除缓存', 'cache', '5', '1个小时', '1个小时,2个小时,3个小时');
INSERT INTO `conf` VALUES ('4', '是否开启验证码', 'code', '4', '是', '是');
INSERT INTO `conf` VALUES ('5', '是否关闭网站', 'web', '3', '是', '是,否');
INSERT INTO `conf` VALUES ('6', '网站描述', 'des', '2', '网站描述', '');
INSERT INTO `conf` VALUES ('7', '网站标题', 'title', '1', '我的官网', '');

-- ----------------------------
-- Table structure for lunbo
-- ----------------------------
DROP TABLE IF EXISTS `lunbo`;
CREATE TABLE `lunbo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `img` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `video` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `href` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort` int(11) NOT NULL DEFAULT '100',
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of lunbo
-- ----------------------------
INSERT INTO `lunbo` VALUES ('1', '12', '', '20251122/5faf2063f4491cbe7d0ba0254b6cd8bf.mp4', null, '20', '1');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastlogin` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'Null',
  `num` int(11) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2025-11-09 00:00:00', '2025-12-05 18:51:17', '63', '1');
INSERT INTO `user` VALUES ('2', 'text1', 'e10adc3949ba59abbe56e057f20f883e', '2025-11-09 19:40:34', '2025-12-03 17:21:38', '1', '1');
INSERT INTO `user` VALUES ('4', '11', 'e10adc3949ba59abbe56e057f20f883e', '2025-11-22 17:39:31', 'Null', '0', '0');
INSERT INTO `user` VALUES ('5', '123456', 'e10adc3949ba59abbe56e057f20f883e', '2025-11-22 17:49:30', '2025-12-02 19:12:54', '3', '1');
