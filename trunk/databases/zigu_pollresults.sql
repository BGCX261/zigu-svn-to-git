DROP TABLE IF EXISTS `zigu_pollresults`;
CREATE TABLE `zigu_pollresults` (
  `resultId` int(10) NOT NULL auto_increment COMMENT '结果表ID',
  `questionId` int(10) NOT NULL COMMENT '问题ID',
  `pollId` int(10) NOT NULL COMMENT '投票ID',
  `itemId` int(10) NOT NULL COMMENT '内容ID',
  `pollCounts` int(10) NOT NULL default '0' COMMENT '投票数',
  PRIMARY KEY  (`resultId`),
  KEY `questionId` (`questionId`),
  KEY `pollId` (`pollId`),
  KEY `itemId` (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
