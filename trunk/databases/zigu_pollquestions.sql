DROP TABLE IF EXISTS `zigu_pollquestions`;
CREATE TABLE `zigu_pollquestions` (
  `questionId` int(10) NOT NULL auto_increment COMMENT '问题ID',
  `pollId` int(10) NOT NULL COMMENT '投票ID ',
  `name` varchar(50) default NULL COMMENT '唯一标识符,需要定应个规则',
  `title` varchar(255) NOT NULL COMMENT '问题标题',
  `questionType` tinyint(1) NOT NULL default '1' COMMENT '问题类型(1、单选2、多选3、文本4文本区域)',
  `maxMultiOptions` int(10) NOT NULL default '1' COMMENT '多选问题限制数量',
  `required` tinyint(1) NOT NULL default '1' COMMENT '该问题是否必填',
  `questionUrl` char(100) default NULL COMMENT '问题URL',
  `imgUrl` char(100) default NULL COMMENT '图片URL',
  `textField1` text COMMENT '文本字段1',
  `textField2` text COMMENT '文本字段2',
  `numField1` int(10) default NULL COMMENT '数字字段1',
  `numField2` int(10) default NULL COMMENT '数字字段2',
  PRIMARY KEY  (`questionId`),
  KEY `pollId` (`pollId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;