DROP TABLE IF EXISTS `zigu_pollitems`;

CREATE TABLE `zigu_pollitems` (
  `pollId` int(10) NOT NULL COMMENT '投票ID',
  `questionId` int(10) NOT NULL COMMENT '问题ID',
  `itemId` int(10) NOT NULL auto_increment COMMENT '项目ID',
  `name` varchar(50) default NULL COMMENT '唯一标识符',
  `questionType` tinyint(1) NOT NULL default '1' COMMENT '选项类型（单选、多选、文本、文本区域）',
  `title` text NOT NULL COMMENT '项目名称',
  `initCount` int(10) default NULL COMMENT '选项初始选择值',
  `minLength` int(10) default NULL COMMENT '选项输入最小值（对于文本）',
  `maxLength` int(10) default NULL COMMENT '选项输入最大值（对于文本）',
  `fieldType` tinyint(1) default '1' COMMENT '字段类型（整型、文本、浮点）',
  `imgUrl` char(100) default NULL COMMENT '图片URL',
  `itemUrl` char(100) default NULL COMMENT '问题URL',
  PRIMARY KEY  (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;