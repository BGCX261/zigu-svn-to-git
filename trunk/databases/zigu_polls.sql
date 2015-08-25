DROP TABLE IF EXISTS `zigu_polls`;
CREATE TABLE `zigu_polls` (
  `pollId` int(10) NOT NULL auto_increment COMMENT '投票id ',
  `pollTitle` char(100) NOT NULL COMMENT '投票标题',
  `limitType` tinyint(1) NOT NULL default '1' COMMENT '投票结果是否可见',
  `pollStatus` enum('draft','online','offline') NOT NULL default 'draft' COMMENT '投票状态（草稿、正式、进行中、关闭）',
  `resultVisiable` tinyint(1) NOT NULL default '1' COMMENT '投票结果是否可见',
  `freezeTime` int(10) unsigned NOT NULL default '0' COMMENT '投票限制时间,对于用户时间限制和ip时间限制，单位为分',
  `startTime` int(10) unsigned NOT NULL default '0' COMMENT '投票开始时间',
  `endTime` int(10) unsigned NOT NULL default '0' COMMENT '投票结束时间',
  `resultDisplayOrder` tinyint(1) NOT NULL default '0' COMMENT '结果排序方法（按录入顺序排序、按票数从高到低、按票数从低到高）',
  `initCount` int(10) unsigned NOT NULL default '0' COMMENT '初始投票人数',
  `template` char(100) default NULL COMMENT '投票模板',
  `customTemplate` tinyint(1) NOT NULL default '0' COMMENT '定制模板',
  `templateUrl` char(50) NOT NULL COMMENT '定制模板url ',
  `createTime` datetime default '1970-01-01 08:00:00' COMMENT '投票开始时间',
  `createUser` varchar(50) default NULL COMMENT '创建者',
  `updateTime` datetime default '1970-01-01 08:00:00' COMMENT '投票开始时间',
  `updateUser` varchar(50) default NULL COMMENT '创建者',
  PRIMARY KEY  (`pollId`),
  KEY `limitType` (`limitType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;