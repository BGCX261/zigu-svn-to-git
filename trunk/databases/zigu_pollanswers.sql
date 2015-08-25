DROP TABLE IF EXISTS `zigu_pollanswers`;

CREATE TABLE `zigu_pollanswers` (
  `answerId` int(10) NOT NULL auto_increment COMMENT '回答ID',
  `questionId` int(10) NOT NULL COMMENT '问题ID',
  `pollId` int(10) NOT NULL COMMENT '投票ID',
  `itemId` int(10) NOT NULL COMMENT '内容ID',
  `answer` text COMMENT '回答内容',
  `voteIp` char(39) default NULL COMMENT '回答者IP',
  `uid` int(10) default NULL COMMENT '回答者UID',
  `userName` varchar(50) default NULL COMMENT '回答者用户名',
  `pollTime` int(10) default NULL COMMENT '回答时间',
  PRIMARY KEY  (`answerId`),
  KEY `questionId` (`questionId`),
  KEY `pollId` (`pollId`),
  KEY `itemId` (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;